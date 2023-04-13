
<?php $__env->startSection('title'); ?>
Conta Corrente <?php echo e($representante->pessoa->nome); ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <?php if(!auth()->user()->is_representante): ?>
        <li class="breadcrumb-item"><a href="<?php echo e(route('representantes.index')); ?>">Representantes</a></li>
        <?php endif; ?>
        <li class="breadcrumb-item active">Conta Corrente <?php echo e($representante->pessoa->nome); ?> </li>
    </ol>
</nav>

<div class='mb-2 d-flex justify-content-between'>
    <h3>Conta Corrente - <?php echo e($representante->pessoa->nome); ?></h3>
    <div>
        <?php if(count($contaCorrente) > 0): ?> 
            <?php if (isset($component)) { $__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoImprimir::class, []); ?>
<?php $component->withName('botao-imprimir'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'mr-2','href' => ''.e(route($impresso, ['id' => $representante->id])).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5)): ?>
<?php $component = $__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5; ?>
<?php unset($__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5); ?>
<?php endif; ?>
        <?php endif; ?>
        <?php if (isset($component)) { $__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoNovo::class, []); ?>
<?php $component->withName('botao-novo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['href' => ''.e(route('conta_corrente_representante.create', ['representante_id' => $representante->id])).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd)): ?>
<?php $component = $__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd; ?>
<?php unset($__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd); ?>
<?php endif; ?>
    </div>
</div>
<div>
    <?php if(count($contaCorrente) > 0): ?>
        <h3 class="<?php echo e($contaCorrente[count($contaCorrente) - 1]->saldo_peso > 0 ? 'text-success' : 'text-danger'); ?> font-weight-bold d-inline">
            Peso: <?php echo number_format($contaCorrente[count($contaCorrente) - 1]->saldo_peso, 2, ',', '.'); ?>g
        </h3> 
        <h3 class="<?php echo e($contaCorrente[count($contaCorrente) - 1]->saldo_fator > 0 ? 'text-success' : 'text-danger'); ?> font-weight-bold float-right">
            Fator: <?php echo number_format($contaCorrente[count($contaCorrente) - 1]->saldo_fator, 1, ',', '.'); ?>
        </h3> 
    <?php endif; ?>
</div>

<?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <th>Data</th>
        <th>Relação</th>
        <th>Balanço</th>
        <th>Observação</th>
        <th>Saldo</th>
        <th>Ações</th>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $contaCorrente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo date('d/m/Y', strtotime($registro->data)); ?></td>
                <td>
                    <div>Peso: <?php echo number_format($registro->peso, 2, ',', '.'); ?></div>
                    <div>Fator: <?php echo number_format($registro->fator, 1, ',', '.'); ?></div>
                </td>
                <td class="<?php echo e($registro->balanco == 'Reposição' ? 'text-danger' : 'text-success'); ?>">
                    <b><?php echo e($registro->balanco); ?></b>
                    <i class="fas <?php echo e($registro->balanco == 'Reposição' ? 'fa-angle-down' : 'fa-angle-up'); ?>"></i>
                </td>
                <td><?php echo e($registro->observacao); ?></td>
                <td>
                    <div>Peso: <?php echo number_format($registro->saldo_peso, 2, ',', '.'); ?></div>
                    <div>Fator: <?php echo number_format($registro->saldo_fator, 1, ',', '.'); ?></div>
                </td>
                <td>
                    <a class="btn btn-dark" href="<?php echo e(route('ccr_anexo.index', ['id' => $registro->id])); ?>" title="Anexos">
                        <i class="fas fa-file-image"></i>
                    </a>
                    <?php if (isset($component)) { $__componentOriginal13702a75d66702067dad623af293364e28e151a7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoEditar::class, []); ?>
<?php $component->withName('botao-editar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['href' => ''.e(route("conta_corrente_representante.edit", $registro->id)).'']); ?> <?php echo $__env->renderComponent(); ?>
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
<?php $component->withAttributes(['action' => ''.e(route("conta_corrente_representante.destroy", $registro->id)).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247)): ?>
<?php $component = $__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247; ?>
<?php unset($__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247); ?>
<?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="table-danger">Nenhum registro criado</td>
            </tr>
        <?php endif; ?>
    </tbody>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
<?php if(Session::has('message')): ?>
    toastr["success"]("<?php echo e(Session::get('message')); ?>")
<?php endif; ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/conta_corrente_representante/show.blade.php ENDPATH**/ ?>