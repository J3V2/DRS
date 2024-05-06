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

class DocumentController extends Controller
{
    public function logAction($document, $action, $remarks = null, $file_attach, $drive = null, $in_time = null, $out_time = null) {
        // If in_time is not provided, use the current time
        $in_time = $in_time? Carbon::parse($in_time) : now();

        $out_time = $out_time? Carbon::parse($out_time) : null;

        // Calculate elapsed_time if both in_time and out_time are provided
        $elapsed_time = $out_time && $in_time ? $out_time->diffInSeconds($in_time) : null;

        $paperTrail = new PaperTrail([
            'document_id' => $document->id,
            'office' => $document->current_office, // Assuming the current office is the office performing the action
            'action' => $action,
            'remarks' => $remarks,
            'file_attach' => $file_attach,
            'drive' => $drive,
            'in_time' => $in_time,
            'out_time' => $out_time,
            'elapsed_time' => $elapsed_time,
        ]);

        $paperTrail->save();
    }

    public function downloadPaperTrail($documentId) {
        $document = Document::findOrFail($documentId);
        $paperTrails = $document->paperTrails; // Assuming you have a relationship set up

        $pdf = Pdf::loadView('pdf.paperTrail', compact('document', 'paperTrails'));
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
        $in_time = now();
        $request->validate([
            'tracking_number' => 'required|string',
            'title' => 'required',
            'type' => 'required',
            'action' => 'required',
            'originating_office' => 'nullable',
            'current_office' => 'nullable',
            'designated_office' => 'required|array',
            'file_attach' => 'nullable  ',
            'drive' => 'nullable',
            'remarks' => 'nullable',
        ]);

        $document = new Document;
        $document->tracking_number = $request->tracking_number;
        $document->title = $request->title;
        $document->type = $request->type;
        $document->action = $request->action;
        $document->status = 'pending';
        $document->author = $request->user()->name;
        $document->originating_office = $request->user()->office->code;
        $document->current_office = $request->user()->office->code;
        $document->designated_office = implode(',', $request->designated_office);
        $document->drive = $request->drive;
        $document->remarks = $request->remarks;

        // Handle multiple file uploads
        $filePaths = [];
        if ($request->hasFile('file_attach')) {
            foreach ($request->file('file_attach') as $file) {
                $filename = $file->getClientOriginalName();
                $file->storeAs('public/documents', $filename);
                $filePaths[] = $filename;
            }
        }
        $document->file_attach = json_encode($filePaths); // Store file paths as a JSON string
        $document->save();

        // Attach designated offices to the document
        $designatedOffices = $request->input('designated_office');
            foreach ($designatedOffices as $officeId) {
                $document->designatedOffices()->attach($officeId, ['status' => 'pending']);
            }

        $this->logAction($document, $request->action, $request->remarks, $document->file_attach, $request->drive, now(), now());

        // Update the TrackingNumber status to "Used"
        $trackingNumber = TrackingNumber::where('tracking_number', $request->tracking_number)->first();
        if ($trackingNumber) {
            $trackingNumber->status = 'Used';
            $trackingNumber->save();
        }

        return redirect()->route('drs-final', ['id' => $document->id])->with('success',$document->title.' - '. $document->type. ', has been Finalized successfully. Other Office can now process this document.');
    }

    public function finalized($id) {
        $document = Document::findOrFail($id);
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

        // Filter documents designated for the user's office with status 'pending' and not yet received by the user's office
        $query->whereHas('designatedOffices', function ($query) use ($user) {
            $query->where('offices.id', $user->office_id)
                  ->where('status', 'pending');
        })->whereDoesntHave('designatedOffices', function ($query) use ($user) {
            $query->where('offices.id', $user->office_id)
                  ->where('status', 'received');
        });

        // search query to only include documents that meet the specified conditions
        if ($search) {
            $query->where(function ($query) use ($search, $user) {
                $query->whereHas('designatedOffices', function ($query) use ($user) {
                    $query->where('offices.id', $user->office_id)
                          ->where('status', 'pending');
                })->whereDoesntHave('designatedOffices', function ($query) use ($user) {
                    $query->where('offices.id', $user->office_id)
                          ->where('status', 'received');
                })->where('tracking_number', 'LIKE', "%{$search}%")
                      ->orWhere('originating_office', 'LIKE', "%{$search}%")
                      ->orWhere('title', 'LIKE', "%{$search}%")
                      ->orWhere('type', 'LIKE', "%{$search}%")
                      ->orWhere('action', 'LIKE', "%{$search}%");
            });
        }

        // category and order filters
        if ($category) {
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
        $document = Document::where('tracking_number', $tracking_number)->firstOrFail();
        $paperTrails = PaperTrail::where('document_id', $document->id)->orderBy('created_at', 'desc')->get();

        // Update the document's current office to the receiving office
        $document->current_office = $request->user()->office->code;
        $document->save();

        // Update the document_office pivot table to mark the document as received by the current user's office
        $document->designatedOffices()->updateExistingPivot($user->office_id, ['status' => 'received']);

        // Check if all designated offices have received the document
        $allOfficesReceived = $document->designatedOffices()->wherePivot('status', 'received')->count() == $document->designatedOffices()->count();

        // Update the document's status to 'received' if all designated offices have received it
        if ($allOfficesReceived) {
            $document->status = 'received';
            $document->save();
        }

        return view('documents.received', compact('document','paperTrails'))->with('success',$document->title.' - '.$document->tracking_number.' ,has been received successfully. Tag as Terminal, If your office is the end of its paper trail.');
    }

    public function forReleased(Request $request) {
        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $query = Document::query();

        // Retrieve the authenticated user
        $user = auth()->user();

        // Filter documents designated for the user's office with status 'received' and not yet received by the user's office
        $query->whereHas('designatedOffices', function ($query) use ($user) {
            $query->where('offices.id', $user->office_id)
                  ->where('status', 'received');
        })->whereDoesntHave('designatedOffices', function ($query) use ($user) {
            $query->where('offices.id', $user->office_id)
                  ->where('status', 'pending');
        });

        if ($search) {
            $query->where(function ($query) use ($search, $user) {
                $query->whereHas('designatedOffices', function ($query) use ($user) {
                    $query->where('offices.id', $user->office_id)
                          ->where('status', 'received');
                })->whereDoesntHave('designatedOffices', function ($query) use ($user) {
                    $query->where('offices.id', $user->office_id)
                          ->where('status', 'pending');
                })->where('tracking_number', 'LIKE', "%{$search}%")
                      ->orWhere('originating_office', 'LIKE', "%{$search}%")
                      ->orWhere('title', 'LIKE', "%{$search}%")
                      ->orWhere('type', 'LIKE', "%{$search}%")
                      ->orWhere('action', 'LIKE', "%{$search}%");
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
        $document = Document::where('tracking_number', $tracking_number)->firstOrFail();
        $offices = Office::all();
        $actions = Action::all();

        return view('user.release',compact('offices', 'actions','document','tracking_number'));
    }

    public function releaseDocument(Request $request, $tracking_number) {
        $user = auth()->user();
        $document = Document::where('tracking_number', $tracking_number)->firstOrFail();

        $request->validate([
            'action' => 'required',
            'designated_office' => 'required|array',
            'file_attach' => 'nullable',
            'drive' => 'nullable',
            'remarks' => 'nullable',
        ]);

        $document->update([
            'action' => $request->action,
            'designated_office' => implode(',', $request->designated_office), // Assuming this is an array of IDs
            'drive' => $request->drive,
            'remarks' => $request->remarks,
        ]);

        $filePaths = [];
        if ($request->hasFile('file_attach')) {
            foreach ($request->file('file_attach') as $file) {
                $filename = $file->getClientOriginalName();
                $file->storeAs('public/documents', $filename);
                $filePaths[] = $filename;
            }
        }
        $document->file_attach = json_encode($filePaths);

        $document->save();

        $document->designatedOffices()->updateExistingPivot($user->office_id, ['status' => 'pending']);

        // Mark the document as released by the current office
        $designatedOffices = $request->input('designated_office');
        foreach ($designatedOffices as $officeId) {
            $document->designatedOffices()->attach($officeId, ['status' => 'pending']);
        }

        $allOfficesReleased = $document->designatedOffices()->wherePivot('status', 'pending')->count() == $document->designatedOffices()->count();

        // Update the document's status to 'received' if all designated offices have received it
        if ($allOfficesReleased) {
            $document->status = 'pending';
            $document->save();
        }

        $this->logAction($document, $request->action, $request->remarks, $document->file_attach, $request->drive, $document->in_time, now());
        return redirect()->route('final-release', ['id' => $document->id])->with('success',$document->title.' - '.$document->type. ', has been released successfully.');
    }

    public function finalizedReleased($id) {
        $document = Document::findOrFail($id);
        $paperTrails = PaperTrail::where('document_id', $document->id)->orderBy('created_at', 'desc')->get();

        return view('documents.released',compact('document','paperTrails'));
    }

    public function drs_tag($tracking_number){

        $document = Document::where('tracking_number', $tracking_number)->firstOrFail();

        return view('user.tag',compact('document'));
    }

    public function tagDocument(Request $request, $tracking_number) {
        $document = Document::where('tracking_number', $tracking_number)->firstOrFail();

        return redirect()->route('final-release', ['id' => $document->id])->with('success',$document->title.' - '.$document->type. ', has been tag as terminal successfully.');
    }

}
