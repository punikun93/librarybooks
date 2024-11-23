<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    public function index()
    {
        // Check if the route is for 'confirmed' users
        if (Route::is('users.confirmed')) {
            $anas_users = User::where('status', 'Pending')->get();
            return view('admin.users.confirmed', compact('anas_users'));
        } else {
            $anas_users = User::where('status', 'Confirmed')->paginate(10);
            return view('admin.users.index', compact('anas_users'));
        }
    }

    public function store(Request $anas_request)
    {

        try {
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


            return redirect()->route('users.confirmed')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with('error', 'Failed to create user. Please try again.');
        }
    }
    public function update(Request $anas_request, $anas_user)
    {
        try {
            $anas_request->validate([
                'Username' => 'required|string|max:255',
                'NamaLengkap' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string',
                'Alamat' => 'required|string',
                'Role' => 'required|string',
            ]);
            $data = $anas_request->only(['Username', 'NamaLengkap', 'email', 'Alamat', 'Role', 'password']);
            $anas_User = User::findOrFail($anas_user);
            $anas_User->update($data);

            return redirect()->back()->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with('error', 'Failed to update user. Please try again.');
        }
    }
    public function confirm($anas_user)
    {
        try {
            $anas_user = User::findOrFail($anas_user);
            $anas_user->update(['Status' => 'Confirmed']);
            return redirect()->route('users.confirmed')->with('status', 'User confirmed successfully!');
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function destroy($anas_user)
    {
        try {
            $anas_user = User::findOrFail($anas_user);
            $anas_user->delete();
            return redirect()->back()->with('status', 'User deleted successfully!');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Failed to delete user. Please try again.');
        }
    }
}
