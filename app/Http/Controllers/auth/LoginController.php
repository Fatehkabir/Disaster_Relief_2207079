<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create():view{
        return view('auth.login');
    }

    public function store(Request $request) : RedirectResponse{
        $credentials=$request->validate([
                'email'=>'required|email',
                'password'=>'required',
            ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been deactivated. Contact support.']);
            }

            return redirect()->intended(route('dashboard'))
                             ->with('success', 'Welcome back, ' . $user->name . '!');
        }
    }

            



}
