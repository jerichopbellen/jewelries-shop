<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

class AuthController extends Controller
{
    public function showLogin() 
    { 
        return view('auth.login'); 
    }

    public function showRegister() 
    { 
        return view('auth.register'); 
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:8|confirmed',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('profile_pictures', 'public');
        }

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'customer',
            'image_path' => $path,
            'is_active'  => true, 
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account before logging in.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $remember = (bool) $request->input('remember');

        if (Auth::attempt($credentials, $remember)) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been deactivated.']);
            }

            if ($user instanceof MustVerifyEmailContract && !$user->hasVerifiedEmail()) {
                Auth::logout();
                
                return redirect()->route('login')->with('verification_link', 'Your email is not verified. <a href="'.route('verification.resend.form').'" class="fw-bold text-decoration-underline">Click here to resend the link.</a>');
            }

            $request->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('shop.index'));
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function showResendForm()
    {
        return view('auth.resend-verification');
    }

    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', 'Your email is already verified. Please log in.');
        }

        event(new Registered($user));

        return back()->with('success', 'A new verification link has been sent to your email address.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('shop.index')->with('info', 'You have been logged out.');
    }
}