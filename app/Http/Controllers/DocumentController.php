<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Office;
use App\Models\Type;
use App\Models\Action;
use App\Models\PaperTrail;
use Barryvdh\DomPDF\Facade\Pdf;


class DocumentController extends Controller
{
    public function logAction($document, $action, $remarks = null, $file_attach, $drive = null, $in_time = null, $out_time = null)
    {
        // If in_time is not provided, use the current time
        $in_time = $in_time ?? now();

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
    public function downloadPaperTrail($documentId)
    {
        $document = Document::findOrFail($documentId);
        $paperTrails = $document->paperTrails; // Assuming you have a relationship set up

        $pdf = Pdf::loadView('pdf.paperTrail', compact('document', 'paperTrails'));
        return $pdf->download($document->tracking_number.'_paper_trail.pdf');
    }

    public function drs_add(Request $request) {
        session()->flash('tracking_number', $request->input('tracking_number'));
        $offices = Office::all();
        $types = Type::all();
        $actions = Action::all();

        return view('user.add', compact('offices','types','actions'));
    }

    public function addDocument(Request $request) {
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
                $document->designatedOffices()->attach($officeId);
        }
        $this->logAction($document, $request->action, $request->remarks, $document->file_attach, $request->drive, now(), now());
        return redirect()->route('drs-final', ['id' => $document->id])->with('success', 'Document added successfully.');
    }


    public function finalized($id) {
        $document = Document::findOrFail($id);
        $paperTrails = PaperTrail::where('document_id', $document->id)->get();
        return view('user.finalized', compact('document', 'paperTrails'));
    }

    public function forReceived(Request $request) {
    $search = $request->input('search');
    $category = $request->input('category');
    $order = $request->input('order');

    $query = Document::query();

    if ($search) {
        $query->where('tracking_number', 'LIKE', "%{$search}%")
              ->orWhere('originating_office', 'LIKE', "%{$search}%")
              ->orWhere('title', 'LIKE', "%{$search}%")
              ->orWhere('type', 'LIKE', "%{$search}%")
              ->orWhere('action', 'LIKE', "%{$search}%");
    }
    if ($category) {
        $query->orderBy($category, $order);
    }
    // Retrieve the authenticated user
    $user = auth()->user();
    // Retrieve documents designated for the user's office with status 'pending'
    $documents = Document::whereHas('designatedOffices', function ($query) use ($user) {
        $query->where('offices.id', $user->office_id)
              ->where('status', 'pending');
    })->get();

    // Filter out documents that have already been received by the current user's office
    $documents = $documents->filter(function ($document) use ($user) {
        // Exclude documents that have been received by the current user's office
        return !$document->designatedOffices->contains('id', $user->office_id) || $document->status !== 'received';
    });
    $documents = $query->paginate(8);
    // Pass the documents to the view
    return view('user.office.receiving', compact('documents'));
}

    public function receiveDocument($tracking_number, Request $request) {
        // Retrieve the authenticated user
        $user = auth()->user();
        $document = Document::where('tracking_number', $tracking_number)->firstOrFail();
        $paperTrails = PaperTrail::where('document_id', $document->id)->get();
        $document->status = 'received';
        $document->current_office = $request->user()->office->code; // Assuming the user's office is the receiving office
        $document->save();

        // Update the document_office pivot table to mark the document as received by the current user's office
        $document->designatedOffices()->updateExistingPivot($user->office_id, ['status' => 'received']);

        return view('documents.received', compact('document','paperTrails'));
    }


    public function view() {

        return view('user.view');
    }
}
