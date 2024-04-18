<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function admin_settings() {
        return view('admin.settings');
    }

    public function admin_updatePassword(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed:confirm_new_password',
        ]);

        $user = Auth::user();

        // Check if $user is an instance of the expected model
        if (!$user instanceof \App\Models\User) {
            // Handle the error, e.g., by redirecting back with an error message
            return back()->withErrors(['error' => 'User not found.']);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The provided password does not match your current password.']);
        }

        // Use the update method to update the password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('admin-settings')->with('success', 'Password updated successfully.');
    }

    public function user_settings() {
        return view('user.settings');
    }

    public function user_updatePassword(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed:confirm_new_password',
        ]);

        $user = Auth::user();

        // Check if $user is an instance of the expected model
        if (!$user instanceof \App\Models\User) {
            // Handle the error, e.g., by redirecting back with an error message
            return back()->withErrors(['error' => 'User not found.']);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The provided password does not match your current password.']);
        }

        // Use the update method to update the password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('user-settings')->with('success', 'Password updated successfully.');
    }

}

