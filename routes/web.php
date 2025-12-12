<?php

use App\Http\Controllers\ModeController;
use App\Http\Controllers\IntakeController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\RacerController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Models\Race;
use App\Models\Racer;
use App\Models\Result;
use App\Models\Mode;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd(gmdate("Y-m-d G:i:s", time()));
});

Route::get("/intake/{id}", function ($id) {
    return view("intaketest", [
        'urls' => IntakeController::gatherALttPRDataURLs($id)
    ]);
});


Route::get('racers', [RacerController::class, 'index']);
Route::get('racer/{id}', [RacerController::class,'show']);

Route::get('/races', [RaceController::class,'index']);
Route::get('/races/coop', [RaceController::class,'indexCoop']);
Route::get('/races/create', [RaceController::class,'create']);
Route::post('/races/create', [RaceController::class,'store']);
Route::get('/race/{id}', [RaceController::class,'show']);

Route::get('/modes', [ModeController::class,'index']);
Route::get('/mode/{id}', [ModeController::class,'show']);

Route::get('/async/{id}', [ResultController::class,'create']);
Route::post('/submitasync', [ResultController::class,'store']);

Route::get('/register', [RegisteredUserController::class,'create']);
Route::post('/register', [RegisteredUserController::class,'store']);

Route::get('/login', [SessionController::class,'create']);
Route::post('/login', [SessionController::class,'store']);

Route::post('/logout', [SessionController::class,'destroy']);