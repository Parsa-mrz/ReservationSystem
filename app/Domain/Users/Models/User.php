<?php

namespace App\Domain\Users\Models;

use App\Domain\Businesses\Models\Business;
use App\Domain\Users\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Console\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name','email','password','role'])]
#[Hidden(['password','remember_token'])]
class User extends Authenticatable {

	/** @use HasFactory<UserFactory> */
	use HasFactory;
	use Notifiable;
	use HasApiTokens;

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array {
		return array(
			'email_verified_at' => 'datetime',
			'password'          => 'hashed',
            'role' => UserRole::class,
		);
	}

    protected static function newFactory(): Factory|UserFactory
    {
        return UserFactory::new();
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class,'owner_id');
    }

	public function isOwner(): bool
	{
		return $this->role === UserRole::OWNER;
	}

	public function isAdmin():bool{
		return $this->role === UserRole::ADMIN;
	}
}
