<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validate the data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Apply "First User Rule"
        // Check current user count in the database
        // If count is 0, this is the first user (The Owner)
        $isFirstUser = User::count() === 0;

        // 3. Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $isFirstUser, // true for the first user only, false for others
        ]);

        // 4. Login and Redirect
        Auth::login($user);

        // Custom welcome message for the Admin
        if ($isFirstUser) {
            return redirect()->route('home')->with('success', 'Admin account set up successfully! You can now manage the store.');
        }

        return redirect()->route('home')->with('success', 'Your account has been created successfully.');
    }
}