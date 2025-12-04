<?php

use App\Http\Controllers\RacetimeController;
use App\Models\Race;
use App\Models\Racer;
use App\Models\Result;
use App\Models\Mode;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/intake/{id}", function ($id) {
    return view("intaketest", [
        'urls' => RacetimeController::gatherALttPRDataURLs($id)
    ]);
});

Route::get('/results/{id}', function($id) {
    return view('results.show', [
        'raceresult' => Race::where('id', $id)->with(array ('result' => function ($query) { $query->orderBy('time', 'ASC'); }, 'result.racer'))->withAvg(['result' => function($query) { $query->where('forfeit', 0); }], 'time')->first(),
        'id' => $id,
    ]);
});

Route::get('racers', function () {
    return view('racer.index', [
        'racers' => Racer::withCount('result')->orderBy('result_count', 'DESC')->orderBy('name', 'ASC')->paginate(20)
    ]);
});

Route::get('racer/{id}', function($id) {
    return view('racer.show', [
        //'racer' => Racer::where('id', $id)->with(['result', 'result.race' => function($query) {$query->orderBy('start_time', 'DESC'); }, 'result.race.mode'])->first(),
        'racer' => Racer::where('id', $id)->first(),
        'results' => Result::where('racer_id', $id)->join('races', 'races.id', '=', 'results.race_id')->with('race')->orderByDesc('races.start_time')->paginate(20),
    ]);
});

Route::get('/races', function() {
    return view('races.index', [
        'races' => Race::with('mode')->withCount('result')->orderBy('start_time', 'DESC')->paginate(20)
    ]);
});

Route::get('/races/coop', function() {
    return view('races.index', [
        'races' => Race::where('team_race', 1)->with('mode')->withCount('result')->orderBy('start_time', 'DESC')->paginate(20),
    ]);
});

Route::get('/mode/{id}', function($id) {
    return view('mode.show', [
        'mode' => Mode::where('id', $id)->first(),
        'races' => Race::where('mode_id', $id)->withCount('result')->orderBy('start_time', 'DESC')->paginate(20),
    ]);
});

Route::get('/async/{id}', function($id) {
    return view('results.create', [
        'race' => Race::where('id', $id)->first(),
    ]);
});

Route::post('/async/{id}', function($id) {
    Result::create([
        'race_id' => $id,
        'racer_id' => 11,
        
    ]);
});