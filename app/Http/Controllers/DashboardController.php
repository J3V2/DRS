<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackingNumber;
use App\Models\Office;

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

            $forReceive = Document::where('status', 'pending')
                                  ->with('designatedOffices')->get();;
            $forRelease = Document::where('status', 'received')
                                  ->with('designatedOffices')->get();;

            return view('user.dashboard', compact('unusedTrackingNumbers','forReceive','forRelease'));
        }
    }
}
