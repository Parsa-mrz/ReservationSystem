<?php

namespace App\Domain\Businesses\Models;

use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
