<?php

namespace App\Repositories;

use App\DTO\UserDTO;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositorieInterface;

class UserRepositorie implements UserRepositorieInterface
{
    /**
     * @param UserCreateRequest $userValidated
     * @return User
    */
    public function createUser(UserCreateRequest $userValidated): User
    {
        try {
            $user = User::create([
                'name' => $userValidated->name,
                'email' => $userValidated->email,
                'password' => bcrypt($userValidated->password),
            ]);
            
            
            if ($user) {
                var_dump("Salvo!");
                return $user;
            }
        } catch (\Exception $e) {
            throw new \Exception('Falha ao criar o usuário: ' . $e->getMessage());
        }
        
        
    }
}
