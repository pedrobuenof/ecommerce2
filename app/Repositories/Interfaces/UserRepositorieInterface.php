<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;

interface UserRepositorieInterface
{
    public function createUser(UserCreateRequest $userValidated): User;
    
}
