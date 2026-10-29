<?php $__env->startSection('title', 'Usuários — FinMoney'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-head"><div><p class="eyebrow">ADMINISTRAÇÃO</p><h1>Usuários</h1><p>Somente administradores podem gerenciar contas.</p></div><a class="btn btn-primary" href="<?php echo e(route('admin.usuarios.create')); ?>">Novo usuário</a></div>
<section class="panel table-wrap"><table><thead><tr><th>Nome</th><th>E-mail</th><th>Nascimento</th><th>Perfil</th><th>Ações</th></tr></thead><tbody>
<?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><?php echo e($user->name); ?></td><td><?php echo e($user->email); ?></td><td><?php echo e($user->birth_date?->format('d/m/Y') ?? '—'); ?></td><td><span class="pill"><?php echo e($user->role); ?></span></td><td class="actions"><a href="<?php echo e(route('admin.usuarios.edit', $user)); ?>">Editar</a><?php if($user->id !== auth()->id()): ?><form method="POST" action="<?php echo e(route('admin.usuarios.destroy', $user)); ?>" onsubmit="return confirm('Excluir este usuário?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="link-danger">Excluir</button></form><?php endif; ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="5">Nenhum usuário encontrado.</td></tr><?php endif; ?>
</tbody></table></section><?php echo e($users->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\finmoney\resources\views/admin/users/index.blade.php ENDPATH**/ ?>