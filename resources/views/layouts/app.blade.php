<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FinMoney')</title>
    <link rel="stylesheet" href="{{ asset('css/finmoney.css') }}">
</head>
<body>
<div class="shell">
    @auth
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}">Fin<span>Money</span></a>
        <nav>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('launches.index') }}">Lançamentos</a>
            <a href="{{ route('expenses.index') }}">Despesas</a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.usuarios.index') }}">Usuários</a>
            @endif
        </nav>
        <div class="account">
            <strong>{{ auth()->user()->name }}</strong>
            <small>{{ auth()->user()->isAdmin() ? 'Administrador' : 'Usuário comum' }}</small>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="btn btn-outline" type="submit">Sair</button>
            </form>
        </div>
    </aside>
    @endauth
    <main class="main">
        @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
        @if($errors->any())
            <div class="alert error"><strong>Confira os dados:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
