<?php

namespace App\Services;

use App\Exceptions\NullUserException;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositorieInterface;
use App\UseCases\CreateUserInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
class CreateUserService implements CreateUserInterface
{
    private UserRepositorieInterface $userRepository;
    
    public function __construct(UserRepositorieInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }
    
    
    public function execute(UserCreateRequest $userValidated): ?User 
    {

        try {

            $userValidated = $userValidated->toArray();
            
            //Implementar de fato no middleware
            /*if($userValidated['name'] != 'admin'){
                $statusCode = 401;
                throw new PermitionException("Usuário não tem permissão", $statusCode);
            }
            */

            $userValidated['password'] = bcrypt($userValidated['password']);
            Log::info($userValidated);

            $user = $this->userRepository->store($userValidated);

            // Verifica se existe usuário/foi criado
            if(!$user){               
                throw new NullUserException("O usuário não foi salvo, tente novamente!");
            }

            return $user;
        } catch (QueryException $e)  {
            Log::info($e->getMessage());
            throw new QueryException('Os dados são inválidos, por favor revise', [], new \Exception());
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            throw new \Exception($e->getMessage());
        } 
    }
}
