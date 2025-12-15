@use('Illuminate\Http\Request')
@foreach ($urls as $url)
@php
    $name = str_replace('/data', '', str_replace('https://racetime.gg/', '', $url));
if (! \App\Models\Race::where('name', $name)->exists() && ! \App\Models\FailedIntake::where('name', $name)->exists()) {
    $race_data = gatherRaceData($url);
    $pattern = '/^.*\s\-\s(https\:\/\/.*)\s\-\s(\([A-Za-z\s]+\/[A-Za-z\s]+\/[A-Za-z\s]+\/[A-Za-z\s]+\/[A-Za-z\s]+\))\s?\|?\s?(.*)$/';
    if (preg_match($pattern, $race_data['info'])) {
        preg_match($pattern, $race_data['info'], $matches);
        $seed = $matches[1];
        $hash = $matches[2];
        if (array_key_exists(3, $matches)) {
            $description = $matches[3];
        }
        $start_time = date("Y-m-d H:i:s", strtotime($race_data["started_at"]));
        if ($race_data['team_race'] == true) {
            $team_race = 1;
        } else {
            $team_race = 0;
        }
        $chatlog = 'https://racetime.gg' . $race_data['url'] . '.txt';
        $spoiler_race = 0;
        $spoiler_log = null;
        $mode_response = Http::get($chatlog);
        $mode_pattern = '/!(preset|mystery|spoiler)\s([A-Za-z0-9\h\/\_\-]+)/';
        if (preg_match($mode_pattern, $mode_response)) {
            preg_match($mode_pattern, $mode_response, $mode_matches);
            if ($mode_matches[1] == 'preset') {
                $mode = $mode_matches[2];
                $spoiler_race = 0;
            } elseif ($mode_matches[1] == 'spoiler') {
                $mode = $mode_matches[2];
                $spoiler_race = 1;
                $spoiler_log = getSpoilerLog($race_data['name']);
                $spoiler_response = Http::withoutVerifying()->get($spoiler_log);
            } elseif ($mode_matches[1] == 'mystery') {
                $mode = $mode_matches[1];
                $spoiler_race = 0;
            }
        }
        if (validateHash($hash) == false) {
            $failed_intake = \App\Models\FailedIntake::create([
                'name' => $race_data['name'],
                'reason' => 'Unable to verify hash',
                'info_bot' => $race_data['info']
            ]);
            // echo '<p>Unable to verify hash ' . $hash . ' for race ' . $race_data['name'] . '</p>' . PHP_EOL;
        } elseif (!Str::isUrl($seed)) {
            $failed_intake = \App\Models\FailedIntake::create([
                'name' => $race_data['name'],
                'reason' => 'Seed not valid URL',
                'info_bot' => $race_data['info']
            ]);
            // echo '<p>Seed ' . $seed . ' for race ' . $race_data['name'] . ' is not a valid URL</p>' . PHP_EOL;
        } elseif ($spoiler_race == 1 && $spoiler_response->status() != 200) {
            $failed_intake = \App\Models\FailedIntake::create([
                'name' => $race_data['name'],
                'reason' => 'Spoiler log no longer available',
                'info_bot' => $race_data['info']
            ]);
            // echo '<p>Spoiler log at ' . $spoiler_log . ' is no longer available for race' . $race_data['name'] . '</p>' . PHP_EOL;
        } else {
            $modequery = \App\Models\Mode::updateOrCreate(['name' => $mode], ['name' => $mode, 'description' => getModeData($mode)]);
            $mode_id = $modequery->id;
            $new_race = \App\Models\Race::create([
                'name' => $race_data['name'],
                'mode_id' => $mode_id,
                'seed' => $seed,
                'hash' => validateHash($hash),
                'description' => $description,
                'start_time' => $start_time,
                'team_race' => $team_race,
                'spoiler_race' => $spoiler_race,
                'spoiler_log' => $spoiler_log,
                'from_racetime' => 1
            ]);
            $race_id = $new_race->id;
            for ($i = 0; $i < count($race_data['entrants']); $i++) {
                $racer = getRacerData($race_data, $i);
                $racerquery = \App\Models\Racer::updateOrCreate([
                    'racetime_id' => $racer['id']
                ],[
                    'racetime_id' => $racer['id'],
                    'name' => $racer['name'],
                    'discriminator' => $racer['discriminator']
                ]);
                $racer_id = $racerquery->id;
                if ($team_race == 1) {
                    $team_name = $racer['team']['name'];
                } else {
                    $team_name = null;
                }
                \App\Models\Result::create([
                    'race_id' => $race_id,
                    'racer_id' => $racer_id,
                    'time' => $racer['time'],
                    'forfeit' => $racer['forfeit'],
                    'comment' => $racer['comment'],
                    'team' => $team_name,
                    'from_racetime' => 1
                ]);
            }
            // echo '<p>Race ' . $race_data['name'] . ' would be accepted</p>' . PHP_EOL;
            // echo '<p>Mode: ' . $mode . '<br />Seed: ' . $seed . '<br />Hash:' . validateHash($hash) . '<br />Description: ' . $description . 'Start Time: ' . $start_time . '<br />Team Race: ' . $team_race . '<br />Spoiler Race: ' . $spoiler_race . '<br />Spoiler Log: ' . $spoiler_log . '</p>' . PHP_EOL;
        }
    } else {
        $failed_intake = \App\Models\FailedIntake::create([
            'name' => $race_data['name'],
            'reason' => 'Unable to parse data',
            'info_bot' => $race_data['info']
        ]);
        // echo '<p>Unable to parse data for race ' . $race_data['name'] . '</p' . PHP_EOL;
    }
}
@endphp
@endforeach
Done