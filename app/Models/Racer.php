<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Racer extends Model
{
    protected $fillable = ['racetime_id', 'name', 'discriminator'];

    public function result() {
        return $this->hasMany(Result::class);
    }
}
