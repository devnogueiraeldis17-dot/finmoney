<?php $__env->startSection('title', $launch->name.' — FinMoney'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-head"><div><p class="eyebrow"><?php echo e(sprintf('%02d', $launch->month)); ?>/<?php echo e($launch->year); ?></p><h1><?php echo e($launch->name); ?></h1><p>Despesas deste lançamento.</p></div><a class="btn btn-primary" href="<?php echo e(route('expenses.create')); ?>">Nova despesa</a></div>
<section class="panel table-wrap"><table><thead><tr><th>Despesa</th><th>Categoria</th><th>Vencimento</th><th>Parcela</th><th>Valor</th></tr></thead><tbody>
<?php $__empty_1 = true; $__currentLoopData = $launch->expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><?php echo e($expense->name); ?></td><td><?php echo e($expense->category->name); ?></td><td><?php echo e($expense->due_date->format('d/m/Y')); ?></td><td><?php echo e($expense->installment_number); ?>/<?php echo e($expense->installments); ?></td><td>R$ <?php echo e(number_format((float)$expense->value,2,',','.')); ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="5">Este lançamento não possui despesas.</td></tr><?php endif; ?>
</tbody></table></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\finmoney\resources\views/launches/show.blade.php ENDPATH**/ ?>