<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Launch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_expense_in_installments(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $launch = Launch::create([
            'user_id' => $user->id,
            'name' => 'Orçamento pessoal',
            'month' => 10,
            'year' => 2026,
        ]);

        $category = Category::create([
            'name' => 'Alimentação',
        ]);

        $response = $this->actingAs($user)->post(route('expenses.store'), [
            'launch_id' => $launch->id,
            'category_id' => $category->id,
            'name' => 'Compra no mercado',
            'description' => 'Compra mensal',
            'value' => 100.00,
            'installments' => 3,
            'due_date' => '2026-10-31',
        ]);

        $response->assertRedirect(route('expenses.index'));

        $this->assertDatabaseCount('expenses', 3);

        $expenses = Expense::where('user_id', $user->id)
            ->orderBy('installment_number')
            ->get();

        $this->assertCount(3, $expenses);

        $this->assertSame('33.34', $expenses[0]->value);
        $this->assertSame('33.33', $expenses[1]->value);
        $this->assertSame('33.33', $expenses[2]->value);

        $this->assertSame([1, 2, 3], $expenses->pluck('installment_number')->all());

        $this->assertSame(
            1,
            $expenses->pluck('installment_group')->unique()->count()
        );

        $this->assertSame(
            [$user->id],
            $expenses->pluck('user_id')->unique()->all()
        );
    }

    public function test_user_cannot_create_expense_using_another_users_launch(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $otherUser = User::factory()->create([
            'role' => 'comum',
        ]);

        $otherLaunch = Launch::create([
            'user_id' => $otherUser->id,
            'name' => 'Orçamento privado',
            'month' => 10,
            'year' => 2026,
        ]);

        $category = Category::create([
            'name' => 'Alimentação',
        ]);

        $response = $this->actingAs($user)->from('/despesas/criar')
            ->post(route('expenses.store'), [
                'launch_id' => $otherLaunch->id,
                'category_id' => $category->id,
                'name' => 'Despesa não autorizada',
                'description' => '',
                'value' => 100.00,
                'installments' => 1,
                'due_date' => '2026-10-31',
            ]);

        $response->assertRedirect('/despesas/criar');
        $response->assertSessionHasErrors('launch_id');

        $this->assertDatabaseCount('expenses', 0);
    }

    public function test_expense_creation_rejects_invalid_data(): void
    {
        $user = User::factory()->create([
            'role' => 'comum',
        ]);

        $response = $this->actingAs($user)
            ->post(route('expenses.store'), [
                'launch_id' => '',
                'category_id' => '',
                'name' => '',
                'value' => 0,
                'installments' => 0,
                'due_date' => '',
            ]);

        $response->assertSessionHasErrors([
            'launch_id',
            'category_id',
            'name',
            'value',
            'installments',
            'due_date',
        ]);

        $this->assertDatabaseCount('expenses', 0);
    }


    public function test_expense_installments_distribute_cents_without_losing_money(): void
    {
        $user = User::factory()->create();

        $launch = Launch::create([
            'user_id' => $user->id,
            'name' => 'Orçamento pessoal',
            'month' => 10,
            'year' => 2026,
        ]);

        $category = Category::create([
            'name' => 'Alimentação',
        ]);

        $response = $this->actingAs($user)->post(
            route('expenses.store'),
            [
                'launch_id' => $launch->id,
                'category_id' => $category->id,
                'name' => 'Compra de R$ 100',
                'description' => null,
                'value' => 100.00,
                'installments' => 3,
                'due_date' => '2026-10-28',
            ]
        );

        $response->assertRedirect(route('expenses.index'));

        $expenses = Expense::where('user_id', $user->id)
            ->where('name', 'Compra de R$ 100')
            ->orderBy('installment_number')
            ->get();

        $this->assertCount(3, $expenses);

        $this->assertSame(
            ['33.34', '33.33', '33.33'],
            $expenses->pluck('value')->all()
        );

        $this->assertSame(
            10000,
            (int) round($expenses->sum(
                fn ($expense) => (float) $expense->value * 100
            ))
        );
    }


public function test_installments_handle_leap_year_dates_correctly(): void
{
    $user = User::factory()->create();

    $launch = Launch::create([
        'user_id' => $user->id,
        'name' => 'Orçamento pessoal',
        'month' => 1,
        'year' => 2028,
    ]);

    $category = Category::create([
        'name' => 'Alimentação',
    ]);

    $response = $this->actingAs($user)->post(
        route('expenses.store'),
        [
            'launch_id' => $launch->id,
            'category_id' => $category->id,
            'name' => 'Compra em ano bissexto',
            'description' => null,
            'value' => 90.00,
            'installments' => 3,
            'due_date' => '2028-01-31',
        ]
    );

    $response->assertRedirect(route('expenses.index'));

    $expenses = Expense::where('user_id', $user->id)
        ->where('name', 'Compra em ano bissexto')
        ->orderBy('installment_number')
        ->get();

    $this->assertSame(
        ['2028-01-31', '2028-02-29', '2028-03-31'],
        $expenses->pluck('due_date')
            ->map(fn ($date) => $date->toDateString())
            ->all()
    );
}

    public function test_installments_cross_year_boundary_with_valid_dates(): void
    {
        $user = User::factory()->create();

        $launch = Launch::create([
            'user_id' => $user->id,
            'name' => 'Orçamento pessoal',
            'month' => 12,
            'year' => 2026,
        ]);

        $category = Category::create([
            'name' => 'Alimentação',
        ]);

        $response = $this->actingAs($user)->post(
            route('expenses.store'),
            [
                'launch_id' => $launch->id,
                'category_id' => $category->id,
                'name' => 'Compra na virada do ano',
                'description' => null,
                'value' => 90.00,
                'installments' => 3,
                'due_date' => '2026-12-31',
            ]
        );

        $response->assertRedirect(route('expenses.index'));

        $expenses = Expense::where('user_id', $user->id)
            ->where('name', 'Compra na virada do ano')
            ->orderBy('installment_number')
            ->get();

        $this->assertSame(
            ['2026-12-31', '2027-01-31', '2027-02-28'],
            $expenses->pluck('due_date')
                ->map(fn ($date) => $date->toDateString())
                ->all()
        );

        $this->assertSame(
            [2026, 2027, 2027],
            $expenses->pluck('due_date')
                ->map(fn ($date) => (int) $date->format('Y'))
                ->all()
        );
    }


}
