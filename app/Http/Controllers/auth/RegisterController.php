<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'password'          => 'required|string|min:8|confirmed',
            'role'              => 'required|in:victim,volunteer',
            'phone'             => 'nullable|string|max:20',
            'address'           => 'nullable|string|max:500',
            'city'              => 'nullable|string|max:100',
            'skills'            => 'nullable|string|max:500',
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => $request->role,
            'phone'             => $request->phone,
            'address'           => $request->address,
            'city'              => $request->city,
            'skills'            => $request->skills,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Welcome to DisasterRelief Platform, ' . $user->name . '!');
    }
}
