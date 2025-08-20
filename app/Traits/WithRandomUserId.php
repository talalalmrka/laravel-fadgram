<?php

namespace App\Traits;

use App\Models\User;

trait WithRandomUserId
{
    public function randomUserId()
    {
        $user = User::inRandomOrder()->first();
        return $user?->id;
    }
}
