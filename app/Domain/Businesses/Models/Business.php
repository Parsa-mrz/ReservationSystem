<?php

namespace App\Domain\Businesses\Models;

use App\Domain\Users\Models\User;
use Database\Factories\BusinessFactory;
use App\Domain\Services\Models\Service;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'owner_id',
    'name',
    'slug',
    'description',
    'phone',
    'email',
    'city',
    'address',
    'is_active',
])]
class Business extends Model{
    use HasFactory;

    protected static function newFactory(): Factory|BusinessFactory
    {
        return BusinessFactory::new();
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'business_id');
    }
}
