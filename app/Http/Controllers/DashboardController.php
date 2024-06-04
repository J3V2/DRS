<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackingNumber;
use App\Models\Office;
use App\Models\Action;
use App\Models\PaperTrail;
use App\Models\User;
use App\Events\DocumentReceived;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function reports(Request $request) {
        if (Auth::user()->role == 0) {
            $category = $request->input('category');
            $order = $request->input('order');
            $datetime = $request->input('datetime');

            $query = User::query();

            if ($datetime) {
                $datetime = Carbon::parse($datetime)->format('Y-m-d H:i:s');
                $query->where(function ($q) use ($datetime) {
                    $q->where('updated_at', '>=', $datetime)
                      ->orWhere('current_login_at', '>=', $datetime)
                      ->orWhere('last_logout_at', '>=', $datetime)
                      ->orWhere('FirstLogin', '>=', $datetime)
                      ->orWhere('LastLogin', '>=', $datetime);
                });
            }

            if ($category) {
                $query->orderBy($category, $order);
            }

            $users = $query->paginate(10);

            foreach ($users as $user) {
                $user->documents_created_count = Document::where('author', $user->name)->count();
                $user->documents_received_count = Document::where('received_by', $user->id)->count();
                $user->documents_released_count = Document::where('released_by', $user->id)->count();
                $user->documents_terminal_count = Document::where('terminal_by', $user->id)->count();
            }

            return view('admin.reports', compact('users'));
        }
    }

    public function dashboard(Request $request) {
        if (Auth::user()->role == 1) {
            $user = auth()->user();
            $userOffice = auth()->user()->office->id;
            $unusedTrackingNumbers = TrackingNumber::where('user_id', $user->id)
                                           ->where('status', 'Unused')
                                           ->first();

            $currentUserOfficeId = $user->office_id?? null;
            $forReceive = Document::whereHas('paperTrails', function ($query) use ($currentUserOfficeId) {
                $query->where('designated_office', '=', $currentUserOfficeId)
                      ->where('status', '=', 'released');
            })->get();


            $forRelease = Document::whereHas('paperTrails', function ($query) use ($currentUserOfficeId) {
                $query->where('designated_office', '=', $currentUserOfficeId)
                      ->where('status', '=', 'received');
            })->get();

            return view('user.dashboard', compact('unusedTrackingNumbers','forReceive','forRelease'));
        }
    }

    public function receive(Request $request){
        $user = auth()->user();
        try {
            $tracking_number = $request->input('tracking_number');
            $document = Document::where('tracking_number', $tracking_number)->with('designatedOffice')->firstOrFail();
            $paperTrails = PaperTrail::where('document_id', $document->id)->orderBy('created_at', 'desc')->get();

            // Check if the document has already been received by the user's office
            if ($document->status == 'received' && $document->current_office == $user->office->code) {
                return back()->with('error', "This document has already been received by your office.");
            }

            // Check if the document is designated to the current user's office
            if ($document->designated_office != $user->office_id) {
                return back()->with('error', "This document is not designated to your office.");
            }

            // Update the document's current office to the receiving office
            $document->created_at = now();
            $document->current_office = $request->user()->office->code;
            $document->status = 'received';
            $document->received_by = $user->id;
            $document->save();
            event(new DocumentReceived($document, $user->id, now(), $request->user()->office->code));

            return view('user.receive',compact('document','paperTrails','tracking_number'))->with('success',$document->title.' - '.$document->tracking_number.' ,has been received successfully. Tag as Terminal, If your office is the end of its paper trail.');
        } catch (ModelNotFoundException $e) {
            return back()->with('error',"We're sorry, but the request is Invalid Input.");
        }
    }

    public function release(Request $request){
        $user = auth()->user();
        try {
            $tracking_number = $request->input('tracking_number');
            $document = Document::where('tracking_number', $tracking_number)->with('designatedOffice')->firstOrFail();

            if ($document->status != 'received' && $document->designated_office == $user->office_id) {
                return back()->with('error', "This document can't be released need to received first.");
            }

            // Check if the document is designated to the current user's office
            if ($document->designated_office != $user->office_id) {
                return back()->with('error', "This document is not designated to your office.");
            }

            $offices = Office::where('office_status', 1)->get();
            $actions = Action::where('action_status', 1)->get();

            return view('user.release',compact('offices', 'actions','document','tracking_number'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error',"We're sorry, but the request is Invalid Input.");
        }
    }

    public function tag(Request $request){
        $user = auth()->user();
        try {
            $tracking_number = $request->input('tracking_number');
            $document = Document::where('tracking_number', $tracking_number)->with('designatedOffice')->firstOrFail();

            if ($document->status != 'received' && $document->designated_office == $user->office_id) {
                return back()->with('error', "This document can't be tag as terminal need to received first.");
            }

            // Check if the document is designated to the current user's office
            if ($document->designated_office != $user->office_id) {
                return back()->with('error', "This document is not designated to your office.");
            }

            return view('user.tag',compact('document','tracking_number'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error',"We're sorry, but the request is Invalid Input.");
        }
    }

    public function track(Request $request){
        $user = auth()->user();
        try {
            $tracking_number = $request->input('tracking_number');

            // Retrieve the document by tracking number
            $document = Document::where('tracking_number', $tracking_number)
                                ->firstOrFail();

            // Retrieve the paper trails for the document, ordered by creation date
            $paperTrails = PaperTrail::where('document_id', $document->id)
                                     ->orderBy('created_at', 'desc')
                                     ->get();

            // Get the user's office code
            $officeCode = $user->office->code;

            // Check if any of the paper trails have the user's office code
            $processedInOffice = $paperTrails->contains('office', $officeCode);

            // Check if the user is the author or the document's originating office matches the user's office
            $isAuthorOrOfficeAuthor = $document->author == $user->name || $document->originating_office == $officeCode
                                    || $document->current_office == $officeCode;

            // If none of the conditions are met, return an error
            if (!$processedInOffice && !$isAuthorOrOfficeAuthor) {
                return back()->with('error', "This document is not processed in your office.");
            }

            // Return the track view with the document details
            return view('documents.track', compact('document', 'paperTrails', 'tracking_number'))
                   ->with('success', $document->title.' - '.$document->tracking_number.' has been tracked successfully.');
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "We're sorry, but the request is invalid.");
        }
    }
}
