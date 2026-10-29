<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinMoneyAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'teste@finmoney.com',
            'password' => bcrypt('Senha123!'),
            'role' => 'comum',
        ]);

        $response = $this->post('/login', [
            'email' => 'teste@finmoney.com',
            'password' => 'Senha123!',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        User::factory()->create([
            'email' => 'teste@finmoney.com',
            'password' => bcrypt('Senha123!'),
            'role' => 'comum',
        ]);

        $this->post('/login', [
            'email' => 'teste@finmoney.com',
            'password' => 'senha-errada',
        ]);

        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $this->actingAs($user);

        $this->post('/logout');

        $this->assertGuest();
    }
}
