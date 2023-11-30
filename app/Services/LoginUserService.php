<?php

namespace App\Services;

use App\Exceptions\PermitionException;
use App\Repositories\Interfaces\UserRepositorieInterface;
use App\Trait\SessionTrait;
use Illuminate\Support\Arr;

class LoginUserService
{

    use SessionTrait;

    protected UserRepositorieInterface $userRepository;

    public function __construct(UserRepositorieInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    private function login(array $loginDataValid): array
    {
        $userEmail = Arr::get($loginDataValid, "email");
        $userLoginPassword = Arr::get($loginDataValid, "password");

        $userCollection = $this->userRepository->getByAttribute('email', $userEmail)->get();

        if(!$userCollection){
            throw new PermitionException("Senha ou Email não encontrados"); //devo colocar um exception here
        }

        $userArray = $userCollection->toArray();
        $userDbData = Arr::get($userArray, array_key_first($userArray));
        $userDbPassword = Arr::get($userDbData, "password");

        if(!password_verify($userLoginPassword, $userDbPassword)){
            throw new PermitionException("Senha ou Email não encontrados 2"); //devo colocar um exception here
        }

        return $userDbData;
    }

    public function isValid(array $loginDataValid)
    {
        
        $userDbData = $this->login($loginDataValid);

        if(empty($userDbData)){
            throw new PermitionException("Senha ou Email não encontrados 3");    
        }
            
        $this->setUserDataSession($userDbData);        
        
    }
}
