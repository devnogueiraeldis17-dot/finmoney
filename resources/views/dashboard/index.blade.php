@extends('layouts.app')
@section('title', 'Dashboard — FinMoney')
@section('content')
<div class="page-head"><div><p class="eyebrow">VISÃO GERAL</p><h1>Dashboard</h1><p>Resumo financeiro de {{ sprintf('%02d', $month) }}/{{ $year }}</p></div></div>
<form class="filters" method="GET" action="{{ route('dashboard') }}">
    <label>Mês <select name="month">@foreach(range(1,12) as $m)<option value="{{ $m }}" @selected($m === $month)>{{ sprintf('%02d', $m) }}</option>@endforeach</select></label>
    <label>Ano <input type="number" name="year" value="{{ $year }}" min="2000" max="2200"></label>
    <button class="btn btn-primary">Filtrar</button>
</form>
<div class="stats">
    <section class="stat"><span>Total no período</span><strong>R$ {{ number_format((float)$total, 2, ',', '.') }}</strong></section>
    <section class="stat"><span>Parcelas/despesas</span><strong>{{ $count }}</strong></section>
    @if(!is_null($userCount))<section class="stat"><span>Usuários</span><strong>{{ $userCount }}</strong></section>@endif
</div>
<div class="grid-two">
    <section class="panel"><h2>Gastos por categoria</h2>
        @forelse($byCategory as $cat)
            <div class="bar-row"><div><span>{{ $cat->name }}</span><strong>R$ {{ number_format((float)$cat->total,2,',','.') }}</strong></div>
            <div class="bar"><span style="width: {{ $total > 0 ? min(100, ((float)$cat->total / (float)$total) * 100) : 0 }}%"></span></div></div>
        @empty <p class="muted">Sem despesas neste período.</p> @endforelse
    </section>
    <section class="panel"><h2>Resumo mensal — {{ $year }}</h2>
        @foreach($monthly as $item)
            <div class="monthly-row"><span>{{ $item['label'] }}</span><div class="bar"><span style="width: {{ max(array_column($monthly, 'total')) > 0 ? min(100, $item['total'] / max(array_column($monthly, 'total')) * 100) : 0 }}%"></span></div><strong>R$ {{ number_format($item['total'],2,',','.') }}</strong></div>
        @endforeach
    </section>
</div>
<section class="panel"><h2>Despesas recentes</h2>
<div class="table-wrap"><table><thead><tr><th>Despesa</th><th>Categoria</th><th>Vencimento</th><th>Parcela</th><th>Valor</th>@if(auth()->user()->isAdmin())<th>Usuário</th>@endif</tr></thead><tbody>
@forelse($recent as $expense)<tr><td>{{ $expense->name }}</td><td>{{ $expense->category->name }}</td><td>{{ $expense->due_date->format('d/m/Y') }}</td><td>{{ $expense->installment_number }}/{{ $expense->installments }}</td><td>R$ {{ number_format((float)$expense->value,2,',','.') }}</td>@if(auth()->user()->isAdmin())<td>{{ $expense->user->name }}</td>@endif</tr>
@empty<tr><td colspan="6">Nenhuma despesa encontrada.</td></tr>@endforelse
</tbody></table></div></section>
@endsection
