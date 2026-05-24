<?php

namespace Tests\Feature\Api\V1;

use App\Domain\Businesses\Models\Business;
use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BusinessTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function it_can_list_businesses()
    {
        Business::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/businesses');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'businesses' => [
                        '*' => [
                            'id',
                            'name',
                            'slug',
                        ]
                    ]
                ]
            ]);
    }

    #[Test]
    public function it_can_show_single_business_by_slug()
    {
        $business = Business::factory()->create([
            'slug' => 'test-business'
        ]);

        $response = $this->getJson('/api/v1/businesses/test-business');

        $response->assertOk()
            ->assertJsonPath('data.business.slug', 'test-business');
    }

    #[Test]
    public function it_returns_404_if_business_not_found()
    {
        $response = $this->getJson('/api/v1/businesses/wrong-slug');

        $response->assertNotFound();
    }

    #[Test]
    public function authenticated_user_can_create_business()
    {
        Sanctum::actingAs(
            User::factory()->owner()->create()
        );

        $payload = [
            'name' => 'My Barber Shop',
            'description' => 'Best fade in town',
            'address' => 'NYC Street 123'
        ];

        $response = $this->postJson('/api/v1/businesses', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.business.name', 'My Barber Shop');

        $this->assertDatabaseHas('businesses', [
            'name' => 'My Barber Shop'
        ]);
    }

    #[Test]
    public function guest_cannot_create_business()
    {
        $payload = [
            'name' => 'Unauthorized Business'
        ];

        $response = $this->postJson('/api/v1/businesses', $payload);

        $response->assertUnauthorized();
    }

    #[Test]
    public function business_creation_requires_validation()
    {
        Sanctum::actingAs(User::factory()->owner()->create());

        $response = $this->postJson('/api/v1/businesses', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
}
