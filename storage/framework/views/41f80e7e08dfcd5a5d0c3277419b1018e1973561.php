<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Despesas <?php echo e($mes); ?></title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
    }
    th {
        background-color:black;
        color:white;
    }
    tr:nth-child(even) {
        background-color: #a9acb0;
    }
    h3 {
        text-align: center;
    }
    .credito {
        background-color:palegreen;
        font-size: 20px;
    }
    .debito {
        background-color:crimson;
        font-size: 20px;
    }
</style>
<body>
    <h3>Despesas - Mês <?php echo e($mes); ?></h3>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Nome</th>
                <th>Local</th>
                <th>Valor</th>
                
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $despesas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $despesa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($despesa->data_vencimento)); ?></td>
                    <td class='nome'><?php echo e($despesa->nome); ?></td>
                    <td><?php echo e($despesa->local->nome); ?></td>
                    <td><?php echo 'R$ ' . number_format($despesa->valor, 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=4>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan=3><b>TOTAL</b></td>
                <td colspan=1><b><?php echo 'R$ ' . number_format($despesas->sum('valor'), 2, ',', '.'); ?></b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

<?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/despesa/pdf/pdf_despesa_mensal.blade.php ENDPATH**/ ?>