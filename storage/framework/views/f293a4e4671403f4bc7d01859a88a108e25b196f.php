<?php $__env->startSection('title'); ?>
Representantes
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
<div class='mb-2 d-flex justify-content-between'>
    <h3>Representantes</h3>
    <div class="d-flex">
        <?php if (isset($component)) { $__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoImprimir::class, []); ?>
<?php $component->withName('botao-imprimir'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'mr-2','href' => ''.e(route('relacao_ccr')).'']); ?> <?php echo $__env->renderComponent(); ?>
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
<?php $component->withAttributes(['href' => ''.e(route('representantes.create')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd)): ?>
<?php $component = $__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd; ?>
<?php unset($__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd); ?>
<?php endif; ?>
    </div>
</div>

<?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'table-striped']); ?>
    <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <tr>
            <th>Nome</th>
            <th>Peso</th>
            <th>Fator</th>
            <!-- <th>Devolvidos</th> -->
            <th></th>
        </tr>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $representantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $representante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php if($representante->conta_corrente_sum_peso_agregado < 0|| $representante->conta_corrente_sum_fator_agregado < 0): ?>
            <tr>
                <td><?php echo e($representante->pessoa->nome); ?></td>
                <td><?php echo number_format($representante->conta_corrente_sum_peso_agregado, 2, ',', '.'); ?></td>
                <td><?php echo number_format($representante->conta_corrente_sum_fator_agregado, 1, ',', '.'); ?></td>
                <td>
                    <a class="btn btn-dark"
                        title="Acerto de documentos"
                        target='_blank'
                        href="<?php echo e(route('pdf_acerto_documento', $representante->id)); ?>">
                        Acertos
                    </a>
                    <a class="btn btn-dark"
                        title="Cheques Devolvidos "
                        target='_blank'
                        href="<?php echo e(route('pdf_cc_representante', $representante->id)); ?>">
                        Chs Devolvidos
                    </a>
                    <a class="btn btn-dark"
                        title="Conta Corrente"
                        target='_blank'
                        href="<?php echo e(route('conta_corrente_representante.show', $representante->id)); ?>">
                        Conta Corrente
                    </a>

                    <a class="btn btn-dark"
                        title="Vendas"
                        target='_blank'
                        href="<?php echo e(route('venda.show', $representante->id)); ?>">
                        Vendas
                    </a>
                    
                </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan=4>Nenhum registro criado!</td>
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

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/representante/index.blade.php ENDPATH**/ ?>