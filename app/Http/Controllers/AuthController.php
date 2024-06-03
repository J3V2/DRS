<?php

namespace App\Http\Controllers;

use App\Events\UserLogin;
use App\Events\UserLogout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login() {
        if (Auth::check())
        {
            if(Auth::user()->role == 0) {
                return redirect('/admin/reports');
            }
            else if(Auth::user()->role == 1) {
                return redirect('/user/dashboard');
            }
        }
        return view('auth.login');
    }

    public function AuthLogin(Request $request) {
        $keepSignedIn = !empty($request->keepSignedIn) ? true : false;

        if(Auth::attempt(['email' => $request->email,'password' => $request->password], $keepSignedIn))
        {
            $user = Auth::user();

            // Ensure $user is an instance of User
            if ($user instanceof User) {
                // Set LastLogin to current timestamp
                $user->LastLogin = now();

                // Set FirstLogin if it is not set
                if (!$user->FirstLogin) {
                    $user->FirstLogin = now();
                }

                // Set current login time
                $user->current_login_at = now();

                $user->save();
            }

            if($user->role == 0) {
                event(new UserLogin($user->id, now(), $user->office->code));
                return redirect('/admin/reports');
            }
            else if($user->role == 1) {
                event(new UserLogin($user->id, now(), $user->office->code));
                return redirect('/user/dashboard');
            }
        }
        else
        {
            return redirect()->back()->with('error','Invalid credentials, Please Try Again.');
        }
    }

    public function logout() {
        $user = Auth::user();
        if ($user instanceof User) {
            if ($user) {
                // Calculate the session duration in seconds
                $sessionDuration = $user->current_login_at ? now()->diffInSeconds($user->current_login_at) : 0;

                // Update the last logout time
                $user->last_logout_at = now();

                // Calculate total session time in seconds
                $totalSessions = ($this->getTotalSessionTimeInSeconds($user) + $sessionDuration);

                // Update sessions count
                $user->sessions_count += 1;

                // Calculate the average process time
                $avgProcessTime = $this->calculateAvgProcessTime($user, $totalSessions);

                // Update AvgProcessTime with the formatted string
                $user->AvgProcessTime = $avgProcessTime;

                // Save user details
                $user->save();
            }
        }
        event(new UserLogout($user->id, now(), $user->office->code));
        Auth::logout();
        return redirect(url(''));
    }

    protected function getTotalSessionTimeInSeconds($user)
    {
        // Return the total session time in seconds
        $hours = intval(substr($user->AvgProcessTime, 0, strpos($user->AvgProcessTime, ' ')));
        return $hours * 3600 * $user->sessions_count;
    }

    protected function calculateAvgProcessTime($user, $totalSessions)
    {
        // Calculate average time in hours per day, days per week, months per year, and years
        $daysSinceFirstLogin = max(now()->diffInDays($user->FirstLogin), 1);
        $hoursPerDay = ($totalSessions / 3600) / $daysSinceFirstLogin;
        $daysPerWeek = ($totalSessions / 3600) / 7; // Assuming 7 days in a week
        $monthsPerYear = ($totalSessions / 3600) / (30 * 12); // Assuming 30 days per month and 12 months per year
        $years = $daysSinceFirstLogin / 365; // Assuming 365 days in a year

        // Return the formatted string
        if ($years >= 1) {
            return sprintf("%.2f years", $years);
        } elseif ($monthsPerYear >= 1) {
            return sprintf("%.2f months per year", $monthsPerYear);
        } elseif ($daysPerWeek >= 1) {
            return sprintf("%.2f days per week", $daysPerWeek);
        } elseif ($hoursPerDay >= 1) {
            return sprintf("%.2f hours per day", $hoursPerDay);
        } else {
            return "Less than 1 hour per day"; // Default case
        }
    }


    public function forgot_password() {
        return view('auth.forgot');
    }

    public function postForgotPassword(Request $request){
        $user = User::getEmailSingle($request->email);
        if(!empty($user)){
            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('success', 'Please check your email and reset your password.');
        }
        else{
            return redirect()->back()->with('error', 'Email not found in any Registered Account.');
        }
    }

    public function reset_password($remember_token) {
        $user = User::getTokenSingle($remember_token);
        if (!empty($user)) {
            $data['user'] = $user;
            $data['token'] = $remember_token; // Pass the token to the view
            return view('auth.reset', $data);
        } else {
            abort(404);
        }
    }

    public function postResetPassword($token, Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'con_password' => 'required|same:password',
        ]);

        $user = User::getTokenSingle($token);

        if (!$user) {
            return redirect()->back()->with('error', 'Invalid or expired token. Please try again.');
        }

        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(30);
        $user->save();

        return redirect(url(''))->with('success', 'Password successfully reset');
    }
}
