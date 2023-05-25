<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fornecedores</title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
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
    h1 {
        text-align: center;
    }
</style>
<body>
    <h1>Fornecedores</h1>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Balanço</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $fornecedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fornecedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($fornecedor->conta_corrente_sum_peso_agregado != 0): ?>
                    <tr>
                        <td><?php echo e($fornecedor->pessoa->nome); ?></td>
                        <td><?php echo number_format($fornecedor->conta_corrente_sum_peso_agregado, 2, ',', '.'); ?></td>
                        <td> <?php echo e(number_format($fornecedor->conta_corrente_sum_peso_agregado / $fornecedores->sum('conta_corrente_sum_peso_agregado') * 100, 2)); ?> % </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=3>Nenhum registro</td>
                </tr>
            <?php endif; ?>
            <tfoot>
                <tr>
                    <td><b>Total</b></td>
                    <td><b><?php echo number_format($fornecedores->sum('conta_corrente_sum_peso_agregado'), 2, ',', '.'); ?></b></td>
                    <td></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
    
</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/fornecedor/pdf/fornecedores.blade.php ENDPATH**/ ?>