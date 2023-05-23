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
    .debito {
        color: red;
        font-weight: 300;
    }
</style>
<body>
    <h1>
        <div>
            <?php echo e($fornecedor->pessoa->nome); ?>

            (<?php echo number_format($registrosContaCorrente[count($registrosContaCorrente)-1]->saldo, 2, ',', '.'); ?>)
        </div>
    </h1>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Débito</th>
                <th>Crédito</th>
                <th>Observação</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $registrosContaCorrente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($conta->data > $data_inicio): ?>


                    <?php if($conta->balanco == 'Débito'): ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($conta->data)); ?></td>
                            <td><?php echo number_format($conta->peso, 2, ',', '.'); ?></td>
                            <td></td>
                            <td><?php echo e($conta->observacao); ?></td>
                            <td><?php echo number_format($conta->saldo, 2, ',', '.'); ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($conta->data)); ?></td>
                            <td></td>
                            <td><?php echo number_format($conta->peso, 2, ',', '.'); ?></td>
                            <td><?php echo e($conta->observacao); ?></td>
                            <td><?php echo number_format($conta->saldo, 2, ',', '.'); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=5>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan=4>Saldo atual</td>
                <td class='debito'><?php echo number_format($registrosContaCorrente[count($registrosContaCorrente) - 1]->saldo, 2, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/fornecedor/pdf/relacao_fornecedor.blade.php ENDPATH**/ ?>