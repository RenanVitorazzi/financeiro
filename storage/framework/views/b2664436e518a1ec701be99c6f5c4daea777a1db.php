<?php $__env->startSection('title'); ?>
Fornecedores
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Fornecedores</li>
        
    </ol>
</nav>
<div class='mb-2 d-flex justify-content-between'>
    <h3> Fornecedores </h3>
    <div>
        <?php if (isset($component)) { $__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoImprimir::class, []); ?>
<?php $component->withName('botao-imprimir'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'mr-2','href' => ''.e(route('pdf_fornecedores')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5)): ?>
<?php $component = $__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5; ?>
<?php unset($__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoNovo::class, []); ?>
<?php $component->withName('botao-novo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['href' => ''.e(route('fornecedores.create')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd)): ?>
<?php $component = $__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd; ?>
<?php unset($__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd); ?>
<?php endif; ?>
    </div>
</div>
<div class='row'>
    <div class="col-12">
        <ul class="d-flex list-group list-group">
            <?php $__empty_1 = true; $__currentLoopData = $fornecedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fornecedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <li class='list-group-item d-flex justify-content-between'>
                    <div class='mt-2'>
                        <span><?php echo e($fornecedor->pessoa->nome); ?> </span>
                        <span>(<?php echo number_format($fornecedor->conta_corrente_sum_peso_agregado, 2, ',', '.'); ?>g)</span>
                        <?php if($fornecedor->conta_corrente_count > 0): ?>
                            <span class="font-weight-bold ml-2 badge badge-pill badge-danger">
                                Lançamento pendente
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class='d-flex'>
                        <a class="btn btn-dark mr-2" title="Conta corrente" href="<?php echo e(route('fornecedores.show', $fornecedor->id)); ?>">
                            <i class="fas fa-chart-area"></i>
                        </a>
                        <?php if (isset($component)) { $__componentOriginal13702a75d66702067dad623af293364e28e151a7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoEditar::class, []); ?>
<?php $component->withName('botao-editar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'mr-2','href' => ''.e(route('fornecedores.edit', $fornecedor->id)).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal13702a75d66702067dad623af293364e28e151a7)): ?>
<?php $component = $__componentOriginal13702a75d66702067dad623af293364e28e151a7; ?>
<?php unset($__componentOriginal13702a75d66702067dad623af293364e28e151a7); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoExcluir::class, []); ?>
<?php $component->withName('botao-excluir'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['action' => ''.e(route('fornecedores.destroy', $fornecedor->id)).'']); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247)): ?>
<?php $component = $__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247; ?>
<?php unset($__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247); ?>
<?php endif; ?>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class='list-group-item list-group-item-danger'>Nenhum registro criado!</li>
            <?php endif; ?>
        </ul>
    </div>
    

</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // const LABELS = <?php echo json_encode($labels, 15, 512) ?>;
    // const DATA_GRAFICO = <?php echo json_encode($data, 15, 512) ?>;

    <?php if(Session::has('message')): ?>
        toastr["success"]("<?php echo e(Session::get('message')); ?>")
    <?php endif; ?>

    // var poolColors = function (a) {
    //     var pool = [];
    //     for(i=0;i<a;i++){
    //         pool.push(dynamicColors());
    //     }
    //     return pool;
    // }

    // var dynamicColors = function() {
    //     var r = Math.floor(Math.random() * 255);
    //     var g = Math.floor(Math.random() * 255);
    //     var b = Math.floor(Math.random() * 255);
    //     return "rgb(" + r + "," + g + "," + b + ")";
    // }

    // const data = {
    //     labels: JSON.parse(LABELS),
    //     datasets: [{
    //         data: JSON.parse(DATA_GRAFICO),
    //         backgroundColor:
    //             poolColors(20)

    //         ,
    //     }]
    // };

    // const config = {
    //     type: 'pie',
    //     data: data
    // };

    // var myChart = new Chart(
    //     document.getElementById('myChart'),
    //     config
    // );
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/fornecedor/index.blade.php ENDPATH**/ ?>