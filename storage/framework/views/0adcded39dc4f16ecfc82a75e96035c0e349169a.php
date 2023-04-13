<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acerto de documentos - <?php echo e($representante->pessoa->nome); ?></title>
</head>
<style>
    * {
        margin: 10;
        padding:0;
    }
    body {
        margin-top: 1px;
    }
    table {
        margin: 0 4 0 4;
        width:100%;
        border-collapse: collapse;
        font-size: 12px;
        page-break-inside: avoid;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
    }
    th {
        background-color: #d6d8db;
    }
    h3 {
        text-align: center;
    }
    .pagamentos, .titular {
        font-size:10px;
        width:30%;
    }

    .tabelaloca {
        font-size: 14px;
    } 

    .assinatura {
        float:right;
        width:40%;
        border-top: 1px solid black;
        text-align: center;
    }
    .local {
        width:50%;
        border-top: 1px solid black;
        text-align: center;
    }
</style>
<body>
    <h3>Cheques entregues  - <?php echo e($representante->pessoa->nome); ?> </h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Titular</th>
                <th>Número</th>
                <th>Valor</th>
                
                <th>Pagamento</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $cheques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->index + 1); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($cheque->data_parcela)); ?></td>
                    <td class='titular'><?php echo e($cheque->nome_cheque); ?></td>
                    <td><?php echo e($cheque->numero_cheque); ?></td>
                    <td><?php echo 'R$ ' . number_format($cheque->valor_parcela, 2, ',', '.'); ?></td>
                    <td class='pagamentos'>
                        <?php $__currentLoopData = $pagamentos->where('parcela_id', $cheque->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pagamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <?php echo date('d/m/Y', strtotime($pagamento->data)); ?> - <?php echo e($pagamento->forma_pagamento); ?> <?php echo e($pagamento->conta->nome); ?> - <?php echo 'R$ ' . number_format($pagamento->valor, 2, ',', '.'); ?><?php echo e($pagamento->confirmado ? '' : ' - Não confirmado'); ?> <br>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td><?php echo e($cheque->status); ?></td>
                    
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan=4>Nenhum registro</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <p></p>
    <table class='tabelaloca'>
        <thead>
            <tr>
                <th>Total devolvido</th>
                <th>Total pago</th>
                <th>Total em aberto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo 'R$ ' . number_format($totalCheque, 2, ',', '.'); ?></td>
                <td><?php echo 'R$ ' . number_format($pagamentos->sum('valor'), 2, ',', '.'); ?></td>
                <td><?php echo 'R$ ' . number_format($totalCheque - $pagamentos->sum('valor'), 2, ',', '.'); ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <div>
        <p class='assinatura'>Visto do representante</p>
        <p class='local'>Data e Local</p>

        
    <div>
</body>
</html>

<?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/entrega_parcela/pdf/pdf_cheques_entregues.blade.php ENDPATH**/ ?>