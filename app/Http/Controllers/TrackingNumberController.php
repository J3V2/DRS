<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\TrackingNumber;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TrackingNumberController extends Controller
{
    public function trackingnumber() {
        $userId = Auth::id();
        $unusedTrackingNumbers = TrackingNumber::where('user_id', $userId)
                                               ->where('status', 'Unused')
                                               ->count();
        $usedTrackingNumbers = TrackingNumber::where('user_id', $userId)
                                             ->where('status', 'Used')
                                             ->count();
        $invalidTrackingNumbers = TrackingNumber::where('user_id', $userId)
                                                 ->where('status', 'Invalid')
                                                 ->count();

        return view('user.my.numbers', compact('unusedTrackingNumbers', 'usedTrackingNumbers', 'invalidTrackingNumbers'));
    }

    public function generateTrackingNumbers(){
        $userId = Auth::id();
        $uniqueTrackingNumbers = [];

        for ($i = 0; $i < 56; $i++) {
            do {
                $year = Carbon::now()->format('Y');
                $date = Carbon::now()->format('dm');
                $time = Carbon::now()->format('Hi');
                $randomNumbers = rand(1000, 9999);

                $trackingNumber = $year . '-' . $date . '-' . $time . '-' . $randomNumbers;

                // Check if the tracking number already exists in the database
                $exists = TrackingNumber::where('tracking_number', $trackingNumber)->exists();
            } while ($exists); // If the tracking number exists, regenerate it

            // If the tracking number is unique, add it to the array
            $uniqueTrackingNumbers[] = $trackingNumber;

            // Create the tracking number in the database
            TrackingNumber::create([
                'tracking_number' => $trackingNumber,
                'status' => 'Unused',
                'user_id' => $userId,
            ]);
        }

        // Optionally, you can return a message or redirect based on the successful creation of tracking numbers
        return redirect()->route('user-my-numbers')->with('success', 'Congratulations! Your tracking numbers has been successfully generated. 🎉 Now you can easily add new documents using this tracking numbers.');
    }

    public function invalidateTrackingNumber(Request $request) {
        // Validate the request to ensure a tracking number is provided
        $request->validate([
            'invalidate' => 'required|string',
        ]);

        // Find the tracking number by the user's input
        $trackingNumber = TrackingNumber::where('tracking_number', $request->invalidate)->first();

        // Check if the tracking number exists and belongs to the current user
        if ($trackingNumber && $trackingNumber->user_id == auth()->id()) {
            // Update the status of the tracking number to "invalid"
            $trackingNumber->update(['status' => 'invalid']);

            return redirect()->route('user-my-numbers')->with('success', 'You have successfully invalidated the tracking number. Please note that this action cannot be undone.');
        } else {
            // If the tracking number does not exist or does not belong to the current user, redirect back with an error message
            return redirect()->back()->with('error', 'The tracking number you entered does not exist or does not belong to you. Please note that this action cannot be undone.');
        }
    }

    public function downloadTrackingNumbers(){
        $userId = Auth::id();
        $trackingNumbers = TrackingNumber::where('user_id', $userId)
                                          ->orderBy('created_at', 'desc')
                                          ->take(56)
                                          ->get();
        $pdf = PDF::loadView('pdf.tracking_numbers', compact('trackingNumbers'));
        return $pdf->download('tracking_numbers.pdf');
    }
}
