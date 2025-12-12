<?php

namespace App\Http\Controllers;
use App\Models\Result;
use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    
    public function create(int $id)
    {
        if (Auth::guest()) {
            return redirect("/login");
        }
        
        $race = Race::with('mode')->find($id);
        return view('results.create', [
            'race' => $race
        ]);
    }
    public function store(Request $request) {
        if ($request->team_race == 'y') {
            $validated = $request->validate([
                'race_id'=> 'required',
                'team'=> 'required',
                'time1' => 'required_unless:forfeit,1|regex:/^[0-9]?\:?[0-9]{1,2}\:[0-9]{1,2}$/|nullable',
                'time2' => 'required_unless:forfeit,1|regex:/^[0-9]?\:?[0-9]{1,2}\:[0-9]{1,2}$/|nullable',
                'forfeit' => 'nullable',
                'comment1' => 'nullable',
                'vod1' => 'nullable|url',
                'cr1'=> 'nullable',
                'comment2' => 'nullable',
                'vod2' => 'nullable|url',
                'cr2'=> 'nullable',
            ], [
                'time1.regex'=> 'Player 1\'s time is in an invalid format. Please enter the time in H:MM:SS. If your result is under 1 hour, you may enter in MM:SS.',
                'time2.regex'=> 'Player 2\'s time is in an invalid format. Please enter the time in H:MM:SS. If your result is under 1 hour, you may enter in MM:SS.',
                'vod1.url'=> 'Player 1\'s VOD link is not a valid URL.',
                'vod2.url'=> 'Player 2\'s VOD link is not a valid URL.',
                'team.required'=> 'A team name is required.',
                'time1.required_unless'=> 'A finish time is required for Player 1. If your team forfeitted the race, please check the Forfeit box instead.',
                'time2.required_unless'=> 'A finish time is required for Player 2. If your team forfeitted the race, please check the Forfeit box instead.',
            ]);
            if (isset ($validated['forfeit'])) {
                $time1 = 99999;
                $time2 = 99999;
                $forfeit1 = 1;
                $forfeit2 = 1;
            } else {
                $forfeit1 = 0;
                $forfeit2 = 0;
                $time1_exploded = explode(':', $validated['time1']);
                $time2_exploded = explode(':', $validated['time2']);
                $time1 = (intval($time1_exploded[0]) * 3600) + (intval($time1_exploded[1]) * 60) + intval($time1_exploded[2]);
                $time2 = (intval($time2_exploded[0]) * 3600) + (intval($time2_exploded[1]) * 60) + intval($time2_exploded[2]);
            }
            $create = Result::create([
                'race_id' => $validated['race_id'],
                'racer_id'=> Auth::user()->racer->id,
                'time' => $time1,
                'forfeit' => $forfeit1,
                'comment' => $validated['comment1'],
                'vod' => $validated['vod1'],
                'cr' => $validated['cr1'],
                'team' => $validated['team'],
                'from_racetime' => 0,
            ]);
            $create = Result::create([
                'race_id' => $validated['race_id'],
                'racer_id'=> Auth::user()->racer->id,
                'time' => $time2,
                'forfeit' => $forfeit2,
                'comment' => $validated['comment2'],
                'vod' => $validated['vod2'],
                'cr' => $validated['cr2'],
                'team' => $validated['team'],
                'from_racetime' => 0,
            ]);
        } else {
            $validated = $request->validate([
                'race_id'=> 'required',
                'time' => 'required_unless:forfeit,1|regex:/^[0-9]?\:?[0-9]{1,2}\:[0-9]{1,2}$/|nullable',
                'forfeit' => 'nullable',
                'comment' => 'nullable',
                'vod' => 'nullable|url',
                'cr'=> 'nullable',
            ], [
                'time.required_unless'=> 'A finish time is required. If you forfeitted the race, please check the Forfeit box instead.',
                'time.regex' => 'Your time is in an invalid format. Please enter the time in H:MM:SS. If your result is under 1 hour, you may enter in MM:SS.',
                'vod.url'=> 'Your VOD link is not a valid URL.',
            ]);
            if (isset ($validated['forfeit'])) {
                $time = 99999;
                $forfeit = 1;
            } else {
                $forfeit = 0;
                $time_exploded = explode(':', $validated['time']);
                $time = (intval($time_exploded[0]) * 3600) + intval(($time_exploded[1]) * 60) + intval($time_exploded[2]);
            }
            $create = Result::create([
                'race_id'=> $validated['race_id'],
                'racer_id'=> Auth::user()->racer->id,
                'time'=> $time,
                'forfeit'=> $forfeit,
                'comment'=> $validated['comment'],
                'vod'=> $validated['vod'],
                'cr'=> $validated['cr'],
                'team' => null,
                'from_racetime' => 0
            ]);
        }
        return redirect('/race/' . $validated['race_id']);
    }
}