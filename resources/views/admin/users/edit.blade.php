@extends('layouts.app')
@section('title', 'Editar usuário — FinMoney')
@section('content')
<div class="page-head"><div><h1>Editar usuário</h1><p>Deixe a senha em branco para manter a atual.</p></div></div>
<form class="panel form-card" method="POST" action="{{ route('admin.usuarios.update', $user) }}">@csrf @method('PUT')
<label>Nome completo<input name="name" value="{{ old('name', $user->name) }}" required></label>
<div class="form-grid"><label>Data de nascimento<input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->toDateString()) }}" required></label><label>E-mail<input type="email" name="email" value="{{ old('email', $user->email) }}" required></label></div>
<div class="form-grid"><label>Nova senha<input type="password" name="password" minlength="10" autocomplete="new-password"></label><label>Confirmar nova senha<input type="password" name="password_confirmation" minlength="10" autocomplete="new-password"></label></div>
<label>Perfil<select name="role" required><option value="comum" @selected(old('role', $user->role)==='comum')>Usuário comum</option><option value="admin" @selected(old('role', $user->role)==='admin')>Administrador</option></select></label>
<button class="btn btn-primary">Salvar alterações</button> <a class="btn btn-outline" href="{{ route('admin.usuarios.index') }}">Cancelar</a>
</form>
@endsection
