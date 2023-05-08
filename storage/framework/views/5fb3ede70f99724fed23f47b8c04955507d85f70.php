<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fechamento <?php echo e($representante->pessoa->nome); ?></title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
    }

    td, th {
        border: 1px solid black;
        text-align: center;
        font-size: 12px;
    }

    tr:nth-child(even) {
        background-color: #e4e8ec;
    }

    h3 {
        text-align: center;
    }

</style>
<body>
    <h3>Fechamento <?php echo e($representante->pessoa->nome); ?> (<?php echo date('d/m/Y', strtotime($hoje)); ?>)</h3>
    <table>
        <thead>
            <tr>
               <th colspan=6>Devolvidos</th>
            </tr>
            <tr>
                <th>Cliente</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Dias</th>
                <th>Motivo</th>
                <th>Juros totais</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $cheques_devolvidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque_devolvido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($cheque_devolvido->nome_cheque, 0, 35); ?></td>
                    <td><?php echo 'R$ ' . number_format($cheque_devolvido->valor_parcela, 2, ',', '.'); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($cheque_devolvido->data_parcela)); ?></td>
                    <td><?php echo e($cheque_devolvido->dias); ?></td>
                    <td><?php echo e($cheque_devolvido->motivo); ?></td>
                    <td><?php echo 'R$ ' . number_format($cheque_devolvido->juros, 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=6>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan=5><b>Total</b></td>
                <td colspan=1><b><?php echo 'R$ ' . number_format($juros_totais[0]->juros_totais, 2, ',', '.'); ?></b></td>
            </tr>
        </tfoot>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th colspan = 6>Prorrogações </th>
            </tr>
            <tr>
                <th>Cliente</th>
                
                <th>Valor</th>
                <th>De</th>
                <th>Para</th>
                <th>Dias</th>
                <th>Juros totais</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $adiamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adiamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($adiamento->nome_cheque); ?></td>
                    
                    <td><?php echo 'R$ ' . number_format($adiamento->valor_parcela, 2, ',', '.'); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($adiamento->data_parcela)); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($adiamento->nova_data)); ?></td>
                    <td><?php echo e($adiamento->dias_totais); ?></td>
                    
                    <td><?php echo 'R$ ' . number_format($adiamento->juros_totais, 2, ',', '.'); ?></td>
                    
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=6>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan=5><b>Total</b></td>
                <td colspan=1><b><?php echo 'R$ ' . number_format($adiamentos_total[0]->total_juros, 2, ',', '.'); ?></b></td>
            </tr>
        </tfoot>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <td>Valor cheques devolvidos</td>
                <td><?php echo 'R$ ' . number_format($totalValorCheques[0]->valor_total, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td>Juros devolvidos</td>
                <td><?php echo 'R$ ' . number_format($juros_totais[0]->juros_totais, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td>Juros das prorrogações</td>
                <td><?php echo 'R$ ' . number_format($adiamentos_total[0]->total_juros, 2, ',', '.'); ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Total</b></td>
                <td><b><?php echo 'R$ ' . number_format($adiamentos_total[0]->total_juros + $juros_totais[0]->juros_totais + $totalValorCheques[0]->valor_total, 2, ',', '.'); ?></b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/devolvidos/pdf/fechamento.blade.php ENDPATH**/ ?>