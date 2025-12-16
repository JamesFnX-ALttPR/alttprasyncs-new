<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create() {
        return view("auth.login");
    }

    public function store(Request $request) {
        $attrs = $request->validate([
            "email" => ["required", "email"],
            "password"=> ["required"],
        ]);
        $remember = $request->filled("remember");

        $user = Auth::attempt($attrs, $remember);

        if (! $user) {
            throw ValidationException::withMessages([
                "email" => "We were unable to log you in. Please try again."
            ]);
        }

        request()->session()->regenerate();

        return redirect()->intended('/dashboard');
    }
    public function destroy() {
        Auth::logout();

        return redirect("/");
    }
}
