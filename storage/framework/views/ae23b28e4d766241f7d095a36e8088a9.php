<?php $__env->startSection('title', 'Dashboard — FinMoney'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-head"><div><p class="eyebrow">VISÃO GERAL</p><h1>Dashboard</h1><p>Resumo financeiro de <?php echo e(sprintf('%02d', $month)); ?>/<?php echo e($year); ?></p></div></div>
<form class="filters" method="GET" action="<?php echo e(route('dashboard')); ?>">
    <label>Mês <select name="month"><?php $__currentLoopData = range(1,12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($m); ?>" <?php if($m === $month): echo 'selected'; endif; ?>><?php echo e(sprintf('%02d', $m)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
    <label>Ano <input type="number" name="year" value="<?php echo e($year); ?>" min="2000" max="2200"></label>
    <button class="btn btn-primary">Filtrar</button>
</form>
<div class="stats">
    <section class="stat"><span>Total no período</span><strong>R$ <?php echo e(number_format((float)$total, 2, ',', '.')); ?></strong></section>
    <section class="stat"><span>Parcelas/despesas</span><strong><?php echo e($count); ?></strong></section>
    <?php if(!is_null($userCount)): ?><section class="stat"><span>Usuários</span><strong><?php echo e($userCount); ?></strong></section><?php endif; ?>
</div>
<div class="grid-two">
    <section class="panel"><h2>Gastos por categoria</h2>
        <?php $__empty_1 = true; $__currentLoopData = $byCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bar-row"><div><span><?php echo e($cat->name); ?></span><strong>R$ <?php echo e(number_format((float)$cat->total,2,',','.')); ?></strong></div>
            <div class="bar"><span style="width: <?php echo e($total > 0 ? min(100, ((float)$cat->total / (float)$total) * 100) : 0); ?>%"></span></div></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <p class="muted">Sem despesas neste período.</p> <?php endif; ?>
    </section>
    <section class="panel"><h2>Resumo mensal — <?php echo e($year); ?></h2>
        <?php $__currentLoopData = $monthly; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="monthly-row"><span><?php echo e($item['label']); ?></span><div class="bar"><span style="width: <?php echo e(max(array_column($monthly, 'total')) > 0 ? min(100, $item['total'] / max(array_column($monthly, 'total')) * 100) : 0); ?>%"></span></div><strong>R$ <?php echo e(number_format($item['total'],2,',','.')); ?></strong></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>
</div>
<section class="panel"><h2>Despesas recentes</h2>
<div class="table-wrap"><table><thead><tr><th>Despesa</th><th>Categoria</th><th>Vencimento</th><th>Parcela</th><th>Valor</th><?php if(auth()->user()->isAdmin()): ?><th>Usuário</th><?php endif; ?></tr></thead><tbody>
<?php $__empty_1 = true; $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><?php echo e($expense->name); ?></td><td><?php echo e($expense->category->name); ?></td><td><?php echo e($expense->due_date->format('d/m/Y')); ?></td><td><?php echo e($expense->installment_number); ?>/<?php echo e($expense->installments); ?></td><td>R$ <?php echo e(number_format((float)$expense->value,2,',','.')); ?></td><?php if(auth()->user()->isAdmin()): ?><td><?php echo e($expense->user->name); ?></td><?php endif; ?></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="6">Nenhuma despesa encontrada.</td></tr><?php endif; ?>
</tbody></table></div></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\finmoney\resources\views/dashboard/index.blade.php ENDPATH**/ ?>