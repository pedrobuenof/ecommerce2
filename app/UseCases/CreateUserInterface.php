<?php

namespace App\UseCases;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;

interface CreateUserInterface
{
    /**
     * @param UserCreateRequest $userValidated
     * @return User
    */
    public function execute(UserCreateRequest $userValidated): User;
}
