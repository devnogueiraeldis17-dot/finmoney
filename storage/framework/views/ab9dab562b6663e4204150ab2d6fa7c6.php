<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Entrar — FinMoney</title><link rel="stylesheet" href="<?php echo e(asset('css/finmoney.css')); ?>">
</head>
<body class="login-page">
<div class="login-card">
    <a class="brand" href="<?php echo e(route('login')); ?>">Fin<span>Money</span></a>
    <h1>Bem-vindo de volta</h1><p>Acesse sua organização financeira.</p>
    <?php if($errors->any()): ?> <div class="alert error"><?php echo e($errors->first()); ?></div> <?php endif; ?>
    <form method="POST" action="<?php echo e(route('login.store')); ?>">
        <?php echo csrf_field(); ?>
        <label>E-mail</label><input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username">
        <label>Senha</label><input type="password" name="password" required autocomplete="current-password">
        <label class="check"><input type="checkbox" name="remember" value="1"> Manter conectado</label>
        <button class="btn btn-primary full" type="submit">Entrar</button>
    </form>
    <small>O acesso é criado pelo administrador do sistema.</small>
</div>
</body>
</html>
<?php /**PATH C:\laragon\www\finmoney\resources\views/auth/login.blade.php ENDPATH**/ ?>