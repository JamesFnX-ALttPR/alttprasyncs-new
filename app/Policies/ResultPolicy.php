<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Result;

class ResultPolicy
{
    public function edit(User $user, Result $result)
    {
        if ($result->from_racetime == 0) {
            $user->load("racer");
            if ($user->racer->id == $result->racer_id) {
                return true;
            } else {
                return false;
            }    
        } else {
            return false;
        }
    }
}
