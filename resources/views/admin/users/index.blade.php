@extends('layouts.app')
@section('title', 'Usuários — FinMoney')
@section('content')
<div class="page-head"><div><p class="eyebrow">ADMINISTRAÇÃO</p><h1>Usuários</h1><p>Somente administradores podem gerenciar contas.</p></div><a class="btn btn-primary" href="{{ route('admin.usuarios.create') }}">Novo usuário</a></div>
<section class="panel table-wrap"><table><thead><tr><th>Nome</th><th>E-mail</th><th>Nascimento</th><th>Perfil</th><th>Ações</th></tr></thead><tbody>
@forelse($users as $user)<tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->birth_date?->format('d/m/Y') ?? '—' }}</td><td><span class="pill">{{ $user->role }}</span></td><td class="actions"><a href="{{ route('admin.usuarios.edit', $user) }}">Editar</a>@if($user->id !== auth()->id())<form method="POST" action="{{ route('admin.usuarios.destroy', $user) }}" onsubmit="return confirm('Excluir este usuário?')">@csrf @method('DELETE')<button class="link-danger">Excluir</button></form>@endif</td></tr>
@empty<tr><td colspan="5">Nenhum usuário encontrado.</td></tr>@endforelse
</tbody></table></section>{{ $users->links() }}
@endsection
