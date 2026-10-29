<?php $__env->startSection('title', 'Novo lançamento — FinMoney'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-head"><div><h1>Novo lançamento</h1><p>Defina o nome e o mês de referência.</p></div></div>
<form class="panel form-card" method="POST" action="<?php echo e(route('launches.store')); ?>"><?php echo csrf_field(); ?>
<label>Nome do lançamento<input name="name" value="<?php echo e(old('name', 'Despesas')); ?>" required maxlength="120"></label>
<div class="form-grid"><label>Mês<select name="month" required><?php $__currentLoopData = range(1,12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($m); ?>" <?php if(old('month', now()->month)==$m): echo 'selected'; endif; ?>><?php echo e(sprintf('%02d', $m)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
<label>Ano<input type="number" name="year" value="<?php echo e(old('year', now()->year)); ?>" min="2000" max="2200" required></label></div>
<button class="btn btn-primary">Salvar lançamento</button> <a class="btn btn-outline" href="<?php echo e(route('launches.index')); ?>">Cancelar</a>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\finmoney\resources\views/launches/create.blade.php ENDPATH**/ ?>