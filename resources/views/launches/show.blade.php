@extends('layouts.app')
@section('title', $launch->name.' — FinMoney')
@section('content')
<div class="page-head"><div><p class="eyebrow">{{ sprintf('%02d', $launch->month) }}/{{ $launch->year }}</p><h1>{{ $launch->name }}</h1><p>Despesas deste lançamento.</p></div><a class="btn btn-primary" href="{{ route('expenses.create') }}">Nova despesa</a></div>
<section class="panel table-wrap"><table><thead><tr><th>Despesa</th><th>Categoria</th><th>Vencimento</th><th>Parcela</th><th>Valor</th></tr></thead><tbody>
@forelse($launch->expenses as $expense)<tr><td>{{ $expense->name }}</td><td>{{ $expense->category->name }}</td><td>{{ $expense->due_date->format('d/m/Y') }}</td><td>{{ $expense->installment_number }}/{{ $expense->installments }}</td><td>R$ {{ number_format((float)$expense->value,2,',','.') }}</td></tr>
@empty<tr><td colspan="5">Este lançamento não possui despesas.</td></tr>@endforelse
</tbody></table></section>
@endsection
