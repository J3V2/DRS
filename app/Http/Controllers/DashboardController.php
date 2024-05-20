<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackingNumber;
use App\Models\Office;
use App\Models\Action;
use App\Models\PaperTrail;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class DashboardController extends Controller
{
    public function reports() {
        if (Auth::user()->role == 0) {
            return view('admin.reports');
        }
    }

    public function dashboard(Request $request) {
        if (Auth::user()->role == 1) {
            $userId = Auth::id();
            $userOffice = auth()->user()->office->id;
            $unusedTrackingNumbers = TrackingNumber::where('user_id', $userId)
                                           ->where('status', 'Unused')
                                           ->first();

            $forReceive = Document::all();


            $forRelease = Document::all();

            return view('user.dashboard', compact('unusedTrackingNumbers','forReceive','forRelease'));
        }
    }

    public function receive(Request $request){
        $user = auth()->user();
        try {
            $tracking_number = $request->input('tracking_number');
            $document = Document::where('tracking_number', $tracking_number)->firstOrFail();
            $paperTrails = PaperTrail::where('document_id', $document->id)->orderBy('created_at', 'desc')->get();

            // Update the document's current office to the receiving office
            $document->current_office = $request->user()->office->code;
            $document->status = 'received';
            $document->save();

            return view('user.receive',compact('document','paperTrails','tracking_number'))->with('success',$document->title.' - '.$document->tracking_number.' ,has been received successfully. Tag as Terminal, If your office is the end of its paper trail.');
        } catch (ModelNotFoundException $e) {
            return back()->with('error',"We're sorry, but the request is Invalid Input.");
        }
    }

    public function release(Request $request){
        $user = auth()->user();
        try {
            $tracking_number = $request->input('tracking_number');
            $document = Document::where('tracking_number', $tracking_number)->firstOrFail();

            $offices = Office::all();
            $actions = Action::all();

            return view('user.release',compact('offices', 'actions','document','tracking_number'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error',"We're sorry, but the request is Invalid Input.");
        }
    }

    public function tag(Request $request){
        $user = auth()->user();
        try {
            $tracking_number = $request->input('tracking_number');
            $document = Document::where('tracking_number', $tracking_number)->firstOrFail();

            return view('user.tag',compact('document','tracking_number'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error',"We're sorry, but the request is Invalid Input.");
        }
    }

    public function track(Request $request){
        $user = auth()->user();
        try {
            $tracking_number = $request->input('tracking_number');
            $document = Document::where('tracking_number', $tracking_number)->firstOrFail();
            $paperTrails = PaperTrail::where('document_id', $document->id)->orderBy('created_at', 'desc')->get();

            return view('documents.track',compact('document','paperTrails','tracking_number'))->with('success',$document->title.' - '.$document->tracking_number.' ,has been track successfully.');
        } catch (ModelNotFoundException $e) {
            return back()->with('error',"We're sorry, but the request is Invalid Input.");
        }
    }
}
