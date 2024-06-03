<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use App\Models\Office;
use App\Models\Type;
use App\Models\Action;
use App\Models\PaperTrail;
use App\Models\TrackingNumber;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Events\DocumentCreated;
use App\Events\DocumentReleased;
use App\Events\DocumentReceived;
use App\Events\DocumentTaggedAsTerminal;

class DocumentController extends Controller
{
    public function logAction($document, $action, $remarks = null, $file_attach, $drive = null, $in_time, $out_time, $elapsed_time_human) {
        // If in_time is not provided, use the current time
        $in_time = $in_time ? Carbon::parse($in_time) : now();

        $out_time = $out_time ? Carbon::parse($out_time) : null;

        // Calculate elapsed_time if both in_time and out_time are provided
        $elapsed_time = $out_time && $in_time ? $out_time->diffInSeconds($in_time) : null;
        $elapsed_time_human = $elapsed_time ? Carbon::now()->subSeconds($elapsed_time)->diffForHumans() : null;

        $paperTrail = new PaperTrail([
            'document_id' => $document->id,
            'office' => $document->current_office,
            'to_office' => $document->designated_office,
            'action' => $action,
            'remarks' => $remarks,
            'file_attach' => $file_attach,
            'drive' => $drive,
            'in_time' => $in_time,
            'out_time' => $out_time,
            'elapsed_time' => $elapsed_time_human,
        ]);

        $paperTrail->save();
    }

    public function downloadPaperTrail($documentId) {
        $user = auth()->user();
        $document = Document::findOrFail($documentId);
        $paperTrails = $document->paperTrails()->with('toOffice')->get();

        $pdf = Pdf::loadView('pdf.paperTrail', compact('document', 'paperTrails','user'));
        return $pdf->download($document->tracking_number.'_paper_trail.pdf');
    }

    public function drs_add(Request $request) {
        $userId = Auth::id();
        $tracking_number = $request->input('tracking_number');

        $offices = Office::all();
        $types = Type::all();
        $actions = Action::all();
        $unusedTrackingNumbers = TrackingNumber::where('user_id', $userId)
                                               ->where('status', 'Unused')->get();

        if ($unusedTrackingNumbers->count() > 0) {
            $tracking_number = $unusedTrackingNumbers->first()->tracking_number;
        } else {
            $tracking_number = null;
        }

        return view('user.add', compact('offices','types','actions','tracking_number'));
    }

    public function addDocument(Request $request) {
        $user = auth()->user();
        $request->validate([
            'tracking_number' => 'required|string',
            'title' => 'required',
            'type' => 'required',
            'action' => 'required',
            'originating_office' => 'nullable',
            'current_office' => 'nullable',
            'designated_office' => 'required|array',
            'file_attach' => 'nullable',
            'drive' => 'nullable',
            'remarks' => 'nullable',
        ]);

        // Check if there are enough unused tracking numbers for all designated offices
        $numDesignatedOffices = count($request->designated_office);
        $unusedTrackingNumbers = TrackingNumber::where('status', 'Unused')->count();

        if ($numDesignatedOffices > $unusedTrackingNumbers) {
            return redirect()->back()->with('error', 'There are not enough unused tracking numbers to accommodate all designated offices.');
        }

        // Proceed if there are enough tracking numbers
        $filePaths = [];
        $in_time = now();
        $out_time = now();
        $elapsed_time_human = null;

        // Handle multiple file uploads
        if ($request->hasFile('file_attach')) {
            foreach ($request->file('file_attach') as $file) {
                $filename = $file->getClientOriginalName();
                $file->storeAs('public/documents', $filename);
                $filePaths[] = $filename;
            }
        }

        foreach ($request->designated_office as $officeId) {
            // Assign a unique tracking number to each designated office
            $trackingNumber = TrackingNumber::where('user_id',$user->id)
            ->where('status', 'Unused')->first();
            if (!$trackingNumber) {
                return redirect()->route('user-dashboard')->with('error', 'There are not enough unused tracking numbers to accommodate all designated offices.');
            }
            $trackingNumber->status = 'Used';
            $trackingNumber->save();

            $document = new Document;
            $document->tracking_number = $trackingNumber->tracking_number;
            $document->title = $request->title;
            $document->type = $request->type;
            $document->action = $request->action;
            $document->status = 'released';
            $document->released_by = $user->id;
            $document->author = $request->user()->name;
            $document->originating_office = $request->user()->office->code;
            $document->current_office = $request->user()->office->code;
            $document->designated_office = $officeId;
            $document->drive = $request->drive;
            $document->remarks = $request->remarks;
            $document->created_at = now();
            $document->file_attach = json_encode($filePaths); // Store file paths as a JSON string
            $document->save();

            event(new DocumentCreated($document, $user->id, now(), [$request->user()->office->code]));
            event(new DocumentReleased($document, $user->id, now(), [$officeId], $request->user()->office->id));

            // Log action for each document
            $this->logAction($document, $request->action, $request->remarks, $document->file_attach, $request->drive, $in_time, $out_time, $elapsed_time_human);
        }

        return redirect()->route('drs-final', ['id' => $document->id])->with('success', 'Documents have been finalized successfully. Other offices can now process these documents.');
    }

    public function finalized($id) {
        $document = Document::with('designatedOffice')->findOrFail($id);
        $paperTrails = PaperTrail::where('document_id', $document->id)->orderBy('created_at', 'desc')->get();

        return view('user.finalized', compact('document', 'paperTrails'));
    }

    public function forReceived(Request $request) {
        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $query = Document::query();

        // Retrieve the authenticated user
        $user = auth()->user();

        // Ensure currentUserOfficeId is defined here so it's accessible throughout the method
        $currentUserOfficeId = $user->office_id?? null;

        // Filter documents where the current user's office is the designated_office and the status is 'released'
        if ($currentUserOfficeId) {
            $query->whereHas('paperTrails', function ($query) use ($currentUserOfficeId) {
                $query->where('designated_office', '=', $currentUserOfficeId)
                      ->where('status', '=', 'released');
            });
        }

        // Search functionality
        if ($search) {
            $query->where(function ($query) use ($search, $currentUserOfficeId) {
                $query->whereHas('paperTrails', function ($query) use ($search, $currentUserOfficeId) {
                    $query->where('designated_office', '=', $currentUserOfficeId)
                          ->where('status', '=', 'released')
                          ->where('tracking_number', 'LIKE', "%{$search}%")
                          ->orWhere('originating_office', 'LIKE', "%{$search}%")
                          ->orWhere('title', 'LIKE', "%{$search}%")
                          ->orWhere('type', 'LIKE', "%{$search}%")
                          ->orWhere('action', 'LIKE', "%{$search}%");
                });
            });
        }

        // Apply category and order filters if provided
        if ($category && $order) {
            $query->orderBy($category, $order);
        }

        // Paginate the results
        $documents = $query->paginate(10);

        // Pass the documents to the view
        return view('user.office.receiving', compact('documents'));
    }

    public function receiveDocument($tracking_number, Request $request) {
        // Retrieve the authenticated user
        $user = auth()->user();
        $document = Document::where('tracking_number', $tracking_number)->with('designatedOffice')->firstOrFail();

        $paperTrails = PaperTrail::where('document_id', $document->id)->orderBy('created_at', 'desc')->get();

        // Update the document's current office to the receiving office
        $document->created_at = now();
        $document->current_office = $request->user()->office->code;
        $document->status = 'received';
        $document->received_by = $user->id;
        $document->save();

        event(new DocumentReceived($document, $user->id, now(), $request->user()->office->code));

        return view('documents.received', compact('document','paperTrails'))->with('success',$document->title.' - '.$document->tracking_number.' ,has been received successfully. Tag as Terminal, If your office is the end of its paper trail.');
    }

    public function forReleased(Request $request) {
        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $query = Document::query();

        // Retrieve the authenticated user
        $user = auth()->user();

        // Ensure currentUserOfficeId is defined here so it's accessible throughout the method
        $currentUserOfficeId = $user->office_id?? null;

        // Filter documents where the current user's office is the designated_office and the status is 'released'
        if ($currentUserOfficeId) {
            $query->whereHas('paperTrails', function ($query) use ($currentUserOfficeId) {
                $query->where('designated_office', '=', $currentUserOfficeId)
                      ->where('status', '=', 'received');
            });
        }

        // Search functionality
        if ($search) {
            $query->where(function ($query) use ($search, $currentUserOfficeId) {
                $query->whereHas('paperTrails', function ($query) use ($search, $currentUserOfficeId) {
                    $query->where('designated_office', '=', $currentUserOfficeId)
                          ->where('status', '=', 'received')
                          ->where('tracking_number', 'LIKE', "%{$search}%")
                          ->orWhere('originating_office', 'LIKE', "%{$search}%")
                          ->orWhere('title', 'LIKE', "%{$search}%")
                          ->orWhere('type', 'LIKE', "%{$search}%")
                          ->orWhere('action', 'LIKE', "%{$search}%");
                });
            });
        }

        if ($category) {
            $query->orderBy($category, $order);
        }

        // Paginate the results
        $documents = $query->paginate(10);

        return view('user.office.releasing', compact('documents'));
    }

    public function drs_release(Request $request, $tracking_number) {
        $document = Document::where('tracking_number', $tracking_number)->with('designatedOffice')->firstOrFail();
        $offices = Office::all();
        $actions = Action::all();

        return view('user.release',compact('offices', 'actions','document','tracking_number'));
    }

    public function releaseDocument(Request $request, $tracking_number) {
        $user = auth()->user();
        $originalDocument = Document::where('tracking_number', $tracking_number)->with('designatedOffice')->firstOrFail();

        $request->validate([
            'action' => 'required',
            'designated_office' => 'required|array',
            'file_attach' => 'nullable',
            'drive' => 'nullable',
            'remarks' => 'nullable',
        ]);

        // Get the in_time and out_time
        $in_time = $originalDocument->created_at;
        $out_time = now();
        // Calculate elapsed_time_human
        $elapsed_time = $out_time->diffInSeconds($in_time);
        $elapsed_time_human = $elapsed_time ? Carbon::now()->subSeconds($elapsed_time)->diffForHumans() : null;

        $filePaths = [];
        if ($request->hasFile('file_attach')) {
            foreach ($request->file('file_attach') as $file) {
                $filename = $file->getClientOriginalName();
                $file->storeAs('public/documents', $filename);
                $filePaths[] = $filename;
            }
        }

        // Update the original document for the first designated office
        $originalDocument->update([
            'action' => $request->action,
            'designated_office' => $request->designated_office[0],
            'drive' => $request->drive,
            'status' => 'released',
            'remarks' => $request->remarks,
            'file_attach' => json_encode($filePaths),
            'released_by' => $user->id,
            'created_at' => now(),
        ]);
        // Log the action for the original document
        $this->logAction($originalDocument, $request->action, $request->remarks, $originalDocument->file_attach, $request->drive, $in_time, $out_time, $elapsed_time_human);

        // Handle other designated offices
        $designatedOffices = $request->input('designated_office');
        for ($i = 1; $i < count($designatedOffices); $i++) {
            // Assign a new tracking number to the new document
            $trackingNumber = TrackingNumber::where('user_id',$user->id)
            ->where('status', 'Unused')->first();
            if (!$trackingNumber) {
                return redirect()->route('user-dashboard')->with('error', 'There are not enough unused tracking numbers to accommodate all designated offices.');
            }
            $trackingNumber->status = 'Used';
            $trackingNumber->save();

            // Create a new document for the designated office
            $newDocument = $originalDocument->replicate();
            $newDocument->tracking_number = $trackingNumber->tracking_number;
            $newDocument->designated_office = $designatedOffices[$i];
            $newDocument->status = 'released';
            $newDocument->released_by = $user->id;
            $newDocument->created_at = now();
            $newDocument->save();

            // Copy paper trails from the original document
            foreach ($originalDocument->paperTrails as $paperTrail) {
                $newPaperTrail = $paperTrail->replicate();
                $newPaperTrail->document_id = $newDocument->id;
                $newPaperTrail->save();
            }

            event(new DocumentReleased($newDocument, $user->id, now(), [$designatedOffices[$i]],$request->user()->office->id));
            // Log the action for the new document
            $this->logAction($newDocument, $request->action, $request->remarks, $newDocument->file_attach, $request->drive, $in_time, $out_time, $elapsed_time_human);
        }

        return redirect()->route('final-release', ['id' => $originalDocument->id])->with('success', $originalDocument->title . ' - ' . $originalDocument->type . ', has been released successfully.');
    }

    public function finalizedReleased($id) {
        $document = Document::with('designatedOffice')->findOrFail($id);
        $paperTrails = PaperTrail::where('document_id', $document->id)->orderBy('created_at', 'desc')->get();

        return view('documents.released',compact('document','paperTrails'));
    }

    public function tagTerminal(Request $request) {
        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $query = Document::query();

        // Retrieve the authenticated user
        $user = auth()->user();

        // Ensure currentUserOfficeId is defined here so it's accessible throughout the method
        $currentUserOfficeId = $user->office_id?? null;

        // Filter documents where the current user's office is the designated_office and the status is 'released'
        if ($currentUserOfficeId) {
            $query->whereHas('paperTrails', function ($query) use ($currentUserOfficeId) {
                $query->where('designated_office', '=', $currentUserOfficeId)
                      ->where('status', '=', 'terminal');
            });
        }

        // Search functionality
        if ($search) {
            $query->where(function ($query) use ($search, $currentUserOfficeId) {
                $query->whereHas('paperTrails', function ($query) use ($search, $currentUserOfficeId) {
                    $query->where('designated_office', '=', $currentUserOfficeId)
                          ->where('status', '=', 'terminal')
                          ->where('tracking_number', 'LIKE', "%{$search}%")
                          ->orWhere('originating_office', 'LIKE', "%{$search}%")
                          ->orWhere('title', 'LIKE', "%{$search}%")
                          ->orWhere('type', 'LIKE', "%{$search}%")
                          ->orWhere('action', 'LIKE', "%{$search}%");
                });
            });
        }

        // category and order filters
        if ($category) {
            $query->orderBy($category, $order);
        }

        // Paginate the results
        $documents = $query->paginate(10);

        return view('user.office.terminal',compact('documents'));
    }

    public function drs_tag($tracking_number){

        $document = Document::where('tracking_number', $tracking_number)->with('designatedOffice')->firstOrFail();

        return view('user.tag',compact('document'));
    }

    public function tagDocument(Request $request, $tracking_number) {
        $user = auth()->user();
        $document = Document::where('tracking_number', $tracking_number)->with('designatedOffice')->firstOrFail();
        // Get the in_time and out_time
        $in_time = $document->created_at;
        $out_time = now();
        // Calculate elapsed_time_human
        $elapsed_time = $out_time->diffInSeconds($in_time);
        $elapsed_time_human = $elapsed_time? Carbon::now()->subSeconds($elapsed_time)->diffForHumans() : null;

        $document->created_at = now();
        $document->current_office = $request->user()->office->code;
        $document->status = 'terminal';
        $document->terminal_by = $user->id;
        $document->remarks = $request->remarks;
        $document->save();

        event(new DocumentTaggedAsTerminal($document, $user->id, now(), $request->user()->office->code));

        $this->logAction($document, $document->action, $request->remarks, $document->file_attach, $document->drive, $in_time, $out_time, $elapsed_time_human);

        return redirect()->route('final-release', ['id' => $document->id])->with('success',$document->title.' - '.$document->type. ', has been tag as terminal successfully.');
    }

    public function viewTag($id) {
        $document = Document::where('id', $id)->with('designatedOffice')->firstOrFail();
        $paperTrails = PaperTrail::where('document_id', $document->id)->orderBy('created_at', 'desc')->get();

        return view('documents.terminal',compact('document','paperTrails'));
    }

    public function drs_users(Request $request) {
        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $user = auth()->user();
        $officeId = $user->office_id;

        // Start building the query to retrieve users of the same office with role 1
        $query = User::whereHas('office', function ($query) use ($officeId) {
            $query->where('id', $officeId)
                  ->where('role', 1);
        });

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'LIKE', "%{$search}%")
                ->where('name', 'LIKE', "%{$search}%")
                ->where('created_at', 'LIKE', "%{$search}%")
                ->where('FirstLogin', 'LIKE', "%{$search}%")
                  ->orWhere('LastLogin', 'LIKE', "%{$search}%");
            });
        }

        // Apply category and order filters if provided
        if ($category && $order) {
            $query->orderBy($category, $order);
        }

        $users = $query->paginate(10);

        // Array to store the document counts for each user
        $documentCounts = [];

        // Loop through each user to get their document counts
        foreach ($users as $user) {
            $documentCounts[$user->id] = [
                'created' => Document::where('author', $user->name)->count(),
                'received' => Document::where('received_by', $user->id)->count(),
                'released' => Document::where('released_by', $user->id)->count(),
                'terminal' => Document::where('terminal_by', $user->id)->count(),
            ];
        }

        return view('user.office.guides', compact('users', 'documentCounts'));
    }

    public function office_docs(Request $request) {
        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        // Retrieve the authenticated user
        $user = auth()->user();

        // Retrieve the user's office
        $office = $user->office;

        // Get all user IDs in the office
        $officeUserIds = $office->users()->pluck('id');

        // Start building the query to retrieve documents processed by users in the office
        $query = Document::query();

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'LIKE', "%{$search}%")
                  ->orWhere('current_office', 'LIKE', "%{$search}%")
                  ->orWhere('title', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%");
            });
        }

        // Apply category and order filters if provided
        if ($category && $order) {
            $query->orderBy($category, $order);
        }

        // Filter documents that have been processed by any user in the office
        $query->where(function ($q) use ($officeUserIds) {
            $q->whereIn('received_by', $officeUserIds)
              ->orWhereIn('released_by', $officeUserIds)
              ->orWhereIn('terminal_by', $officeUserIds);
        });
        $query->orWhere('author', $user->name);
        // Paginate the results
        $documents = $query->paginate(10);

        // Add additional information for each document
        foreach ($documents as $document) {
            $received = $officeUserIds->contains($document->received_by);
            $released = $officeUserIds->contains($document->released_by);
            $terminal = $officeUserIds->contains($document->terminal_by);

            $document->processed_by_office = [
                'received' => $received,
                'released' => $released,
                'terminal' => $terminal,
            ];

            // Calculate process time
            if ($received) {
                $receivedTime = $document->created_at;  // Assuming this is when it was received
                if ($released) {
                    $releasedTime = $document->updated_at;  // Assuming this is when it was released
                    $document->process_time = $receivedTime->diffForHumans($releasedTime);
                } elseif ($terminal) {
                    $terminalTime = $document->updated_at;  // Assuming this is when it was tagged terminal
                    $document->process_time = $receivedTime->diffForHumans($terminalTime);
                } else {
                    $document->process_time = 'In Process';
                }
            } else {
                $document->process_time = 'Not Received';
            }
        }

        return view('user.office.docs', compact('documents'));
    }

    public function officeReports(Request $request) {

        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');
        // Retrieve the authenticated user
        $user = auth()->user();

        // Get the office ID of the authenticated user
        $office = $user->office;

        // Assume getAverageProcessingTime() is a method you've defined in the Office model
        $averageProcessingTime = $office->getAverageProcessingTime();

        // Count documents by status for all users of the current office
        $releasedCount = $office->documentsReleasedCount();
        $receivedCount = $office->documentsReceivedCount();
        $terminalCount = $office->documentsTerminalCount();

        // Correctly count documents created by all users of the current office
        $createdCount = Document::where('originating_office', $office->code)->count();

        return view('user.office.reports', compact(
            'averageProcessingTime',
            'releasedCount',
            'receivedCount',
            'terminalCount',
            'createdCount'
        ));
    }

    public function myDocs(Request $request) {
        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $user = auth()->user();

        // Start building the query to retrieve documents processed by the user
        $query = Document::query();

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'LIKE', "%{$search}%")
                  ->orWhere('originating_office', 'LIKE', "%{$search}%")
                  ->orWhere('current_office', 'LIKE', "%{$search}%")
                  ->orWhere('title', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%")
                  ->orWhere('action', 'LIKE', "%{$search}%")
                  ->orWhere('remarks', 'LIKE', "%{$search}%");
            });
        }

        // Apply category and order filters if provided
        if ($category && $order) {
            $query->orderBy($category, $order);
        }

        // Filter documents that have been processed by the current user
        $query->where(function ($q) use ($user) {
            $q->where('received_by', $user->id)
              ->orWhere('released_by', $user->id)
              ->orWhere('terminal_by', $user->id)
              ->orWhere('author', $user->name);
        });

        // Paginate the results
        $documents = $query->paginate(10);

        return view('user.my.docs', compact('documents'));
    }

    public function view($tracking_number) {
        $document = Document::where('tracking_number', $tracking_number)->with('designatedOffice')->firstOrFail();
        $paperTrails = PaperTrail::where('document_id', $document->id)->orderBy('created_at', 'desc')->get();

        return view('documents.view', compact('document','paperTrails'));
    }

    public function myReceived(Request $request) {
        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $user = auth()->user();

        $query = Document::query();


        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'LIKE', "%{$search}%")
                  ->orWhere('originating_office', 'LIKE', "%{$search}%")
                  ->orWhere('current_office', 'LIKE', "%{$search}%")
                  ->orWhere('title', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%")
                  ->orWhere('action', 'LIKE', "%{$search}%")
                  ->orWhere('remarks', 'LIKE', "%{$search}%");
            });
        }

        // Apply category and order filters if provided
        if ($category && $order) {
            $query->orderBy($category, $order);
        }

        // Filter documents that have been processed by the current user
        $query->where('status', 'received')
              ->where('received_by', $user->id);

        $documents = $query->paginate(10);
        return view('user.my.received', compact('documents'));
    }

    public function myReleased (Request $request){
        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $user = auth()->user();

        // Start building the query to retrieve documents processed by the user
        $query = Document::query();

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'LIKE', "%{$search}%")
                  ->orWhere('originating_office', 'LIKE', "%{$search}%")
                  ->orWhere('current_office', 'LIKE', "%{$search}%")
                  ->orWhere('title', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%")
                  ->orWhere('action', 'LIKE', "%{$search}%")
                  ->orWhere('remarks', 'LIKE', "%{$search}%");
            });
        }

        // Apply category and order filters if provided
        if ($category && $order) {
            $query->orderBy($category, $order);
        }

        // Filter documents that have been processed by the current user
        $query->where(function ($q) use ($user) {
            $q->where('released_by', $user->id);
        });

        // Paginate the results
        $documents = $query->paginate(10);

        return view('user.my.released', compact('documents'));
    }

    public function myTag(Request $request){
        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $user = auth()->user();

        // Start building the query to retrieve documents processed by the user
        $query = Document::query();

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'LIKE', "%{$search}%")
                  ->orWhere('originating_office', 'LIKE', "%{$search}%")
                  ->orWhere('current_office', 'LIKE', "%{$search}%")
                  ->orWhere('title', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%")
                  ->orWhere('action', 'LIKE', "%{$search}%")
                  ->orWhere('remarks', 'LIKE', "%{$search}%");
            });
        }

        // Apply category and order filters if provided
        if ($category && $order) {
            $query->orderBy($category, $order);
        }

        // Filter documents that have been processed by the current user
        $query->where(function ($q) use ($user) {
            $q->where('terminal_by', $user->id);
        });

        // Paginate the results
        $documents = $query->paginate(10);
        return view('user.my.terminal', compact('documents'));
    }

    public function myReports() {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Count documents by status for the current user
        $createdCount = Document::where('author', $user->name)->count();
        $releasedCount = Document::where('released_by',$user->id)->count();
        $receivedCount = Document::where('received_by',$user->id)->count();
        $terminalCount = Document::where('terminal_by',$user->id)->count();

        // Return the counts as an array
        return view('user.my.reports',compact('createdCount', 'releasedCount', 'receivedCount', 'terminalCount','user'));
    }

    public function drs_guide() {
        return view('user.guides');
    }

}
