<?php

namespace Tests\Feature\Api\V1;

use App\Domain\Businesses\Models\Business;
use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_create_service(): void
    {
        $owner = User::factory()->owner()->create();

        $business = Business::factory()->create([
            'owner_id' => $owner->id,
        ]);

        Sanctum::actingAs($owner);

        $payload = [
            'name' => 'Hair Cut',
            'description' => 'Classic haircut',
            'duration' => 30,
            'buffer_time' => 10,
            'price' => 25.50,
        ];

        $response = $this->postJson(
            "/api/v1/businesses/{$business->id}/services",
            $payload
        );

        $response
            ->assertCreated()
            ->assertJsonPath('message', 'Service created successfully')
            ->assertJsonPath('data.service.name', 'Hair Cut');

        $this->assertDatabaseHas('services', [
            'business_id' => $business->id,
            'name' => 'Hair Cut',
            'duration' => 30,
        ]);
    }

    public function test_non_owner_cannot_create_service(): void
    {
        $owner = User::factory()->owner()->create();

        $anotherUser = User::factory()->create();

        $business = Business::factory()->create([
            'owner_id' => $owner->id,
        ]);

        Sanctum::actingAs($anotherUser);

        $payload = [
            'name' => 'Hair Cut',
            'duration' => 30,
            'price' => 25,
        ];

        $response = $this->postJson(
            "/api/v1/businesses/{$business->id}/services",
            $payload
        );

        $response->assertForbidden();
    }

    public function test_validation_errors_are_returned(): void
    {
        $owner = User::factory()->owner()->create();

        $business = Business::factory()->create([
            'owner_id' => $owner->id,
        ]);

        Sanctum::actingAs($owner);

        $response = $this->postJson(
            "/api/v1/businesses/{$business->id}/services",
            []
        );

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'duration',
                'price',
            ]);
    }
}
