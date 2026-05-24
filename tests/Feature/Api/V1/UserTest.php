<?php

namespace Tests\Feature\Api\V1;

use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function authenticated_user_can_fetch_their_profile()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/user');

        $response->assertOk()
            ->assertJsonStructure([
                'data'
            ]);
    }

    #[Test]
    public function guest_cannot_access_user_profile()
    {
        $response = $this->getJson('/api/v1/user');

        $response->assertStatus(401);
    }

    #[Test]
    public function authenticated_user_can_view_other_user()
    {
        $authUser = User::factory()->create();
        $otherUser = User::factory()->create();

        Sanctum::actingAs($authUser);

        $response = $this->getJson("/api/v1/users/{$otherUser->id}");

        $response->assertOk()
            ->assertJsonStructure([
                'data'
            ]);
    }

    #[Test]
    public function guest_cannot_view_other_user()
    {
        $otherUser = User::factory()->create();

        $response = $this->getJson("/api/v1/users/{$otherUser->id}");

        $response->assertStatus(401);
    }
}
