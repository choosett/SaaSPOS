<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // ✅ View Profile
    public function show()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    // ✅ Edit Profile
    public function edit()
    {
        return view('profile-edit', ['user' => Auth::user()]);
    }

    // ✅ Update Profile
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $user->avatar ?? null,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    // ✅ Delete Profile
    public function destroy()
    {
        $user = Auth::user();
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }
        $user->delete();

        return redirect('/')->with('success', 'Profile deleted successfully.');
    }
}
