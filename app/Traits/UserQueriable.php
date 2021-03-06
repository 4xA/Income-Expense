<?php

namespace App\Traits;

use Illuminate\Auth\AuthenticationException;

trait UserQueriable
{
    private function getUserId(): int
    {
        $user = auth()->user();

        if (is_null($user)) {
            throw new AuthenticationException('authentication exception');
        }

        return $user->id; 
    }
}
