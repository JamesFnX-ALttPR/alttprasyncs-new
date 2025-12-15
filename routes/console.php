<?php

use App\Actions\IntakeLatestAlttprRaces;
use App\Actions\IntakeLatestLadderRaces;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(new IntakeLatestAlttprRaces)->everyFifteenMinutes();
Schedule::call(new IntakeLatestLadderRaces)->everyFifteenMinutes();