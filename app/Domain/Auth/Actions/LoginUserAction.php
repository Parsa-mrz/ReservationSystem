<?php

namespace App\Domain\Auth\Actions;

use App\Domain\Auth\Actions\Interfaces\LoginUser;
use App\Domain\Auth\DTOs\LoginData;
use App\Domain\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUserAction implements LoginUser{
    public function handle(LoginData $data): User
    {
        $user = User::query()
            ->where('email', $data->email)
            ->first();

        if (! $user || ! Hash::check($data->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        return $user;
    }
}
