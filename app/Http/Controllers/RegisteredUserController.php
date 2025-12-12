<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Racer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    public function create() {
        $racers = Racer::whereNull('user_id')->orderBy(DB::raw("LOWER(name)"))->get();
        return view("auth.register", [
            "racers"=> $racers
        ]);
    }

    public function store(Request $request) {
        $attrs = $request->validate([
            "display_name" => ["required"],
            "email"=> ["required", "email", "confirmed"],
            "password"=> ["required","confirmed"]
        ]);

        $racer_attr = $request->validate([
            "racer"=> ["numeric", "required"],
        ]);

        $user = User::create($attrs);

        if ($racer_attr['racer'] == 0) {
            Racer::create([
                'name' => $attrs['display_name'],
                'racetime_id' => Str::random(18),
                'user_id' => $user->id
            ]);
        } else {
            $racer = Racer::find($racer_attr['racer']);
            $racer->user_id = $user->id;
            $racer->save();
        }

        Auth::login($user);

        return redirect("/races");
    }
}
