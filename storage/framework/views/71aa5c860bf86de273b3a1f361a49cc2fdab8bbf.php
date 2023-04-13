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
    .pagamentos {
        font-size:10px;
    }

    .tabelaloca {
        font-size: 14px;
    } 

    .assinatura {
        width:50%;
        border-top: 1px solid black;
        text-align: center;
    }
</style>
<body>
    <h3>Cheques entregues 
        <br> 
        <?php echo e($representante->pessoa->nome); ?> 
        <?php if($cheques): ?>
            <?php echo date('d/m/Y', strtotime($cheques[0]->entregue_representante)); ?>
        <?php endif; ?>
    </h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Titular</th>
                <th>Data</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $cheques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->index + 1); ?></td>
                    <td><?php echo e($cheque->nome_cheque); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($cheque->data_parcela)); ?></td>
                    <td><?php echo 'R$ ' . number_format($cheque->valor_parcela, 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan=4>Nenhum registro</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <div class='assinatura'>Visto do representante</div>
</body>
</html>

<?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/entrega_parcela/pdf/pdf_cheques_entregues.blade.php ENDPATH**/ ?>