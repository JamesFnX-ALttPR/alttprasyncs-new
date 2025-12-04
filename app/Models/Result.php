<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['race_id', 'racer_id', 'time', 'forfeit', 'team', 'comment', 'vod', 'cr', 'from_racetime'];

    public function race() {
        return $this->belongsTo(Race::class);
    }
    public function racer() {
        return $this->belongsTo(Racer::class);
    }

    public function processNewResult(int $race_id, int $racer_id, string $time_string, string $forfeit_string, string $team, string $comment, string $vod, int $cr) {
        if ($forfeit_string == 'y') {
            $time = 99999;
            $forfeit = 1;
        } else {
            $forfeit = 0;
            $time_exploded = explode(':', $time_string);
            $time = ($time_exploded[0] * 3600) + ($time_exploded[1] * 60) + $time_exploded[2];
        }
        $this->create([
            'race_id'=> $race_id,
            'racer_id'=> $racer_id,
            'time'=> $time,
            'forfeit'=> $forfeit,
            'comment'=> $comment,
            'vod'=> $vod,
            'cr'=> $cr,
            'team' => $team,
            'from_racetime' => 0
        ]);
        return redirect('/results/' . $race_id);
    }
}
