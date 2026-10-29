<?php

namespace Tests\Feature;

use App\Models\Launch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaunchAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_common_user_sees_only_their_own_launches(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $otherUser = User::factory()->create([
            'role' => 'comum',
        ]);

        $ownLaunch = Launch::create([
            'user_id' => $user->id,
            'name' => 'Meu orçamento',
            'month' => 10,
            'year' => 2026,
        ]);

        Launch::create([
            'user_id' => $otherUser->id,
            'name' => 'Orçamento de outra pessoa',
            'month' => 10,
            'year' => 2026,
        ]);

        $response = $this->actingAs($user)
            ->get(route('launches.index'));

        $response->assertOk();
        $response->assertSee('Meu orçamento');
        $response->assertDontSee('Orçamento de outra pessoa');
    }

    public function test_common_user_cannot_view_another_users_launch(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $otherUser = User::factory()->create([
            'role' => 'comum',
        ]);

        $launch = Launch::create([
            'user_id' => $otherUser->id,
            'name' => 'Lançamento privado',
            'month' => 10,
            'year' => 2026,
        ]);

        $this->actingAs($user)
            ->get(route('launches.show', $launch))
            ->assertForbidden();
    }
}
