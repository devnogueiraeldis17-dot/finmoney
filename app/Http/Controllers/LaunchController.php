<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaunchRequest;
use App\Models\Launch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaunchController extends Controller
{
    public function index(Request $request)
    {
        $query = Launch::withCount('expenses')->orderByDesc('year')->orderByDesc('month');
        if (!$request->user()->isAdmin()) $query->where('user_id', $request->user()->id);

        return view('launches.index', ['launches' => $query->paginate(15)]);
    }

    public function create()
    {
        return view('launches.create');
    }

    public function store(LaunchRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $launch = Launch::firstOrCreate(
            ['user_id' => $data['user_id'], 'name' => $data['name'], 'month' => $data['month'], 'year' => $data['year']],
            $data
        );

        return redirect()->route('launches.show', $launch)->with('success', 'Lançamento criado ou localizado.');
    }

    public function show(Request $request, Launch $launch)
    {
        $this->authorize('view', $launch);
        $launch->load(['expenses.category', 'user']);

        return view('launches.show', compact('launch'));
    }

    public function edit(Launch $launch)
    {
        $this->authorize('update', $launch);
        return view('launches.edit', compact('launch'));
    }

    public function update(LaunchRequest $request, Launch $launch)
    {
        $this->authorize('update', $launch);
        $launch->update($request->validated());

        return redirect()->route('launches.show', $launch)->with('success', 'Lançamento atualizado.');
    }

    public function destroy(Launch $launch)
    {
        $this->authorize('delete', $launch);

        if ($launch->expenses()->exists()) {
            return back()->withErrors(['launch' => 'Não é possível excluir um lançamento que contém despesas. Exclua as despesas primeiro.']);
        }

        $launch->delete();
        return redirect()->route('launches.index')->with('success', 'Lançamento excluído.');
    }
}
