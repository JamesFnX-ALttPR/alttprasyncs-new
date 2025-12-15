<?php

namespace App\Policies;

use App\Models\Series;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SeriesPolicy
{
    public function edit(User $user, Series $series)
    {
         if ($user->id == $series->user_id) {
                return true;
            } else {
                return false;
            }
    }
}
