<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedIntake extends Model
{
    protected $table = "failed_intakes";
    protected $fillable = ['name', 'reason', 'info_bot'];
}
