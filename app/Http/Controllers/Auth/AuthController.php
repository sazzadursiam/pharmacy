<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            if (Auth::user()->user_type == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return view('Auth.login');
            }
        }
        return view('Auth.login');
    }
    public function loginProcess(Request $request)
    {
        // return $request->all();
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
            if (Auth::user()->user_type == 1) {
                return redirect()->route('admin.dashboard')->with('success', 'Login Successful');
            } else {
                return redirect()->back()->with('error', 'Wrong Credentials');
            }
        } else {
            return redirect()->back()->with('error', 'Wrong Credentials');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Logout Successful.');
    }
    public function forgetPassword()
    {
        return view('Auth.forget-password');
    }
}
