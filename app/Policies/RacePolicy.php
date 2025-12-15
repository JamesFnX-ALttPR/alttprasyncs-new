<?php

namespace App\Policies;

use App\Models\Race;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RacePolicy
{
   public function edit(User $user, Race $race)
    {
        if ($race->from_racetime == 0) {
            return $race->user->is($user);
        } else {
            return false;
        }
    }
}
