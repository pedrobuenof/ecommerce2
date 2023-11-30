<?php

namespace App\Services;

use App\Exceptions\PermitionException;
use App\Repositories\Interfaces\UserRepositorieInterface;
use App\Trait\SessionTrait;
use App\UseCases\LoginUserInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class LoginUserService implements LoginUserInterface
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
            throw new PermitionException("Senha ou Email não encontrados");
        }

        $userArray = $userCollection->toArray();
        Log::info('aaa', $userArray);
        $userDbData = Arr::get($userArray, array_key_first($userArray));
        $userDbPassword = Arr::get($userDbData, "password");

        
        //!password_verify($userLoginPassword, $userDbPassword)
        if($userLoginPassword != $userDbPassword){
            throw new PermitionException("$userLoginPassword != $userDbPassword");
        }

        return $userDbData;
    }

    public function isValid(array $loginDataValid): void
    {
        
        $userDbData = $this->login($loginDataValid);

        if(!$userDbData){
            throw new PermitionException("Senha ou Email não encontrados 3");    
        }
            
        $this->setUserDataSession($userDbData);        
        
    }
}
