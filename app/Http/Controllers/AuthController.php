<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Pages
    |--------------------------------------------------------------------------
    */

    public function customerLogin()
    {
        return view('auth.login');
    }

    public function customerRegister()
    {
        return view('auth.register');
    }

    public function adminLogin()
    {
        return view('auth.admin-login');
    }

    /*
    |--------------------------------------------------------------------------
    | Register Customer
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'role'     => 'customer',
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('customer.login')
            ->with('success', 'Registration successful! Please login.');
    }   
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role == 'customer') {
            return redirect()->route('customer.dashboard');
        }

        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Invalid email or password.',
    ])->onlyInput('email');
}

public function adminAuthenticate(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        if (Auth::user()->role !== 'admin') {

            Auth::logout();

            return back()->withErrors([
                'email' => 'You are not authorized as an administrator.',
            ]);
        }

        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid email or password.',
    ]);
}

public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('home');
}
}