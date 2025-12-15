<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Result;
use App\Models\Race;

class DashboardController extends Controller
{
    public function index()
    {
        return view("dashboard.index");
    }
    public function results_index() {
        $user = User::find(Auth::user()->id);
        $user->load("racer");
        $results = Result::where('racer_id', $user->racer->id)->where('from_racetime', 0)->orderBy('created_at','desc')->paginate(20);
        return view('dashboard.results', [
            'results' => $results
        ]);
    }

    public function races_index() {
        $user = User::find(Auth::user()->id);
        $races = Race::where('user_id', $user->id)->orderBy('created_at','desc')->paginate(20);
        return view('dashboard.races', [
            'races' => $races
        ]);
    }
}
