<?php $__env->startSection('title'); ?>
Lançamentos não efetuados
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

<div class='mb-2 d-flex justify-content-between'>
    <h3> Lançamentos não efetuados </h3>
    <h5>Conta: <?php echo e($import->conta->nome); ?>  - <?php echo date('d/m/Y', strtotime($import->dataInicio)); ?> até <?php echo date('d/m/Y', strtotime($import->dataFim)); ?></h5>
    <div>
        
        
    </div>
</div>

<?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'table-light']); ?>
    <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

        <tr>
            <th>#</th>
            <th>Data</th>
            <th>Descrição</th>
            <th>Débito</th>
            <th>Crédito</th>
            <th></th>
        </tr>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $import->arrayDados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($item[0]); ?></td>
                <td><?php echo e($item[1]); ?></td>
                <?php if($item[3] > 0): ?>
                    <td class='text-danger'></td>
                    <td class='text-success'><?php echo 'R$ ' . number_format($item[3], 2, ',', '.'); ?></td>
                <?php else: ?>
                    <td class='text-danger'><?php echo 'R$ ' . number_format($item[3], 2, ',', '.'); ?></td>
                    <td class='text-success'></td>
                <?php endif; ?>

                <td>
                    <?php if($item[3] > 0): ?>
                        <a class="btn btn-dark mr-2" target="_blank"
                            href="<?php echo e(route('criarRecebimentoImportacao', [
                                'data' => DateTime::createFromFormat('d/m/Y', $item[0])->format('Y-m-d'),
                                'descricao' => str_replace('/', '-', $item[1]),
                                'valor' => $item[3],
                                'conta' => $import->conta->id
                            ])); ?>"
                        >
                            <i class="fas fa-check"></i>
                        </a>
                    <?php else: ?>
                        <a class="btn btn-dark mr-2" target="_blank"
                            href="<?php echo e(route('criarDespesaImportacao', [
                                'data' => DateTime::createFromFormat('d/m/Y', $item[0])->format('Y-m-d'),
                                'descricao' => str_replace('/', '-', $item[1]),
                                'valor' => $item[3],
                                'conta' => $import->conta->id
                            ])); ?>"
                        >
                            <i class="fas fa-check"></i>
                        </a>
                    <?php endif; ?>
                    <div class="btn btn-danger botaoIgnorar" data-index = <?php echo e($index); ?>>
                        <i class="fas fa-window-close"></i>
                    </div>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan=5>Nenhum registro</td>
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
    $(".botaoIgnorar").each( (index, element) => {
        $(element).click( (botao) => {
            $(botao.currentTarget).parent().parent().fadeOut( "slow" );
            console.log($(botao.currentTarget).parent().parent())
        })
    })

    $(".botaoCriarRegistro").each( (index, element) => {
        $(element).click( (elementoBotao) => {
            let botao = $(elementoBotao.currentTarget)

            console.log($(botao.currentTarget).parent().parent())
        })
    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/despesa/importacao.blade.php ENDPATH**/ ?>