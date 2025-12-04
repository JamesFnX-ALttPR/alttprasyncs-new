<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = ['name', 'mode_id', 'seed','hash','start_time','team_race','spoiler_race','spoiler_log','from_racetime', 'description'];

    public function result() {
        return $this->hasMany(Result::class);
    }
    public function mode() {
        return $this->belongsTo(Mode::class);
    }
}
