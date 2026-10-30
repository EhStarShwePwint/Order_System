<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // 1. Show the Profile Page
    public function edit()
    {
        // Return the profile view, passing the currently logged-in user
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    // 2. Update Profile Information (Name & Email)
    public function update(Request $request)
    {
        $user = auth()->user();

        // Validate the incoming request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ]);

        // Update the user record
        $user->fill($validated);

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    // 3. Update Password
    public function updatePassword(Request $request)
    {
        // Validate the current and new password
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Update the password (Hash it automatically via the model's cast if set, or manually)
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')->with('status', 'password-updated');
    }
}