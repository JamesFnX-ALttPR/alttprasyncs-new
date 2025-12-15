<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\Mode;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;


class RaceController extends Controller
{
    // Index
    public function index()
    {
        $races = Race::with('mode')->withCount('result')->orderBy('start_time', 'DESC')->paginate(20);

        return view('races.index', [
            'races' => $races,
        ]);
    }

    public function indexCoop()
    {
        $races = Race::where('team_race', 1)->with('mode')->withCount('result')->orderBy('start_time','DESC')->paginate(20);

        return view('races.index', [
            'races' => $races,
        ]);
    }
    
    // Show
    public function show(int $id)
    {
        return view("races.show", [
            'race' => Race::where('id', $id)->with(array ('result' => function ($query) { $query->orderBy('time', 'ASC'); }, 'result.racer'))->withAvg(['result' => function($query) { $query->where('forfeit', 0); }], 'time')->first(),
        ]);
    }

    public function create() {
        $modes = Mode::orderBy('name')->get();
        return view('races.create', [
            'modes' => $modes,
        ]);

    }
    public function store(Request $request) {
        $attrs = $request->validate([
            'mode' => ['required', 'numeric'],
            'new_mode' => ['nullable', 'required_if:mode,0'],
            'seed' => ['required','url'],
            'description' => ['nullable'],
            'hash_1' => ['required'],
            'hash_2' => ['required'],
            'hash_3' => ['required'],
            'hash_4' => ['required'],
            'hash_5' => ['required'],
            'team_race' => ['nullable'],
            'spoiler_race'=> ['nullable'],
            'spoiler_log'=> ['nullable', 'url', 'required_if:spoiler_race,1'],
        ]);
        while(1 == 1) {
            $lib1 = ['earnest', 'vicious', 'versed', 'royal', 'absolute',
                    'weary', 'brisk', 'long', 'historical', 'precious',
                    'awesome', 'alarming', 'adorable', 'tall', 'flowery',
                    'talkative', 'speedy', 'reckless', 'bitter', 'patient'];
            
            $lib2 = ['noumander', 'penguigo', 'kuwanger', 'mandriller', 'armarge',
                    'octopuld', 'chamaeleao', 'eagleed', 'alligates', 'crablos',
                    'stagger', 'mothmenos', 'hyakulegger', 'mymine', 'ostreague',
                    'hetimarl', 'horneck', 'buffalio', 'seaforce', 'masaider',
                    'namazuros', 'shrimper', 'tigerd', 'beetbood'];
            
            $race_name = Arr::random($lib1) . '-' . Arr::random($lib2) . '-' . mt_rand(0,9) . mt_rand(0,9) . mt_rand(0,9) . mt_rand(0,9) . mt_rand(0,9);

            if(! Race::where('name', $race_name)->first()) {
                break;
            }
        }

        if ($attrs['mode'] == 0) {
            $mode = Mode::create([
                'name' => $attrs['new_mode'],
            ]);
            $mode_id = $mode->id;
        } else {
            $mode_id = $attrs['mode'];
        }

        if (array_key_exists('team_race',$attrs) && $attrs['team_race'] == 1) {
            $team_race = 1;
        } else {
            $team_race = 0;
        }
        if (array_key_exists('spoiler_race',$attrs) && $attrs['spoiler_race'] == 1) {
            $spoiler_race = 1;
        } else {
            $spoiler_race = 0;
        }

        $hash_string = $attrs['hash_1'] . ' ' . $attrs['hash_2'] . ' ' . $attrs['hash_3'] . ' ' . $attrs['hash_4'] . ' ' . $attrs['hash_5'];
        $user_id = Auth::id();

        $race = Race::create([
            'name' => $race_name,
            'mode_id' => $mode_id,
            'seed' => $attrs['seed'],
            'description' => $attrs['description'],
            'hash' => $hash_string,
            'start_time' => gmdate("Y-m-d G:i:s", time()),
            'team_race' => $team_race,
            'spoiler_race' => $spoiler_race,
            'spoiler_log' => $attrs['spoiler_log'],
            'from_racetime' => 0,
            'user_id' => $user_id,
        ]);

        return redirect('/race/' . $race->id);
    }
    public function edit(Race $race)
    {
        $modes = Mode::orderBy('name')->get();
        return view('races.edit', [
            'race' => $race,
            'modes' => $modes
        ]);
    }
}
