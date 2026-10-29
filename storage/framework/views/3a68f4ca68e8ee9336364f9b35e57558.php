<?php $__env->startSection('title', 'Novo usuário — FinMoney'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-head"><div><h1>Novo usuário</h1><p>Cadastre uma conta e escolha seu perfil.</p></div></div>
<form class="panel form-card" method="POST" action="<?php echo e(route('admin.usuarios.store')); ?>"><?php echo csrf_field(); ?>
<label>Nome completo<input name="name" value="<?php echo e(old('name')); ?>" required></label>
<div class="form-grid"><label>Data de nascimento<input type="date" name="birth_date" value="<?php echo e(old('birth_date')); ?>" max="<?php echo e(now()->subDay()->toDateString()); ?>" required></label><label>E-mail<input type="email" name="email" value="<?php echo e(old('email')); ?>" required></label></div>
<div class="form-grid"><label>Senha (mínimo 10 caracteres)<input type="password" name="password" required minlength="10" autocomplete="new-password"></label><label>Confirmar senha<input type="password" name="password_confirmation" required minlength="10" autocomplete="new-password"></label></div>
<label>Perfil<select name="role" required><option value="comum">Usuário comum</option><option value="admin">Administrador</option></select></label>
<button class="btn btn-primary">Criar usuário</button> <a class="btn btn-outline" href="<?php echo e(route('admin.usuarios.index')); ?>">Cancelar</a>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\finmoney\resources\views/admin/users/create.blade.php ENDPATH**/ ?>