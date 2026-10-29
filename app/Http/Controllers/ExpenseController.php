<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Launch;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['category', 'launch', 'user'])->latest('due_date');
        if (!$request->user()->isAdmin()) $query->where('user_id', $request->user()->id);

        return view('expenses.index', ['expenses' => $query->paginate(20)]);
    }

    public function create(Request $request)
    {
        $launches = Launch::where('user_id', $request->user()->id)
            ->orderByDesc('year')->orderByDesc('month')->get();
        $categories = Category::orderBy('name')->get();

        return view('expenses.create', compact('launches', 'categories'));
    }

    public function store(ExpenseRequest $request, ExpenseService $service)
    {
        $service->create($request->user(), $request->validated());

        return redirect()->route('expenses.index')->with('success', 'Despesa e parcelas cadastradas.');
    }

    public function edit(Expense $expense)
    {
        $this->authorize('update', $expense);
        $expense->load('launch');
        $launches = Launch::where('user_id', $expense->user_id)->orderByDesc('year')->orderByDesc('month')->get();
        $categories = Category::orderBy('name')->get();

        return view('expenses.edit', compact('expense', 'launches', 'categories'));
    }

    public function update(ExpenseRequest $request, Expense $expense, ExpenseService $service)
    {
        $this->authorize('update', $expense);
        $service->updateGroup($expense, $request->validated());

        return redirect()->route('expenses.index')->with('success', 'Despesa/parcelamento atualizado.');
    }

    public function destroy(Expense $expense, ExpenseService $service)
    {
        $this->authorize('delete', $expense);
        $service->deleteGroup($expense);

        return redirect()->route('expenses.index')->with('success', 'Despesa e parcelas excluídas.');
    }
}
