<?php

namespace App\Http\Controllers\API\V1\User;

use App\Domain\Users\Models\User;
use App\Domain\Users\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        return $this->success([
            'user' => UserResource::make($request->user()),
        ]);
    }
}
