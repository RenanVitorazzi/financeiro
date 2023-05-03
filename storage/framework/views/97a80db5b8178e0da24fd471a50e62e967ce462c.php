<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conta Corrente Representantes</title>
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
    <h1>
        Conta Corrente Representantes
    </h1>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Saldo Peso</th>
                <th>Saldo Fator</th>
                <th>Total Devolvidos</th>
                <th>Saldo Geral</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $representantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $representante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($representante->conta_corrente->sum('peso_agregado') != 0 || $representante->conta_corrente->sum('fator_agregado') != 0): ?>
                    <tr>
                        <td><?php echo e($representante->pessoa->nome); ?></td>
                        <td><?php echo number_format($representante->conta_corrente->sum('peso_agregado'), 2, ',', '.'); ?> </td>
                        <td><?php echo number_format($representante->conta_corrente->sum('fator_agregado'), 1, ',', '.'); ?> </td>
                        <td><?php echo 'R$ ' . number_format($devolvidos->where('representante_id', $representante->id)->sum('valor_parcela'), 2, ',', '.'); ?></td>
                        <td><?php echo number_format(($representante->conta_corrente->sum('fator_agregado') / 32)  + $representante->conta_corrente->sum('peso_agregado'), 2, ',', '.'); ?> </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4">Nenhum registro criado</td>
                </tr>
            <?php endif; ?>
                <tr>
                    <td><b>Total</b></td>
                    <td><b><?php echo number_format($contaCorrenteGeral->sum('peso_agregado'), 2, ',', '.'); ?> </b></td>
                    <td><b><?php echo number_format($contaCorrenteGeral->sum('fator_agregado'), 1, ',', '.'); ?> </b></td>
                    <td><b><?php echo 'R$ ' . number_format($devolvidos->sum('valor_parcela'), 2, ',', '.'); ?> </b></td>
                    <td><b><?php echo number_format(($contaCorrenteGeral->sum('fator_agregado') / 32) + $contaCorrenteGeral->sum('peso_agregado'), 2, ',', '.'); ?> </b></td>
                </tr>
        </tbody>
    </table>
</body>
</html><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/representante/pdf/impresso.blade.php ENDPATH**/ ?>