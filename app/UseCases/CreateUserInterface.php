<?php

namespace App\UseCases;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;

interface CreateUserInterface
{
    public function execute(UserCreateRequest $userValidated): ?User;
}
