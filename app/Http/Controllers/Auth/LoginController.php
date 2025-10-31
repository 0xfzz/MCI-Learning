<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Display the login form.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, false)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $request->session()->regenerate();

        $user = $request->user();

        if (! $user instanceof User) {
            return redirect()->intended(route('dashboard.index'));
        }

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        $redirectRoute = match (true) {
            $user->isAdmin() => route('dashboard.index'),
            $user->isInstructor() => route('dashboard.courses.index'),
            $user->isStudent() => route('dashboard.index'),
            default => route('dashboard.index'),
        };

        return redirect()->intended($redirectRoute);
    }

    /**
     * Log the user out of the application.
     */
    public function destroy(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
