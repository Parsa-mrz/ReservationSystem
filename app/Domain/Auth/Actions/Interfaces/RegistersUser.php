<?php

namespace App\Domain\Auth\Actions\Interfaces;

use App\Domain\Auth\DTOs\RegisterData;
use App\Domain\Users\Models\User;

interface RegistersUser
{
    public function handle(RegisterData $data): User;
}
