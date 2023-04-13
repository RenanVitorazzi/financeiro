<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cheques à vencer - <?php echo e($representante->pessoa->nome); ?></title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
        font-size: 10px;
    }
    th {
        background-color:black;
        color:white;
    }
    tr:nth-child(even) {
        background-color: #a9acb0;
    }
    h1 {
        text-align: center;
    }
</style>
<body>
    <h1>Cheques à vencer - <?php echo e($representante->pessoa->nome); ?></h1>
    <table>
        <thead>
            <tr>
                <th>Titular</th>
                <th>Banco</th>
                <th>Número</th>
                <th>Vencimento</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $parcelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parcela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>
                    <td><?php echo e($parcela->nome_cheque); ?></td>
                    <td><?php echo e($parcela->numero_banco); ?></td>
                    <td><?php echo e($parcela->numero_cheque); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($parcela->data_parcela)); ?></td>
                    <td><?php echo 'R$ ' . number_format($parcela->valor_parcela, 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=3>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/cheque/pdf/pdf_cheques.blade.php ENDPATH**/ ?>