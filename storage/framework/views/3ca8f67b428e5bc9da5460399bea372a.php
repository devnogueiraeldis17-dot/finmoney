<?php $__env->startSection('title', 'Editar usuário — FinMoney'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-head"><div><h1>Editar usuário</h1><p>Deixe a senha em branco para manter a atual.</p></div></div>
<form class="panel form-card" method="POST" action="<?php echo e(route('admin.usuarios.update', $user)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
<label>Nome completo<input name="name" value="<?php echo e(old('name', $user->name)); ?>" required></label>
<div class="form-grid"><label>Data de nascimento<input type="date" name="birth_date" value="<?php echo e(old('birth_date', $user->birth_date?->toDateString())); ?>" required></label><label>E-mail<input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required></label></div>
<div class="form-grid"><label>Nova senha<input type="password" name="password" minlength="10" autocomplete="new-password"></label><label>Confirmar nova senha<input type="password" name="password_confirmation" minlength="10" autocomplete="new-password"></label></div>
<label>Perfil<select name="role" required><option value="comum" <?php if(old('role', $user->role)==='comum'): echo 'selected'; endif; ?>>Usuário comum</option><option value="admin" <?php if(old('role', $user->role)==='admin'): echo 'selected'; endif; ?>>Administrador</option></select></label>
<button class="btn btn-primary">Salvar alterações</button> <a class="btn btn-outline" href="<?php echo e(route('admin.usuarios.index')); ?>">Cancelar</a>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\finmoney\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>