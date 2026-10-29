@extends('layouts.app')
@section('title', 'Editar parcelamento — FinMoney')
@section('content')
<div class="page-head"><div><h1>Editar parcelamento</h1><p>Esta alteração recria todas as parcelas deste grupo.</p></div></div>
<form class="panel form-card" method="POST" action="{{ route('admin.expenses.update', $expense) }}">@csrf @method('PUT')
<label>Nome<input name="name" value="{{ old('name', $expense->name) }}" required maxlength="180"></label>
<label>Descrição<textarea name="description" rows="3">{{ old('description', $expense->description) }}</textarea></label>
<div class="form-grid"><label>Valor total (R$)<input type="number" name="value" min="0.01" step="0.01" value="{{ old('value', number_format((float)$expense->value * $expense->installments, 2, '.', '')) }}" required></label>
<label>Parcelas<input type="number" name="installments" min="1" max="120" value="{{ old('installments', $expense->installments) }}" required></label></div>
<div class="form-grid"><label>Categoria<select name="category_id" required>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $expense->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select></label>
<label>Lançamento base<select name="launch_id" required>@foreach($launches as $launch)<option value="{{ $launch->id }}" @selected(old('launch_id', $expense->launch_id)==$launch->id)>{{ $launch->name }} — {{ sprintf('%02d', $launch->month) }}/{{ $launch->year }}</option>@endforeach</select></label></div>
<label>Data da primeira parcela<input type="date" name="due_date" value="{{ old('due_date', $expense->due_date->toDateString()) }}" required></label>
<button class="btn btn-primary">Salvar grupo de parcelas</button> <a class="btn btn-outline" href="{{ route('expenses.index') }}">Cancelar</a>
</form>
@endsection
