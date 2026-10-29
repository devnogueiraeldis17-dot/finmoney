<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinMoneyAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_common_user_cannot_access_admin_users(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $this->actingAs($user)
            ->get(route('admin.usuarios.index'))
            ->assertForbidden();
    }
}
