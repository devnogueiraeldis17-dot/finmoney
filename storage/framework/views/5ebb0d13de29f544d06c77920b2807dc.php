<?php $__env->startSection('title', 'Nova despesa — FinMoney'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-head"><div><h1>Nova despesa</h1><p>O valor informado é o total da compra. O sistema divide automaticamente.</p></div></div>
<form class="panel form-card" method="POST" action="<?php echo e(route('expenses.store')); ?>"><?php echo csrf_field(); ?>
<label>Nome da despesa<input name="name" value="<?php echo e(old('name')); ?>" required maxlength="180" placeholder="Ex.: Compra de mercado"></label>
<label>Descrição<textarea name="description" rows="3"><?php echo e(old('description')); ?></textarea></label>
<div class="form-grid"><label>Valor total (R$)<input type="number" name="value" value="<?php echo e(old('value')); ?>" min="0.01" step="0.01" required></label>
<label>Quantidade de parcelas<input type="number" name="installments" value="<?php echo e(old('installments', 1)); ?>" min="1" max="120" required></label></div>
<div class="form-grid"><label>Categoria<select name="category_id" required><option value="">Selecione</option><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category->id); ?>" <?php if(old('category_id')==$category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
<label>Lançamento inicial<select name="launch_id" required><option value="">Selecione</option><?php $__currentLoopData = $launches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $launch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($launch->id); ?>" <?php if(old('launch_id')==$launch->id): echo 'selected'; endif; ?>><?php echo e($launch->name); ?> — <?php echo e(sprintf('%02d', $launch->month)); ?>/<?php echo e($launch->year); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><small>Crie um lançamento antes, se ainda não houver.</small></label></div>
<label>Data da primeira parcela<input type="date" name="due_date" value="<?php echo e(old('due_date', now()->toDateString())); ?>" required></label>
<button class="btn btn-primary">Cadastrar despesa</button> <a class="btn btn-outline" href="<?php echo e(route('expenses.index')); ?>">Cancelar</a>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\finmoney\resources\views/expenses/create.blade.php ENDPATH**/ ?>