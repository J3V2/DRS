<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Office;
use App\Models\Type;
use App\Models\Action;

class DocumentController extends Controller
{
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
            'designated_office' => 'required|array', // Ensure designated_office is an array
            'file_attach' => 'required',
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
    
        return redirect()->route('drs-final', ['id' => $document->id])->with('success', 'Document added successfully.');
    }
    
    
    public function finalized($id) {

        $document = Document::findOrFail($id);
        return view('user.finalized', compact('document'));
    }

    public function forReceived() {
        // Retrieve the authenticated user
        $user = auth()->user();
        // Retrieve documents designated for the user's office with status 'pending'
        $documents = Document::where('designated_office', 'LIKE', '%' . $user->office_id. '%')
                        ->where('status', 'pending')
                        ->get();
        // Pass the documents to the view
        return view('user.office.receiving', compact('documents'));
    }

    public function receiveDocument($tracking_number) {

        $document = Document::where('tracking_number', $tracking_number)->firstOrFail();
        return view('documents.received', compact('document'));
    }
    
    public function view() {

        return view('user.view');
    }
}    
