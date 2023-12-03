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
        
        $userDbData = Arr::get($userArray, array_key_first($userArray));
        
        $userDbPassword = Arr::get($userDbData, "password");
        // Log::info('c', $userDbPassword); -> Ta dando erro, acredito por que conta de que userDbData se pa não é um array, logo
        
        if(!password_verify($userLoginPassword, $userDbPassword)){
            throw new PermitionException("E-mail ou senha inválidos!");
        }

        return $userDbData;
    }

    public function isValid(array $loginDataValid): array
    {
        
        $userDbData = $this->login($loginDataValid);
        // Log::info($userDbData['password']);

        if(!$userDbData){
            throw new PermitionException("Senha ou Email não encontrados 3");    
        }
            
        $this->setUserDataSession($userDbData);
        
        return $userDbData;
        
    }
}
