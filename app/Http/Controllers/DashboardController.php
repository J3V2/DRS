<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function reports() {
        if (Auth::user()->role == 0) {
            return view('admin.reports');
        }
    }

    public function dashboard() {
        if (Auth::user()->role == 1) {
            return view('user.dashboard');
        }
    }
}
