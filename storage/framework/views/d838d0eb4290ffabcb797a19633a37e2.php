<?php $__env->startSection('title', 'Lançamentos — FinMoney'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-head"><div><p class="eyebrow">ORGANIZAÇÃO MENSAL</p><h1>Lançamentos</h1><p>Organize despesas por nome, mês e ano.</p></div><a class="btn btn-primary" href="<?php echo e(route('launches.create')); ?>">Novo lançamento</a></div>
<section class="panel table-wrap"><table><thead><tr><th>Nome</th><th>Período</th><th>Despesas</th><th></th></tr></thead><tbody>
<?php $__empty_1 = true; $__currentLoopData = $launches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $launch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><?php echo e($launch->name); ?></td><td><?php echo e(sprintf('%02d', $launch->month)); ?>/<?php echo e($launch->year); ?></td><td><?php echo e($launch->expenses_count); ?></td><td><a href="<?php echo e(route('launches.show', $launch)); ?>">Abrir</a></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="4">Nenhum lançamento cadastrado.</td></tr><?php endif; ?>
</tbody></table></section><?php echo e($launches->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\finmoney\resources\views/launches/index.blade.php ENDPATH**/ ?>