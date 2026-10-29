@extends('layouts.app')
@section('title', 'Lançamentos — FinMoney')
@section('content')
<div class="page-head"><div><p class="eyebrow">ORGANIZAÇÃO MENSAL</p><h1>Lançamentos</h1><p>Organize despesas por nome, mês e ano.</p></div><a class="btn btn-primary" href="{{ route('launches.create') }}">Novo lançamento</a></div>
<section class="panel table-wrap"><table><thead><tr><th>Nome</th><th>Período</th><th>Despesas</th><th></th></tr></thead><tbody>
@forelse($launches as $launch)<tr><td>{{ $launch->name }}</td><td>{{ sprintf('%02d', $launch->month) }}/{{ $launch->year }}</td><td>{{ $launch->expenses_count }}</td><td><a href="{{ route('launches.show', $launch) }}">Abrir</a></td></tr>
@empty<tr><td colspan="4">Nenhum lançamento cadastrado.</td></tr>@endforelse
</tbody></table></section>{{ $launches->links() }}
@endsection
