@extends('layouts.app')
@section('title', 'Despesas — FinMoney')
@section('content')
<div class="page-head"><div><p class="eyebrow">CONTROLE DE GASTOS</p><h1>Despesas</h1><p>Visualize as despesas e suas parcelas.</p></div><a class="btn btn-primary" href="{{ route('expenses.create') }}">Nova despesa</a></div>
<section class="panel table-wrap"><table><thead><tr><th>Despesa</th><th>Categoria</th><th>Lançamento</th><th>Vencimento</th><th>Parcela</th><th>Valor</th>@if(auth()->user()->isAdmin())<th>Ações</th>@endif</tr></thead><tbody>
@forelse($expenses as $expense)<tr><td>{{ $expense->name }}@if($expense->description)<small class="block muted">{{ $expense->description }}</small>@endif</td><td>{{ $expense->category->name }}</td><td>{{ $expense->launch->name }} ({{ sprintf('%02d', $expense->launch->month) }}/{{ $expense->launch->year }})</td><td>{{ $expense->due_date->format('d/m/Y') }}</td><td>{{ $expense->installment_number }}/{{ $expense->installments }}</td><td>R$ {{ number_format((float)$expense->value,2,',','.') }}</td>
@if(auth()->user()->isAdmin())<td class="actions"><a href="{{ route('admin.expenses.edit', $expense) }}">Editar grupo</a><form method="POST" action="{{ route('admin.expenses.destroy', $expense) }}" onsubmit="return confirm('Excluir esta despesa e todas as parcelas do grupo?')">@csrf @method('DELETE')<button class="link-danger">Excluir grupo</button></form></td>@endif
</tr>@empty<tr><td colspan="7">Nenhuma despesa cadastrada.</td></tr>@endforelse
</tbody></table></section>{{ $expenses->links() }}
@endsection
