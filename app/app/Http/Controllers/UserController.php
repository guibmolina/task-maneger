<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Domain\User\UseCases\CreateUser\CreateUser;
use Domain\User\UseCases\CreateUser\DTO;
use Domain\User\UseCases\GetUsers\GetUsers;
use Exception;
use Illuminate\Http\JsonResponse;
use Infra\User\Repositories\UserRepository;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $DTO = new DTO(
            $request->name,
            $request->email,
            $request->password
        );

        $storeUserUseCase = new CreateUser(new UserRepository());

        try {
            $user = $storeUserUseCase->execute($DTO);
        } catch(Exception $e) {
            return response()->json(['Server Error'], 500);
        }

        return response()->json($user->response());
    }

    public function index(): JsonResponse
    {
        $getUserUseCase = new GetUsers(new UserRepository());

        try {
            $users = $getUserUseCase->execute();
        } catch(Exception $e) {
            return response()->json(['Server Error'], 500);
        }

        return response()->json($users->response());

    }
}
