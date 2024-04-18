<?php

namespace App\Http\Controllers;

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
        // dd(Hash::make('user123'));
        if (!empty(Auth::check()))
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
            if(Auth::user()->role == 0) {
                return redirect('/admin/reports');
            }
            else if(Auth::user()->role == 1) {
                return redirect('/user/dashboard');
            }
       }
       else
       {
            return redirect()->back()->with('error','Invalid credentials, Please Try Again.');
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

    public function logout() {
        Auth::logout();
        return redirect(url(''));
    }
}