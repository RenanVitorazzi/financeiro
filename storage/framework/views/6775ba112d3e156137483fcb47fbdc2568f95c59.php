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
        background-color:black;
        color:white;
    }
    .saldo {
        background-color:#d1d1d3;
    }
    h1 {
        text-align: center;
    }
</style>
<body>
    <h1>Conta Corrente - <?php echo e($representante->pessoa->nome); ?></h1>
    <table>
        <thead>
            <tr>
                <th rowspan=2>Data</th>
                <th rowspan=2>Observação</th>
                <th colspan=3>Peso</th>
                <th colspan=3>Fator</th>
            </tr>
            <tr>
                <th>Crédito</th>
                <th>Débito</th>
                <th>Saldo</th>
                <th>Crédito</th>
                <th>Débito</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $contaCorrente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <?php if($registro->balanco == 'Venda'): ?>
                        <td><?php echo date('d/m/Y', strtotime($registro->data)); ?></td>
                        <td><?php echo e($registro->balanco); ?><?php echo e($registro->observacao); ?> </td>
                        <td></td>
                        <td><?php echo number_format($registro->peso, 2, ',', '.'); ?> </td>
                        <td class="saldo"><?php echo number_format($registro->saldo_peso, 2, ',', '.'); ?></td>
                        <td></td>
                        <td><?php echo number_format($registro->fator, 1, ',', '.'); ?> </td>
                        <td class="saldo"><?php echo number_format($registro->saldo_fator, 1, ',', '.'); ?></td>
                    <?php else: ?>
                        <td><?php echo date('d/m/Y', strtotime($registro->data)); ?></td>
                        <td>
                            <?php echo e($registro->balanco); ?>

                            <?php echo e($registro->observacao ? '('.$registro->observacao.')' : ''); ?> 
                        </td>
                        <td><?php echo number_format($registro->peso, 2, ',', '.'); ?></td>
                        <td></td>
                        <td class="saldo"><?php echo number_format($registro->saldo_peso, 2, ',', '.'); ?></td>
                        <td><?php echo number_format($registro->fator, 1, ',', '.'); ?></td>
                        <td></td>
                        <td class="saldo"><?php echo number_format($registro->saldo_fator, 1, ',', '.'); ?></td>
                    <?php endif; ?>
                    
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8">Nenhum registro criado</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="saldo" colspan=2>Total</td>
                <td class="saldo" colspan=3 class="peso"><?php echo number_format($contaCorrente[count($contaCorrente) - 1]->saldo_peso, 2, ',', '.'); ?></td>
                <td class="saldo" colspan=3><?php echo number_format($contaCorrente[count($contaCorrente) - 1]->saldo_fator, 1, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/conta_corrente_representante/pdf/impresso.blade.php ENDPATH**/ ?>