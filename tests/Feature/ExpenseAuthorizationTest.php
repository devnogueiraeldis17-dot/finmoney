<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Launch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function createExpenseFor(User $user): Expense
    {
        $launch = Launch::create([
            'user_id' => $user->id,
            'name' => 'Orçamento pessoal',
            'month' => 10,
            'year' => 2026,
        ]);

        $category = Category::create([
            'name' => 'Alimentação',
        ]);

        return Expense::create([
            'user_id' => $user->id,
            'launch_id' => $launch->id,
            'category_id' => $category->id,
            'name' => 'Compra no mercado',
            'description' => 'Despesa de teste',
            'value' => 100.00,
            'installments' => 1,
            'installment_number' => 1,
            'installment_group' => null,
            'due_date' => '2026-10-28',
        ]);
    }

    public function test_common_user_cannot_edit_an_expense(): void
    {
        $owner = User::factory()->create([
            'role' => 'comum',
        ]);

        $expense = $this->createExpenseFor($owner);

        $this->actingAs($owner)
            ->get(route('admin.expenses.edit', $expense))
            ->assertForbidden();
    }

    public function test_common_user_cannot_delete_an_expense(): void
    {
        $owner = User::factory()->create([
            'role' => 'comum',
        ]);

        $expense = $this->createExpenseFor($owner);

        $this->actingAs($owner)
            ->delete(route('admin.expenses.destroy', $expense))
            ->assertForbidden();

        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'name' => 'Compra no mercado',
        ]);
    }

    public function test_common_user_cannot_edit_another_users_expense(): void
    {
        $owner = User::factory()->create([
            'role' => 'comum',
        ]);

        $otherUser = User::factory()->create([
            'role' => 'comum',
        ]);

        $expense = $this->createExpenseFor($otherUser);

        $this->actingAs($owner)
            ->get(route('admin.expenses.edit', $expense))
            ->assertForbidden();

        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'user_id' => $otherUser->id,
        ]);
    }
}
