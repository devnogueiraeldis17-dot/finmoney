@extends('layouts.app')
@section('title', 'Novo usuário — FinMoney')
@section('content')
<div class="page-head"><div><h1>Novo usuário</h1><p>Cadastre uma conta e escolha seu perfil.</p></div></div>
<form class="panel form-card" method="POST" action="{{ route('admin.usuarios.store') }}">@csrf
<label>Nome completo<input name="name" value="{{ old('name') }}" required></label>
<div class="form-grid"><label>Data de nascimento<input type="date" name="birth_date" value="{{ old('birth_date') }}" max="{{ now()->subDay()->toDateString() }}" required></label><label>E-mail<input type="email" name="email" value="{{ old('email') }}" required></label></div>
<div class="form-grid"><label>Senha (mínimo 10 caracteres)<input type="password" name="password" required minlength="10" autocomplete="new-password"></label><label>Confirmar senha<input type="password" name="password_confirmation" required minlength="10" autocomplete="new-password"></label></div>
<label>Perfil<select name="role" required><option value="comum">Usuário comum</option><option value="admin">Administrador</option></select></label>
<button class="btn btn-primary">Criar usuário</button> <a class="btn btn-outline" href="{{ route('admin.usuarios.index') }}">Cancelar</a>
</form>
@endsection
