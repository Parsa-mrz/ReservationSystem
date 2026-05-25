<?php

namespace App\Domain\Auth\Actions\Interfaces;

use App\Domain\Auth\DTOs\LoginData;
use App\Domain\Users\Models\User;

interface LoginUser
{
    public function handle(LoginData $data): User;
}
