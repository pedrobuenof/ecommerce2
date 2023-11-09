<?php

namespace App\Http\Controllers;

use app\Exception\PermitionException;
use app\Exception\NullUserException;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\Request;
use App\UseCases\CreateUserInterface;

class UserController extends Controller
{

    protected CreateUserInterface $createUser;

    
    public function __construct(CreateUserInterface $createUser)
    {

        $this->createUser = $createUser;
    
    }

    /**
        * @param Request $request O objeto de solicitação HTTP.
        * @return JsonResponse Uma resposta JSON.
        * @
    */
    public function create(UserCreateRequest $request)
    {
        
        try {

            $userValidated = $request->validated();
            //dd($userValidated);
        
            $user = $this->createUser->execute($userValidated);

            // Verifica se existe usuário/foi criado
            if(!$user){
                $statusCode = 402;
                throw new NullUserException("O usuário não foi salvo, tente novamente!", $statusCode);
            }
            
            // Verifica se o usuário tem permissão de admin - implementação base
            if($user->getNomeAttribute() != 'admin'){
                $statusCode = 401;
                throw new PermitionException("Usuário não tem permissão", $statusCode);
            }

            $statusCode = 201; 
            return response()->json(['message' => 'Usuário criado com sucesso', 'user' => $user], $statusCode);

        } catch (NullUserException $e) {
            var_dump($e);
        } catch (PermitionException $e) {
            var_dump($e);
        }

    }
}
