<?php

namespace App\Services;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositorieInterface;
use App\UseCases\CreateUserInterface;

class CreateUserService implements CreateUserInterface
{
    protected UserRepositorieInterface $userRepository;

    
    public function __construct(UserRepositorieInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    /**
     * @param UserCreateRequest $userValidated
     * @return User
    */
    public function execute(UserCreateRequest $userValidated): User {

        $user = $this->userRepository->createUser($userValidated);

        return $user;
    }
}
