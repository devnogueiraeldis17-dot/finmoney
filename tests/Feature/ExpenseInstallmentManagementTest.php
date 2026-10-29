<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Launch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseInstallmentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_an_entire_installment_group(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $launch = Launch::create([
            'user_id' => $admin->id,
            'name' => 'Orçamento pessoal',
            'month' => 10,
            'year' => 2026,
        ]);

        $category = Category::create([
            'name' => 'Alimentação',
        ]);

        $group = (string) \Illuminate\Support\Str::uuid();

        // Parcelamento original: 2 parcelas de R$ 50,00.
        $firstExpense = Expense::create([
            'user_id' => $admin->id,
            'launch_id' => $launch->id,
            'category_id' => $category->id,
            'name' => 'Compra original',
            'description' => 'Antes da edição',
            'value' => 50.00,
            'installments' => 2,
            'installment_number' => 1,
            'installment_group' => $group,
            'due_date' => '2026-10-28',
        ]);

        Expense::create([
            'user_id' => $admin->id,
            'launch_id' => $launch->id,
            'category_id' => $category->id,
            'name' => 'Compra original',
            'description' => 'Antes da edição',
            'value' => 50.00,
            'installments' => 2,
            'installment_number' => 2,
            'installment_group' => $group,
            'due_date' => '2026-11-28',
        ]);

        $response = $this->actingAs($admin)->put(
            route('admin.expenses.update', $firstExpense),
            [
                'launch_id' => $launch->id,
                'category_id' => $category->id,
                'name' => 'Compra atualizada',
                'description' => 'Depois da edição',
                'value' => 120.00,
                'installments' => 3,
                'due_date' => '2026-10-28',
            ]
        );

        $response->assertRedirect(route('expenses.index'));

        $expenses = Expense::where('user_id', $admin->id)
            ->orderBy('installment_number')
            ->get();

        $this->assertCount(3, $expenses);

        $this->assertSame(
            ['40.00', '40.00', '40.00'],
            $expenses->pluck('value')->all()
        );

        $this->assertSame(
            ['Compra atualizada', 'Compra atualizada', 'Compra atualizada'],
            $expenses->pluck('name')->all()
        );

        $this->assertSame(
            [1, 2, 3],
            $expenses->pluck('installment_number')->all()
        );

        $this->assertSame(
            1,
            $expenses->pluck('installment_group')->unique()->count()
        );

        $this->assertSame(
            120.00,
            round((float) $expenses->sum('value'), 2)
        );
    }


    public function test_updating_expense_without_group_does_not_delete_other_ungrouped_expenses(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $launch = Launch::create([
            'user_id' => $admin->id,
            'name' => 'Orçamento pessoal',
            'month' => 10,
            'year' => 2026,
        ]);

        $category = Category::create([
            'name' => 'Alimentação',
        ]);

        $expense1 = Expense::create([
            'user_id' => $admin->id,
            'launch_id' => $launch->id,
            'category_id' => $category->id,
            'name' => 'Despesa que será editada',
            'description' => null,
            'value' => 50.00,
            'installments' => 1,
            'installment_number' => 1,
            'installment_group' => null,
            'due_date' => '2026-10-28',
        ]);

        $expense2 = Expense::create([
            'user_id' => $admin->id,
            'launch_id' => $launch->id,
            'category_id' => $category->id,
            'name' => 'Despesa que deve ser preservada',
            'description' => null,
            'value' => 30.00,
            'installments' => 1,
            'installment_number' => 1,
            'installment_group' => null,
            'due_date' => '2026-10-29',
        ]);

        $response = $this->actingAs($admin)->put(
            route('admin.expenses.update', $expense1),
            [
                'launch_id' => $launch->id,
                'category_id' => $category->id,
                'name' => 'Despesa atualizada',
                'description' => null,
                'value' => 60.00,
                'installments' => 1,
                'due_date' => '2026-10-28',
            ]
        );

        $response->assertRedirect(route('expenses.index'));

        $this->assertDatabaseHas('expenses', [
            'id' => $expense2->id,
            'name' => 'Despesa que deve ser preservada',
            'value' => '30.00',
        ]);

        $this->assertDatabaseMissing('expenses', [
            'id' => $expense1->id,
        ]);

        $this->assertDatabaseHas('expenses', [
            'user_id' => $admin->id,
            'name' => 'Despesa atualizada',
            'value' => '60.00',
            'installment_number' => 1,
        ]);
    }


    public function test_admin_can_delete_entire_installment_group_without_deleting_other_expenses(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $launch = Launch::create([
            'user_id' => $admin->id,
            'name' => 'Orçamento pessoal',
            'month' => 10,
            'year' => 2026,
        ]);

        $category = Category::create([
            'name' => 'Alimentação',
        ]);

        $groupToDelete = (string) \Illuminate\Support\Str::uuid();
        $groupToKeep = (string) \Illuminate\Support\Str::uuid();

        $firstExpense = Expense::create([
            'user_id' => $admin->id,
            'launch_id' => $launch->id,
            'category_id' => $category->id,
            'name' => 'Compra parcelada',
            'description' => null,
            'value' => 50.00,
            'installments' => 2,
            'installment_number' => 1,
            'installment_group' => $groupToDelete,
            'due_date' => '2026-10-28',
        ]);

        $secondExpense = Expense::create([
            'user_id' => $admin->id,
            'launch_id' => $launch->id,
            'category_id' => $category->id,
            'name' => 'Compra parcelada',
            'description' => null,
            'value' => 50.00,
            'installments' => 2,
            'installment_number' => 2,
            'installment_group' => $groupToDelete,
            'due_date' => '2026-11-28',
        ]);

        $otherExpense = Expense::create([
            'user_id' => $admin->id,
            'launch_id' => $launch->id,
            'category_id' => $category->id,
            'name' => 'Outra compra',
            'description' => null,
            'value' => 30.00,
            'installments' => 1,
            'installment_number' => 1,
            'installment_group' => $groupToKeep,
            'due_date' => '2026-10-29',
        ]);

        $response = $this->actingAs($admin)->delete(
            route('admin.expenses.destroy', $firstExpense)
        );

        $response->assertRedirect(route('expenses.index'));

        $this->assertDatabaseMissing('expenses', [
            'id' => $firstExpense->id,
        ]);

        $this->assertDatabaseMissing('expenses', [
            'id' => $secondExpense->id,
        ]);

        $this->assertDatabaseHas('expenses', [
            'id' => $otherExpense->id,
            'name' => 'Outra compra',
            'installment_group' => $groupToKeep,
        ]);
    }


}
