@extends('layouts.app')
@section('title', 'Nova despesa — FinMoney')
@section('content')
<div class="page-head"><div><h1>Nova despesa</h1><p>O valor informado é o total da compra. O sistema divide automaticamente.</p></div></div>
<form class="panel form-card" method="POST" action="{{ route('expenses.store') }}">@csrf
<label>Nome da despesa<input name="name" value="{{ old('name') }}" required maxlength="180" placeholder="Ex.: Compra de mercado"></label>
<label>Descrição<textarea name="description" rows="3">{{ old('description') }}</textarea></label>
<div class="form-grid"><label>Valor total (R$)<input type="number" name="value" value="{{ old('value') }}" min="0.01" step="0.01" required></label>
<label>Quantidade de parcelas<input type="number" name="installments" value="{{ old('installments', 1) }}" min="1" max="120" required></label></div>
<div class="form-grid"><label>Categoria<select name="category_id" required><option value="">Selecione</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>{{ $category->name }}</option>@endforeach</select></label>
<label>Lançamento inicial<select name="launch_id" required><option value="">Selecione</option>@foreach($launches as $launch)<option value="{{ $launch->id }}" @selected(old('launch_id')==$launch->id)>{{ $launch->name }} — {{ sprintf('%02d', $launch->month) }}/{{ $launch->year }}</option>@endforeach</select><small>Crie um lançamento antes, se ainda não houver.</small></label></div>
<label>Data da primeira parcela<input type="date" name="due_date" value="{{ old('due_date', now()->toDateString()) }}" required></label>
<button class="btn btn-primary">Cadastrar despesa</button> <a class="btn btn-outline" href="{{ route('expenses.index') }}">Cancelar</a>
</form>
@endsection
