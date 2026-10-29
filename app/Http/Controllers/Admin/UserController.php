<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);
        return view('admin.users.index', ['users' => User::orderBy('name')->paginate(20)]);
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('admin.users.create');
    }

    public function store(UserStoreRequest $request)
    {
        $this->authorize('create', User::class);
        $data = $request->validated();
        $data['password'] = $data['password']; // cast hashed do Model aplica hash.

        User::create($data);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário criado.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validated();
        if (empty($data['password'] ?? null)) unset($data['password']);
        $user->update($data);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário atualizado.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->withErrors(['user' => 'Não é possível excluir o último administrador.']);
        }

        DB::transaction(fn () => $user->delete());

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário excluído.');
    }
}
