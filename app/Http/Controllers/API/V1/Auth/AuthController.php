<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Domain\Auth\Actions\LoginUserAction;
use App\Domain\Auth\Actions\RegisterUserAction;
use App\Domain\Auth\DTOs\LoginData;
use App\Domain\Auth\DTOs\RegisterData;
use App\Domain\Auth\Requests\LoginRequest;
use App\Domain\Auth\Requests\RegisterRequest;
use App\Domain\Users\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(
        RegisterRequest $request,
        RegisterUserAction $action
    ): JsonResponse {

        $user = $action->handle(
            RegisterData::fromRequest($request)
        );

        $token = $user->createToken('api')->plainTextToken;

        return $this->success(
            data:[
                'user' => UserResource::make($user),
                'token' => $token
            ],
            message: 'Register successfully.',
            status: 201
        );
    }

    public function login(
        LoginRequest $request,
        LoginUserAction $action
    ): JsonResponse
    {
        $user = $action->handle(
            LoginData::fromRequest($request)
        );

        $token = $user->createToken('api')->plainTextToken;

        return $this->success(
            data:[
                'user' => UserResource::make($user),
                'token' => $token
            ],
            message: 'Login successfully.',
        );
    }


    public function logout(Request $request): JsonResponse{
        $request->user()->tokens()->delete();

        return $this->success(
            message: 'Logged out successfully.'
        );
    }
}
