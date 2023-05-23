<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estoque</title>
</head>
<style>
    * {
        margin: 10;
        padding:0;
    }
    body {
        margin-top: 1px;
    }
    table {
        margin: 0 4 0 4;
        width:100%;
        border-collapse: collapse;
        font-size: 12px;
        page-break-inside: avoid;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
    }
    th {
        background-color: #9fa0a1;
    }
    h3 {
        text-align: center;
    }
    .peso {
        background-color: #d6d8db;
    }

</style>
<body>
    <h3>Estoque</h3>
    <table>
        <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <tr>
                <th rowspan=2>Data</th>
                <th rowspan=2>Descrição</th>
                <th colspan=2>Peso</th>
                <th colspan=2>Fator</th>
                <th colspan=2>Saldo</th>
            </tr>
            <tr>
                <th>Crédito</th>
                <th>Débito</th>
                <th>Crédito</th>
                <th>Débito</th>
                <th>Peso</th>
                <th>Fator</th>
            </tr>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $lancamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lancamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($lancamento->balanco_estoque == 'Débito'): ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($lancamento->data)); ?></td>
                        <td>
                            <?php if($lancamento->representante_id): ?>
                                <?php echo e($lancamento->balanco_representante); ?>

                                <?php echo e($lancamento->nome_representante); ?>

                                <?php echo e($lancamento->observacao_representante); ?>

                            <?php elseif($lancamento->fornecedor_id): ?>
                                <?php echo e($lancamento->balanco_fornecedor); ?>

                                <?php echo e($lancamento->nome_fornecedor); ?>

                                <?php echo e($lancamento->observacao_fornecedor); ?>

                            <?php endif; ?>
                        </td>
                        <td class='peso'></td>
                        <td class='peso'><?php echo number_format($lancamento->peso, 2, ',', '.'); ?></td>
                        <td></td>
                        <td><?php echo number_format($lancamento->fator, 1, ',', '.'); ?></td>
                        <td class='peso'><?php echo number_format($lancamento->saldo_peso, 2, ',', '.'); ?></td>
                        <td><?php echo number_format($lancamento->saldo_fator, 1, ',', '.'); ?></td>
                    </tr>
                <?php elseif($lancamento->balanco_estoque == 'Crédito'): ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($lancamento->data)); ?></td>
                        <td>
                            <?php if($lancamento->representante_id): ?>
                                <?php echo e($lancamento->balanco_representante); ?>

                                <?php echo e($lancamento->nome_representante); ?>

                                <?php echo e($lancamento->observacao_representante); ?>

                            <?php elseif($lancamento->fornecedor_id): ?>
                                <?php echo e($lancamento->balanco_fornecedor == 'Débito' ? 'Compra' : 'Devolução'); ?>

                                <?php echo e($lancamento->nome_fornecedor); ?>

                                <?php echo e($lancamento->observacao_fornecedor); ?>

                            <?php else: ?>
                                Início registro
                            <?php endif; ?>
                        </td>
                        <td class='peso'><?php echo number_format($lancamento->peso, 2, ',', '.'); ?></td>
                        <td class='peso'></td>
                        <td><?php echo number_format($lancamento->fator, 1, ',', '.'); ?></td>
                        <td></td>
                        <td class='peso'><?php echo number_format($lancamento->saldo_peso, 2, ',', '.'); ?></td>
                        <td><?php echo number_format($lancamento->saldo_fator, 1, ',', '.'); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan=8>Nenhum registro</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/estoque/pdf/pdf_estoque.blade.php ENDPATH**/ ?>