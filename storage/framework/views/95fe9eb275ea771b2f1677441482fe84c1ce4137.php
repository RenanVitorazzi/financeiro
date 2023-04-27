<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relação de consignados por representante</title>
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
    .nomeRepresentante {
        background-color:#a9acb0;
    }
    /* tr:nth-child(even) {
        background-color: #a9acb0;
    } */
    h3 {
        text-align: center;
        margin-bottom: 6px;
        margin-top: 0px;
    }
</style>
<body>
    <h3>Relação de consignados</h3>
    <table>
        <thead>
            <tr>
                <th>Representante</th>
                <th>Peso</th>
                <th>Fator</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $representantesEmpresa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $representante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($representante->pessoa->nome); ?></td>
                    <td><?php echo number_format($consignados->where('representante_id', $representante->id)->sum('peso'), 2, ',', '.'); ?></td>
                    <td><?php echo number_format($consignados->where('representante_id', $representante->id)->sum('fator'), 1, ',', '.'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr>
                <th>TOTAL</th>
                <th><?php echo number_format($consignados->sum('peso'), 2, ',', '.'); ?></th>
                <th><?php echo number_format($consignados->sum('fator'), 1, ',', '.'); ?></th>
            </tr>
        </tfoot>       
    </table>
</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/consignado/pdf/pdf_consignados_geral.blade.php ENDPATH**/ ?>