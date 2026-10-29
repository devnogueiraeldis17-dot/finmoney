<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaunchValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_launch_fields_are_required(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $response = $this->actingAs($user)
            ->from(route('launches.create'))
            ->post(route('launches.store'), []);

        $response->assertRedirect(route('launches.create'));

        $response->assertSessionHasErrors([
            'name',
            'month',
            'year',
        ]);
    }

    public function test_launch_rejects_invalid_month_and_year(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $response = $this->actingAs($user)
            ->from(route('launches.create'))
            ->post(route('launches.store'), [
                'name' => 'Lançamento de teste',
                'month' => 13,
                'year' => 1999,
            ]);

        $response->assertRedirect(route('launches.create'));

        $response->assertSessionHasErrors([
            'month',
            'year',
        ]);
    }

    public function test_launch_name_cannot_exceed_120_characters(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $response = $this->actingAs($user)
            ->from(route('launches.create'))
            ->post(route('launches.store'), [
                'name' => str_repeat('A', 121),
                'month' => 10,
                'year' => 2026,
            ]);

        $response->assertRedirect(route('launches.create'));

        $response->assertSessionHasErrors([
            'name',
        ]);
    }
}
