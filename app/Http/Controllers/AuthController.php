<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function login(Request $request)
    {
        try {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'email.required' => __('validation.required_email'),
            'email.email' => __('validation.string_email'),
            'password.required' => __('validation.required_password'),
        ]);

        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('login')->with('error', 'You do not have admin access.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    } catch (\Exception $e) {
            return back()->withErrors([
            'error' => 'An error occurred during login. Please try again later.',
        ])->withInput($request->only('email')); 
        }
   
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ],[
            'name.required' => __('validation.required_name'),
            'name.string' => __('validation.string_name'),
            'name.max' => __('validation.max_name'),
            'email.required' => __('validation.required_email'),
            'email.string' => __('validation.string_email'),
            'email.unique' => __('validation.email_unique'),
            'password.required' => __('validation.required_password'),
            'password.string' => __('validation.string_password'),
            'password.min' => __('validation.min_password'),
            'password.confirmed' => __('validation.confirmed_password'),
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => true // Set as admin by default
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
