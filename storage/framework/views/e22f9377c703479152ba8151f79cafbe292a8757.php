<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Despesas <?php echo e($mes); ?></title>
</head>
<style>
    * {
        margin:5 10 10 5;
    }
    table {
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
        background-color:#d6dae0;
        /* color:white; */
    }

    h5, h3 {
        text-align: center;
    }
</style>
<body>
    <h5>Despesas - Mês <?php echo e($mes); ?></h5>

    <?php $__currentLoopData = $despesas->groupBy('local_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $despesa_local): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <table>
            <thead>
                <tr>
                    <th colspan=3>
                        <?php echo e($local->where('id', $key)->first()->nome); ?>

                        (<?php echo 'R$ ' . number_format($despesas->where('local_id', $key)->sum('valor'), 2, ',', '.'); ?>)
                    </th>
                </tr>
                
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $despesas->where('local_id', $key); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $despesa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($despesa->data_vencimento)); ?></td>
                        <td class='nome'><?php echo e($despesa->nome); ?></td>
                        <td><?php echo 'R$ ' . number_format($despesa->valor, 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan=3>Nenhuma despesa</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            
        </table>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <h3>Total Geral: <?php echo 'R$ ' . number_format($despesas->sum('valor'), 2, ',', '.'); ?></h3>
    
</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/despesa/pdf/pdf_despesa_mensal.blade.php ENDPATH**/ ?>