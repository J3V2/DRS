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
        return redirect()->route('user-my-numbers')->with('success', 'Tracking numbers generated successfully');
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
