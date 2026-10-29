<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'FinMoney'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/finmoney.css')); ?>">
</head>
<body>
<div class="shell">
    <?php if(auth()->guard()->check()): ?>
    <aside class="sidebar">
        <a class="brand" href="<?php echo e(route('dashboard')); ?>">Fin<span>Money</span></a>
        <nav>
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <a href="<?php echo e(route('launches.index')); ?>">Lançamentos</a>
            <a href="<?php echo e(route('expenses.index')); ?>">Despesas</a>
            <?php if(auth()->user()->isAdmin()): ?>
                <a href="<?php echo e(route('admin.usuarios.index')); ?>">Usuários</a>
            <?php endif; ?>
        </nav>
        <div class="account">
            <strong><?php echo e(auth()->user()->name); ?></strong>
            <small><?php echo e(auth()->user()->isAdmin() ? 'Administrador' : 'Usuário comum'); ?></small>
            <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?>
                <button class="btn btn-outline" type="submit">Sair</button>
            </form>
        </div>
    </aside>
    <?php endif; ?>
    <main class="main">
        <?php if(session('success')): ?> <div class="alert success"><?php echo e(session('success')); ?></div> <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert error"><strong>Confira os dados:</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>
</body>
</html>
<?php /**PATH C:\laragon\www\finmoney\resources\views/layouts/app.blade.php ENDPATH**/ ?>