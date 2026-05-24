<?php

namespace App\Domain\Businesses\DTOs;

use App\Domain\Businesses\Requests\StoreBusinessRequest;

readonly class BusinessData{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?string $phone,
        public ?string $email,
        public ?string $city,
        public ?string $address,
    ) {}

    public static function fromRequest(
        StoreBusinessRequest $request
    ): self {
        return new self(
            name: $request->name,
            description: $request->description,
            phone: $request->phone,
            email: $request->email,
            city: $request->city,
            address: $request->address,
        );
    }
}
