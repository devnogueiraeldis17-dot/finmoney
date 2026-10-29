<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\Launch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ExpenseService
{
    public function create(User $user, array $data): array
    {
        return DB::transaction(function () use ($user, $data) {
            $launch = Launch::whereKey($data['launch_id'])
                ->where('user_id', $user->id)->first();

            if (!$launch) {
                throw ValidationException::withMessages(['launch_id' => 'Lançamento inválido.']);
            }

            $count = (int) $data['installments'];
            $totalCents = (int) round(((float) $data['value']) * 100);

            if ($count < 1 || $count > 120 || $totalCents < $count) {
                throw ValidationException::withMessages(['value' => 'Valor ou quantidade de parcelas inválidos.']);
            }

            $base = intdiv($totalCents, $count);
            $remainder = $totalCents % $count;
            $group = (string) Str::uuid();
            $start = Carbon::parse($data['due_date']);
            $rows = [];

            for ($i = 0; $i < $count; $i++) {
                $date = $start->copy()->addMonthsNoOverflow($i);
                $monthlyLaunch = Launch::firstOrCreate([
                    'user_id' => $user->id,
                    'name' => $launch->name,
                    'month' => $date->month,
                    'year' => $date->year,
                ]);

                $cents = $base + ($i < $remainder ? 1 : 0);
                $rows[] = Expense::create([
                    'user_id' => $user->id,
                    'launch_id' => $monthlyLaunch->id,
                    'category_id' => $data['category_id'],
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
                    'value' => number_format($cents / 100, 2, '.', ''),
                    'installments' => $count,
                    'installment_number' => $i + 1,
                    'installment_group' => $group,
                    'due_date' => $date->toDateString(),
                ]);
            }

            return $rows;
        });
    }


    public function updateGroup(Expense $expense, array $data): void
    {
        DB::transaction(function () use ($expense, $data) {
            $launch = Launch::whereKey($data['launch_id'])
                ->where('user_id', $expense->user_id)
                ->first();

            if (!$launch) {
                throw ValidationException::withMessages([
                    'launch_id' => 'Lançamento inválido para o proprietário da despesa.',
                ]);
            }

            $group = $expense->installment_group;
            $count = (int) $data['installments'];
            $totalCents = (int) round(((float) $data['value']) * 100);

            if ($count < 1 || $count > 120 || $totalCents < $count) {
                throw ValidationException::withMessages([
                    'value' => 'Valor ou quantidade de parcelas inválidos.',
                ]);
            }

            // Guarda os dados antes de excluir os registros antigos.
            $old = $group !== null
                ? Expense::where('installment_group', $group)
                    ->orderBy('installment_number')
                    ->first()
                : $expense;

            // Exclui somente o grupo correspondente.
            if ($group !== null) {
                Expense::where('installment_group', $group)->delete();
            } else {
                $expense->delete();
            }

            $base = intdiv($totalCents, $count);
            $remainder = $totalCents % $count;
            $newGroup = $group ?? (string) Str::uuid();
            $start = Carbon::parse($data['due_date']);

            for ($i = 0; $i < $count; $i++) {
                $date = $start->copy()->addMonthsNoOverflow($i);

                $monthlyLaunch = Launch::firstOrCreate([
                    'user_id' => $expense->user_id,
                    'name' => $launch->name,
                    'month' => $date->month,
                    'year' => $date->year,
                ]);

                $cents = $base + ($i < $remainder ? 1 : 0);

                Expense::create([
                    'user_id' => $expense->user_id,
                    'launch_id' => $monthlyLaunch->id,
                    'category_id' => $data['category_id'],
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
                    'value' => number_format($cents / 100, 2, '.', ''),
                    'installments' => $count,
                    'installment_number' => $i + 1,
                    'installment_group' => $newGroup,
                    'due_date' => $date->toDateString(),
                ]);
            }
        });
    }


    public function deleteGroup(Expense $expense): void
    {
        DB::transaction(function () use ($expense) {
            $group = $expense->installment_group;

            if ($group !== null) {
                Expense::where('installment_group', $group)->delete();
            } else {
                $expense->delete();
            }
        });
    }
}
