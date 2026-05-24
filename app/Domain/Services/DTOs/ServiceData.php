<?php
namespace App\Domain\Services\DTOs;

use App\Domain\Services\Requests\StoreServiceRequest;

readonly class ServiceData{
    public function __construct(
        public string $name,
        public ?string $description,
        public int $duration,
        public int $buffer_time,
        public float $price,
    ) {}

    public static function fromRequest(
        StoreServiceRequest $request
    ): self {

        return new self(
            name: $request->name,
            description: $request->description,
            duration: (int) $request->duration,
            buffer_time: (int) $request->buffer_time,
            price: (float) $request->price,
        );
    }
}
