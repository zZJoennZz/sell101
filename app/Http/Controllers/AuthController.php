<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    public function admin_login() {
        return view('pages.admin.login');
    }

    public function admin_login_post(Request $request) {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (auth()->attempt($credentials)) {
                return redirect()->route('admin.dashboard')->with('success', 'Login successful');
            } else {
                return redirect()->back()->with('error', 'Invalid credentials!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Login failed: ' . $e->getMessage());
        }
    }

    public function logout() {
        auth()->logout();
        Session::flush();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }
}
