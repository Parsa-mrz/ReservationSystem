<?php

namespace App\Domain\Services\Actions\Interfaces;

use App\Domain\Services\DTOs\ServiceData;
use App\Domain\Services\Models\Service;

interface CreatesService
{
    public function handle(ServiceData $data, int $businessId): Service;
}
