<?php

namespace App\Http\Controllers;

use App\Exceptions\NullUserException;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\Request;
use App\UseCases\CreateUserInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

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
}
