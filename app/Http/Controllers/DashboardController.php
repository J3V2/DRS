<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackingNumber;

class DashboardController extends Controller
{
    public function reports() {
        if (Auth::user()->role == 0) {
            return view('admin.reports');
        }
    }

    public function dashboard() {
        if (Auth::user()->role == 1) {
            $userId = Auth::id();
            $unusedTrackingNumbers = TrackingNumber::where('user_id', $userId)
                                           ->where('status', 'Unused')
                                           ->first();

            return view('user.dashboard', compact('unusedTrackingNumbers'));
        }
    }
}
