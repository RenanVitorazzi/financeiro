<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Devolvidos - <?php echo e($representante->pessoa->nome); ?></title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
        font-size: 11px;
    }
    tr:nth-child(even) {
        background-color: #e4e8ec;
    }
    h3 {
        text-align: center;
    }
</style>
<body>
    <h3>Devolvidos - <?php echo e($representante->pessoa->nome); ?> <?php echo date('d/m/Y', strtotime($hoje)); ?></h3>
    <table>
        <thead>
           
            <tr>
                <th>Cliente</th>
                <th>Data</th>
                <th>Dias</th>
                <th>Motivo</th>
                <th>Valor</th>
                <th>Juros totais</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $cheques_devolvidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque_devolvido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e(substr($cheque_devolvido->nome_cheque, 0, 50)); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($cheque_devolvido->data_parcela)); ?></td>
                    <td><?php echo e($cheque_devolvido->dias); ?></td>
                    <td><?php echo e($cheque_devolvido->motivo); ?></td>
                    <td><?php echo 'R$ ' . number_format($cheque_devolvido->valor_parcela, 2, ',', '.'); ?></td>
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
                <td colspan=4><b>Total</b></td>
                <td colspan=1><b><?php echo 'R$ ' . number_format($juros_totais[0]->total_cheque, 2, ',', '.'); ?></b></td>
                <td colspan=1><b><?php echo 'R$ ' . number_format($juros_totais[0]->juros_totais, 2, ',', '.'); ?></b></td>
            </tr>
            <tr>
                <td colspan=4><b>Total Geral</b></td>
                <td colspan=2><b><?php echo 'R$ ' . number_format($juros_totais[0]->total_cheque + $juros_totais[0]->juros_totais, 2, ',', '.'); ?></b></td>
            </tr>
        </tfoot>
    </table>
    <p></p>
</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/devolvidos/pdf/devolvidos_representante.blade.php ENDPATH**/ ?>