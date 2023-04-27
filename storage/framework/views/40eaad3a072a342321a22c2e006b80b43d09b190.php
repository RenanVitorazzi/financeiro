<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conta Corrente - <?php echo e($representante->pessoa->nome); ?></title>
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
        /* background-color:black; */
        /* color:white; */
    }
    tr:nth-child(even) {
        background-color: #ebedf0;
    }
    h1 {
        text-align: center;
    }
</style>
<body>
    <h1>
        Conta Corrente - <?php echo e($representante->pessoa->nome); ?> 
    </h1>

    <br>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Relação</th>
                <th>Balanço</th>
                <th>Observação</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $contaCorrente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($loop->last): ?>
                    <tr>
                        <td><b><?php echo date('d/m/Y', strtotime($registro->data)); ?></b></td>
                        <td><b>Peso: <?php echo number_format($registro->peso, 2, ',', '.'); ?></b></td>
                        <td><b><?php echo e($registro->balanco == 'Reposição' ? 'Compra' : 'Fechamento'); ?></b></td>
                        <td><b><?php echo e($registro->observacao); ?></b></td>
                        <td><b><?php echo number_format($registro->saldo_peso, 2, ',', '.'); ?></b></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($registro->data)); ?></td>
                        <td>
                            Peso: <?php echo number_format($registro->peso, 2, ',', '.'); ?>
                        </td>
                        <td>
                            <?php echo e($registro->balanco == 'Reposição' ? 'Compra' : 'Fechamento'); ?>

                        </td>
                        <td><?php echo e($registro->observacao); ?></td>
                        <td>
                            <?php echo number_format($registro->saldo_peso, 2, ',', '.'); ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5">Nenhum registro criado</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/conta_corrente_representante/pdf/impresso_terceiros.blade.php ENDPATH**/ ?>