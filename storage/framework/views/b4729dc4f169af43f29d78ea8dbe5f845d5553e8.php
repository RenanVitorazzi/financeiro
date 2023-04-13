
<?php $__env->startSection('title'); ?>
Trocas de cheques
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<div class="mb-2 d-flex justify-content-between">
    <h3>Trocas de cheques</h3>
    <?php if (isset($component)) { $__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoNovo::class, []); ?>
<?php $component->withName('botao-novo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['href' => ''.e(route('troca_cheques.create')).'']); ?> <?php if (isset($__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd)): ?>
<?php $component = $__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd; ?>
<?php unset($__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
</div>
<?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'tabelaCheques']); ?>
    <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <tr>
            <th>Parceiro</th>
            <th>Data da troca</th>
            <th>Valor bruto</th>
            <th>Juros</th>
            <th>Taxa</th>
            <th>Valor líquido</th>
            <th>Ações</th>
        </tr>
     <?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $trocas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $troca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td> <?php echo e($troca->parceiro()->exists() ? $troca->parceiro->pessoa->nome : $troca->titulo); ?> </td>
            <td> <?php echo date('d/m/Y', strtotime($troca->data_troca)); ?> </td>
            <td> <?php echo 'R$ ' . number_format($troca->valor_bruto, 2, ',', '.'); ?> </td>
            <td> <?php echo 'R$ ' . number_format($troca->valor_juros, 2, ',', '.'); ?> </td>
            <td> <?php echo e(number_format($troca->taxa_juros,2)); ?>% </td>
            <td> <?php echo 'R$ ' . number_format($troca->valor_liquido, 2, ',', '.'); ?> </td>
            <td>
                <a class="btn btn-dark" href="<?php echo e(route('troca_cheques.show', $troca->id)); ?>">
                    <i class="fas fa-eye"></i>
                </a>
                <a class="btn btn-dark" target="_blank" href="<?php echo e(route('pdf_troca', $troca->id)); ?>">
                    <i class="fas fa-print"></i>
                </a>
                <a class="btn btn-dark" href="<?php echo e(route('troca_cheques.edit', $troca->id)); ?>">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan=6>Nenhum registro</td>
        </tr>
        <?php endif; ?>
    </tbody>
 <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php echo e($trocas->links()); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/troca_cheque/index.blade.php ENDPATH**/ ?>