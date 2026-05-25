<?php

namespace App\Domain\Services\Actions;

use App\Domain\Services\Actions\Interfaces\CreatesService;
use App\Domain\Services\DTOs\ServiceData;
use App\Domain\Services\Models\Service;

class CreateServiceAction implements CreatesService{
    public function handle(
        ServiceData $data,
        int $businessId
    ): Service {

        return Service::create([
            'business_id' => $businessId,
            'name' => $data->name,
            'description' => $data->description,
            'duration' => $data->duration,
            'buffer_time' => $data->buffer_time,
            'price' => $data->price,
        ]);
    }
}
