<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Extrato <?php echo e($parceiro->pessoa->nome); ?></title>
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
    .nome {
        font-size: 10px;
        text-align: left;
    }
</style>
<body>
    <h3>Extrato <?php echo e($parceiro->pessoa->nome); ?> - <?php echo date('d/m/Y', strtotime($hoje)); ?></h3>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Titular</th>
                <th>Status</th>
                <th>Crédito</th>
                <th>Débito</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $saldos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saldo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    if($saldo->status == 'Crédito') {
                        $tr = 'credito';
                        $saldo_total = $saldo_total + $saldo->valor;
                    } else {
                        $tr = '';
                        $saldo_total -= $saldo->valor;
                    }
                    
                ?> 
                <?php if($saldo->status == 'Crédito'): ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($saldo->rank2)); ?></td>
                        <td class='nome'><?php echo e($saldo->nome_cheque); ?></td>
                        <td><?php echo e($saldo->status); ?></td>
                        <td><?php echo 'R$ ' . number_format($saldo->valor, 2, ',', '.'); ?></td>     
                        <td></td>      
                        <td><?php echo 'R$ ' . number_format($saldo_total, 2, ',', '.'); ?></td>
                    </tr>
                <?php else: ?> if
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($saldo->rank2)); ?></td>
                        <td class='nome'><?php echo e($saldo->nome_cheque); ?></td>
                        <td><?php echo e($saldo->status); ?></td>
                        <td></td>    
                        <td><?php echo 'R$ ' . number_format($saldo->valor, 2, ',', '.'); ?></td>       
                        <td><?php echo 'R$ ' . number_format($saldo_total, 2, ',', '.'); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=6>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <?php
            if ($saldo_total < 0) {
                $tfoot = 'debito';
            } else {
                $tfoot = 'credito';
            }
            ?>
            <tr>
                <td colspan=4><b>TOTAL</b></td>
                <td colspan=2 class=<?php echo e($tfoot); ?>><b><?php echo 'R$ ' . number_format($saldo_total, 2, ',', '.'); ?></b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

<?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/parceiro/pdf/pdf_cc_parceiro.blade.php ENDPATH**/ ?>