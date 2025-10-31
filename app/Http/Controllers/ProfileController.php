<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile settings.
     */
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Display the password reset page.
     */
    public function editPassword()
    {
        $user = Auth::user();

        return view('profile.password', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->user_id . ',user_id'],
            'username' => ['required', 'alpha_num', 'min:3', 'max:30', 'unique:users,username,' . $user->user_id . ',user_id'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->username = $validated['username'];
        $user->save();

        return back()->with('status', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'Password berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Akun berhasil dihapus.');
    }
}
