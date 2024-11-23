<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('landingPage');
        }
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('landingPage');
        }
        return view('auth.register');
    }

    public function register(Request $anas_request)
    {
        $anas_request->validate([
            'Username' => 'required|string|max:255|unique:users',
            'NamaLengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'Alamat' => 'required|string',
        ]);

        User::create([
            'Username' => $anas_request->Username,
            'NamaLengkap' => $anas_request->NamaLengkap,
            'email' => $anas_request->email,
            'password' => $anas_request->password,
            'Alamat' => $anas_request->Alamat,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function login(Request $anas_request)
    {
        $anas_credentials = $anas_request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($anas_credentials)) {
            // Check if the user's status is confirmed
            if (Auth::user()->Status !== 'Confirmed') {
                Auth::logout(); // Log out the user immediately
                return back()->withErrors(['status' => 'Your account hasnt been confirmed yet']);
            }

            // Check if the user has the appropriate role
            if (Auth::user()->Role === 'petugas') {
                // Log the login activity for staff members
                LogAktivitas::create([
                    'UserID' => Auth::user()->UserID,
                    'aksi' => 'Login',
                    'detail' => 'Staff member logged in to the system',
                    'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
                ]);

                return redirect()->route('admin.dashboard');
            }

            // Redirect regular users
            return redirect()->route('landingPage');
        }

        // If credentials are incorrect, show the invalid credentials message
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout()
    {
        // Check if the user is a staff member before logging out
        if (Auth::user()->Role === 'petugas') {
            // Log the logout activity
            LogAktivitas::create([
                'UserID' => Auth::user()->UserID,
                'aksi' => 'Logout',
                'detail' => 'Staff member logged out of the system',
                'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
            ]);
        }

        Auth::logout();
        return redirect()->route('login');
    }
}
