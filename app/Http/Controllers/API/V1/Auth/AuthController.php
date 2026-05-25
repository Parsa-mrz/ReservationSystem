<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Domain\Auth\Actions\Interfaces\LoginUser;
use App\Domain\Auth\Actions\Interfaces\RegistersUser;
use App\Domain\Users\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(
        RegisterRequest $request,
        RegistersUser $action
    ): JsonResponse {

        $user = $action->handle($request->toDTO());

        $token = $user->createToken('api')->plainTextToken;

        return $this->success(
            data:[
                'user' => UserResource::make($user),
                'token' => $token
            ],
            message: 'Register successfully.',
            status: Response::HTTP_CREATED
        );
    }

    public function login(
        LoginRequest $request,
        LoginUser $action
    ): JsonResponse
    {
        $user = $action->handle($request->toDTO());

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
