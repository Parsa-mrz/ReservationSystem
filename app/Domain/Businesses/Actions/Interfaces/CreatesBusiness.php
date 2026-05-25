<?php

namespace App\Domain\Businesses\Actions\Interfaces;

use App\Domain\Businesses\DTOs\BusinessData;
use App\Domain\Businesses\Models\Business;
use App\Domain\Users\Models\User;

interface CreatesBusiness
{
    public function handle(BusinessData $data, User $owner): Business;
}
