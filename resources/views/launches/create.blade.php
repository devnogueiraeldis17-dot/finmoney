@extends('layouts.app')
@section('title', 'Novo lançamento — FinMoney')
@section('content')
<div class="page-head"><div><h1>Novo lançamento</h1><p>Defina o nome e o mês de referência.</p></div></div>
<form class="panel form-card" method="POST" action="{{ route('launches.store') }}">@csrf
<label>Nome do lançamento<input name="name" value="{{ old('name', 'Despesas') }}" required maxlength="120"></label>
<div class="form-grid"><label>Mês<select name="month" required>@foreach(range(1,12) as $m)<option value="{{ $m }}" @selected(old('month', now()->month)==$m)>{{ sprintf('%02d', $m) }}</option>@endforeach</select></label>
<label>Ano<input type="number" name="year" value="{{ old('year', now()->year) }}" min="2000" max="2200" required></label></div>
<button class="btn btn-primary">Salvar lançamento</button> <a class="btn btn-outline" href="{{ route('launches.index') }}">Cancelar</a>
</form>
@endsection
