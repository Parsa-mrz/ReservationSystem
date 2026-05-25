<?php

namespace  App\Domain\Auth\Actions;

use App\Domain\Auth\Actions\Interfaces\RegistersUser;
use App\Domain\Auth\DTOs\RegisterData;
use App\Domain\Users\Models\User;

class RegisterUserAction implements RegistersUser{
    public function handle(RegisterData $data): User
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
        ]);
    }
}
