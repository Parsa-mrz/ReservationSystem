<?php

namespace  App\Domain\Auth\DTOs;

use App\Http\Requests\Auth\LoginRequest;

readonly class LoginData{
    public function __construct(
        public string $email,
        public string $password,
    ) {}

    public static function fromRequest(LoginRequest $request): self
    {
        return new self(
            email: $request->email,
            password: $request->password,
        );
    }
}
