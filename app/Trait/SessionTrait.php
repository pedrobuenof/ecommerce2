<?php

namespace App\Trait;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

trait SessionTrait
{
    public function setUserDataSession(array $userDbData): void
    {
        $userId = Arr::get($userDbData, "id");
        Arr::forget($userDbData, "password");
        Session::put("user_data.{$userId}", $userDbData);
    }

    public function getUserDataSession(array $userData): array
    {
        $userId = Arr::get($userData, "id");
        return Session::get("user_data.{$userId}", []);
    }
}
