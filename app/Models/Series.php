<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = ['name', 'description', 'user_id'];

    public function races() {
        return $this->belongsToMany(Race::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
