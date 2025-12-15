<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModeController;
use App\Http\Controllers\IntakeController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\RacerController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $response = Http::withoutVerifying()->get('https://botofmudora.s3.us-east-1.amazonaws.com/seeds/6416936a-ec4a-4106-81d4-fc3521b81a1c/OR_886386512_Spoiler_Hookshot-Shovel-Heart-Map-Pendant.json');
    dd($response->status());
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard/results', [DashboardController::class,'results_index'])->middleware('auth');
Route::get('/dashboard/races', [DashboardController::class,'races_index'])->middleware('auth');

Route::get("/intake/alttpr/{id}", [IntakeController::class, "alttpr"]);
Route::get("/intake/ladder/{id}", [IntakeController::class, "ladder"]);
Route::get('/intake/candidate/{id}', [IntakeController::class,'candidate']);

Route::get('racers', [RacerController::class, 'index']);
Route::get('racer/{id}', [RacerController::class,'show']);

Route::get('/races', [RaceController::class,'index']);
Route::get('/races/coop', [RaceController::class,'indexCoop']);
Route::get('/races/create', [RaceController::class,'create'])
    ->middleware('auth');

Route::post('/races/create', [RaceController::class,'store'])
    ->middleware('auth');

Route::get('/race/{race}/edit', [RaceController::class,'edit'])
    ->middleware('auth')
    ->can('edit', 'race');

Route::patch('/race/{race}', [RaceController::class,'edit'])
    ->middleware('auth')
    ->can('edit', 'race');

Route::get('/race/{id}', [RaceController::class,'show']);

Route::get('/modes', [ModeController::class,'index']);
Route::get('/mode/{id}', [ModeController::class,'show']);

Route::get('/result/{id}', [ResultController::class,'create']);
Route::post('/result', [ResultController::class,'store']);

Route::get('/register', [RegisteredUserController::class,'create']);
Route::post('/register', [RegisteredUserController::class,'store']);

Route::get('/login', [SessionController::class,'create'])->name('login');
Route::post('/login', [SessionController::class,'store']);

Route::post('/logout', [SessionController::class,'destroy'])->name('logout');

Route::get('/series', [SeriesController::class,'index']);
Route::get('/series/create', [SeriesController::class,'create'])
    ->middleware('auth');

Route::get('/series/{series}', [SeriesController::class,'show']);
Route::patch('/series/{series}', [SeriesController::class,'update'])
    ->middleware('auth')
    ->can('edit', 'series');

Route::delete('/series/{series}', [SeriesController::class,'destroy'])
    ->middleware('auth')
    ->can('edit', 'series');

Route::get('/series/{series}/edit', [SeriesController::class,'edit'])
    ->middleware('auth')
    ->can('edit', 'series');


Route::post('/series', [SeriesController::class,'store'])
    ->middleware('auth');

Route::post('/series/add', [SeriesController::class,'append'])
    ->middleware('auth');

