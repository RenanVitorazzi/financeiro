
<?php $__env->startSection('title'); ?>
Anexos
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('fornecedores.index')); ?>">Fornecedores</a></li>
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('fornecedores.show', $contaCorrente->fornecedor_id)); ?>">
                Conta Corrente <?php echo e($contaCorrente->fornecedor->pessoa->nome); ?> 
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Anexos</li>
    </ol>
</nav>

<div class="text-right">
    <a href="<?php echo e(route('conta_corrente.edit', $contaCorrente->id)); ?>" class="btn btn-dark">
        Editar <span class="fas fa-pencil-alt"></span>
    </a>
    <a href="<?php echo e(route('conta_corrente_anexo.create', ['id' => $contaCorrente->id])); ?>" class="btn btn-success">
        Adicionar Anexo <span class="fas fa-plus"></span>
    </a>
</div>

<div class="row mt-2">
    <div class="col-6">
        <p>Data: <?php echo e(date('d/m/Y', strtotime($contaCorrente->data))); ?><p>
        <p>Balanço: <?php echo e($contaCorrente->balanco); ?><p>
        
        <p>Observação: <?php echo e($contaCorrente->observacao); ?><p>
    </div>
    <div class="col-6">    
        <p>Peso: <?php echo e($contaCorrente->peso); ?><p>
        <p>Fornecedor: <?php echo e($contaCorrente->fornecedor->pessoa->nome); ?><p>
        <?php if($contaCorrente->balanco == 'Crédito'): ?>
            <p>Cotação: R$<?php echo e($contaCorrente->cotacao); ?><p>
            <p>Valor: R$<?php echo e($contaCorrente->valor); ?><p>
        <?php endif; ?>
    </div>
</div>
<?php if(!$files->isEmpty()): ?>
    <section>
        <div class="text-center">
            <h5>Anexos</h5>
        </div>
        <ul class="list-group">
            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item d-flex justify-content-between">
                    <div class="mt-2">
                        <?php echo e($file->nome); ?>

                    </div>
                    <div>
                        <a class="btn btn-dark mr-2" href="<?php echo e(asset('storage/' . $file->path)); ?>" target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>
                        <?php if (isset($component)) { $__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoExcluir::class, []); ?>
<?php $component->withName('botao-excluir'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['action' => ''.e(route('conta_corrente_anexo.destroy', $file->id)).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247)): ?>
<?php $component = $__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247; ?>
<?php unset($__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247); ?>
<?php endif; ?>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </section>
<?php endif; ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/conta_corrente_anexo/index.blade.php ENDPATH**/ ?>