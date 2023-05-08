<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Depósitos a confirmar</title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
        font-size: 14px;
        page-break-inside: avoid;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
    }
    th {
        background-color: #b0b8c2;
    }
    h3 {
        text-align: center;
    }

    tfoot {
        background-color: #d9dde2;
    }
</style>
<body>
    <h3>Confirmar depósitos</h3>
    <table>
        <thead>
            <tr>
                <th>Conta</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Forma Pagamento</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $depositos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposito): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($deposito->conta->nome); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($deposito->data)); ?></td>
                    <td><?php echo 'R$ ' . number_format($deposito->valor, 2, ',', '.'); ?></td>
                    <td><?php echo e($deposito->forma_pagamento); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan = 4>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/recebimento/pdf/pdf_confirmar_depositos.blade.php ENDPATH**/ ?>