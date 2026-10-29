<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Entrar — FinMoney</title><link rel="stylesheet" href="{{ asset('css/finmoney.css') }}">
</head>
<body class="login-page">
<div class="login-card">
    <a class="brand" href="{{ route('login') }}">Fin<span>Money</span></a>
    <h1>Bem-vindo de volta</h1><p>Acesse sua organização financeira.</p>
    @if($errors->any()) <div class="alert error">{{ $errors->first() }}</div> @endif
    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <label>E-mail</label><input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        <label>Senha</label><input type="password" name="password" required autocomplete="current-password">
        <label class="check"><input type="checkbox" name="remember" value="1"> Manter conectado</label>
        <button class="btn btn-primary full" type="submit">Entrar</button>
    </form>
    <small>O acesso é criado pelo administrador do sistema.</small>
</div>
</body>
</html>
