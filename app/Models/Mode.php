<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Mode extends Model
{
    //
    protected $fillable = ['name','description'];

    public function race() {
        return $this->hasMany(Race::class);
    }
}
