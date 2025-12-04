@foreach ($urls as $url)
@php
$name = str_replace('/data', '', str_replace('https://racetime.gg/', '', $url));
if (! \App\Models\Race::where('name', $name)->exists() && ! \App\Models\FailedIntake::where('name', $name)->exists()) {
    $race = new \App\Http\Controllers\RacetimeController();
    $race_data = $race->getRacetimeData($url);
    $parsed_data = $race->parseRacetimeData($race_data);
    if ($parsed_data['accepted']) {
        if (preg_match('/[Ss]poiler\s.+/', $parsed_data['mode'])) {
            $spoiler_log = $race->getSpoilerLog($parsed_data['name']);
            $spoiler_race = 1;
            preg_match('/[Ss]poiler\s(.+)/', $parsed_data['mode'], $matches);
            $mode = $matches[1];
        } else {
            $spoiler_log = null;
            $spoiler_race = 0;
            $mode = $parsed_data['mode'];
        }
        if ($parsed_data['team_race']) {
            $team_race = 1;
        } else {
            $team_race = 0;
        }
        $modequery = \App\Models\Mode::updateOrCreate(['name' => $mode], ['name' => $mode, 'description' => \App\Http\Controllers\RacetimeController::getModeData($mode)]);
        $mode_id = $modequery->id;
        $racequery = \App\Models\Race::create(['name' => $parsed_data['name'], 'mode_id' => $mode_id, 'seed' => $parsed_data['seed'], 'hash' => $parsed_data['hash'], 'description' => $parsed_data['description'], 'start_time' => $parsed_data['start_time'], 'team_race' => $team_race, 'spoiler_race' => $spoiler_race, 'spoiler_log' => $spoiler_log, 'from_racetime' => 1]);
        $race_id = $racequery->id;
        for ($i = 0; $i < count($race_data['entrants']); $i++) {
            $racer = $race->getRacerData($race_data, $i);
            $racerquery = \App\Models\Racer::updateOrCreate(['racetime_id' => $racer['id']], ['racetime_id' => $racer['id'], 'name' => $racer['name'], 'discriminator' => $racer['discriminator']]);
            $racer_id = $racerquery->id;
            if ($team_race == 1) {
                $team_name = $racer['team']['name'];
            } else {
                $team_name = null;
            }
            \App\Models\Result::create(['race_id' => $race_id, 'racer_id' => $racer_id, 'time' => $racer['time'], 'forfeit' => $racer['forfeit'], 'comment' => $racer['comment'], 'team' => $team_name, 'from_racetime' => 1]);
        }
    } else {
        \App\Models\FailedIntake::create(['name' => $parsed_data['name'], 'reason' => $parsed_data['reason'], 'info_bot' => $race_data['info_bot']]);
    }
}
@endphp

@endforeach
<p>Done</p>