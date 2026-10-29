<?php

namespace Tests\Feature;

use App\Models\Launch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaunchTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_a_launch(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $response = $this->actingAs($user)
            ->post(route('launches.store'), [
                'name' => 'Orçamento de teste',
                'month' => 10,
                'year' => 2026,
            ]);

        $launch = Launch::where('user_id', $user->id)
            ->where('name', 'Orçamento de teste')
            ->first();

        $this->assertNotNull($launch);
        $this->assertDatabaseHas('launches', [
            'id' => $launch->id,
            'user_id' => $user->id,
            'name' => 'Orçamento de teste',
            'month' => 10,
            'year' => 2026,
        ]);

        $response->assertRedirect(route('launches.show', $launch));
    }

    public function test_creating_the_same_launch_does_not_duplicate_it(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $data = [
            'name' => 'Orçamento de teste',
            'month' => 10,
            'year' => 2026,
        ];

        $this->actingAs($user)
            ->post(route('launches.store'), $data);

        $this->post(route('launches.store'), $data);

        $this->assertDatabaseCount('launches', 1);
    }
}
