<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $month = (int) $request->query('month', now()->month);
        $year = (int) $request->query('year', now()->year);

        abort_unless($month >= 1 && $month <= 12 && $year >= 2000 && $year <= 2200, 422);

        $query = Expense::query()
            ->whereMonth('due_date', $month)
            ->whereYear('due_date', $year);

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $total = (clone $query)->sum('value');
        $count = (clone $query)->count();

        $byCategory = (clone $query)
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(expenses.value) as total'))
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->get();

        $monthly = [];
        for ($m = 1; $m <= 12; $m++) {
            $q = Expense::query()->whereMonth('due_date', $m)->whereYear('due_date', $year);
            if (!$user->isAdmin()) $q->where('user_id', $user->id);
            $monthly[] = ['label' => Carbon::create($year, $m, 1)->translatedFormat('M'), 'total' => (float) $q->sum('value')];
        }

        $recentQuery = Expense::with(['category', 'launch', 'user'])->latest('due_date');
        if (!$user->isAdmin()) $recentQuery->where('user_id', $user->id);
        $recent = $recentQuery->limit(10)->get();

        $userCount = $user->isAdmin() ? User::count() : null;

        return view('dashboard.index', compact(
            'month', 'year', 'total', 'count', 'byCategory', 'monthly', 'recent', 'userCount'
        ));
    }
}
