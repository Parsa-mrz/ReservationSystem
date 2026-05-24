<?php

namespace  App\Domain\Auth\DTOs;

use App\Http\Requests\Auth\RegisterRequest;

readonly class RegisterData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}

    public static function fromRequest(RegisterRequest $request): self
    {
        return new self(
            name: $request->name,
            email: $request->email,
            password: $request->password,
        );
    }
}
