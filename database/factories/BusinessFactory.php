<?php

namespace Database\Factories;

use App\Domain\Businesses\Models\Business;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Business>
 */
class BusinessFactory extends Factory
{
    protected $model = Business::class;

    public function definition(): array
    {
        $name = $this->faker->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'description' => $this->faker->paragraph(2),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'is_active' => true,
            'owner_id' => User::factory(),
        ];
    }

    /**
     * Inactive business state
     */
    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }

    /**
     * Without owner (for edge testing)
     */
    public function withoutOwner(): static
    {
        return $this->state(fn () => [
            'user_id' => null,
        ]);
    }

    /**
     * Minimal business (useful for slim API tests)
     */
    public function minimal(): static
    {
        return $this->state(fn () => [
            'description' => null,
            'phone' => null,
            'website' => null,
        ]);
    }
}
