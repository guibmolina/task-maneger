<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignOnRequest;
use Domain\User\Entities\UserEntity;
use Domain\User\UseCases\SignOnUser\DTO;
use Domain\User\UseCases\SignOnUser\SignOnUser;
use Exception;
use Illuminate\Http\JsonResponse;
use Infra\User\Services\SignOnUser as SignOnUserService;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['signOn']]);
    }

    public function signOn(SignOnRequest $request): JsonResponse
    {
        $request->validated();

        $userEntity = new UserEntity(null, null, $request->email, $request->password, null);
        $DTO = new DTO($userEntity);

        $signOnUseCase = new SignOnUser(new SignOnUserService());

        try {
            $userLogged = $signOnUseCase->execute($DTO);
        } catch(Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($userLogged->response()); 
    }
}
