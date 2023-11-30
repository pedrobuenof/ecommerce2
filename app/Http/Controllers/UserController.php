<?php

namespace App\Http\Controllers;

use App\Exceptions\NullUserException;
use App\Exceptions\PermitionException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\Request;
use App\UseCases\CreateUserInterface;
use App\UseCases\LoginUserInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected CreateUserInterface $createUser;
    protected LoginUserInterface $loginUser;

    public function __construct(CreateUserInterface $createUser, LoginUserInterface $loginUser)
    {
        $this->createUser = $createUser;
        $this->loginUser = $loginUser;
    }

    /**
        * @param Request $request O objeto de solicitação HTTP.
        * @return JsonResponse Uma resposta JSON.
        * @
    */
    public function create(UserCreateRequest $request)
    {       
        try {
            $request->validated();                  
            
            $user = $this->createUser->execute($request);
            
            return response()->json(['message' => 'Usuário criado com sucesso', 'user' => $user], Response::HTTP_CREATED);

        } catch (NullUserException $e) {
            return response()->json(['message' => "deu errado2: " . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (QueryException $e)  {
            return response()->json(['message' => "deu errado3: " . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return response()->json(['message' => "deu errado1: " . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function index (LoginRequest $loginRequest)
    {
        try {
            
            $loginData = $loginRequest->validated();
            $this->loginUser->isValid($loginData);

            return response()->json(['logado!'], Response::HTTP_OK);

        } catch (PermitionException $e) {
            return response()->json(['message' => "deu errado4: " . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
