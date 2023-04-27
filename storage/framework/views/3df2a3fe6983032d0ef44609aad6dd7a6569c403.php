<?php $__env->startSection('title'); ?>
Importação Despesas
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('despesas.index')); ?>">Despesas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Importação</li>
    </ol>
</nav>
<div class='mb-2 d-flex justify-content-between'>
    <h3> Despesas </h3>
</div>
<form action="<?php echo e(route('importDespesas')); ?>" method='POST' enctype="multipart/form-data">
    <?php echo method_field('POST'); ?>
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <input type="file" name="importacao" id="importacao" >
    </div>
    <button class='btn btn-success' type="submit">Enviar</button>
</form>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    <?php if(Session::has('message')): ?>
        toastr["success"]("<?php echo e(Session::get('message')); ?>")
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/despesa/import.blade.php ENDPATH**/ ?>