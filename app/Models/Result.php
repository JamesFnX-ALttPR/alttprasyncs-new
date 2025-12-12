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
    
}
