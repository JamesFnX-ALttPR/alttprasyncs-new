<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Racer;
use App\Models\Result;
use Illuminate\Support\Facades\DB;

class RacerController extends Controller
{
    public function index()
    {
        $racers = Racer::withCount('result')->orderBy('result_count', 'DESC')->orderBy(DB::raw('LOWER("name")'))->paginate(20);
        return view('racer.index', [
            'racers' => $racers,
        ]);
    }

    public function show(int $id)
    {
        $racer = Racer::find($id);
        $results = Result::where('racer_id', $racer->id)->join('races', 'races.id', '=', 'results.race_id')->with('race')->orderByDesc('races.start_time')->paginate(20);
        return view('racer.show', [
            'racer' => $racer,
            'results' => $results,
        ]);
    }
}
