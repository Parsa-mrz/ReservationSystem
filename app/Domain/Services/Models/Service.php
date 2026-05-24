<?php

namespace App\Domain\Services\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domain\Businesses\Models\Business;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
        'business_id',
        'name',
        'description',
        'duration',
        'buffer_time',
        'price',
        'is_active',
    ])]
class Service extends Model
{
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class,'business_id');
    }

}
