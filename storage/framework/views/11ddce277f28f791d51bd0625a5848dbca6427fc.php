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

        <?php $__currentLoopData = $representantesEmpresa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $representante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <table>
                <thead>
                    <tr>
                        <th class="nomeRepresentante" colspan=4><?php echo e($representante->pessoa->nome); ?></th>
                    </tr>
                    <tr>
                        <th>Data</th>
                        <th>Nome do cliente</th>
                        <th>Peso</th>
                        <th>Fator</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $consignados->where('representante_id', $representante->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consignado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($consignado->data)); ?></td>
                            <td><?php echo e($consignado->cliente->pessoa->nome); ?></td>
                            <td><?php echo number_format($consignado->peso, 2, ',', '.'); ?></td>
                            <td><?php echo number_format($consignado->fator, 1, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan=4> Nenhum registro </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan=2><b>TOTAL</b></td>
                        <td><b><?php echo number_format($consignados->where('representante_id', $representante->id)->sum('peso'), 2, ',', '.'); ?></b></td>
                        <td><b><?php echo number_format($consignados->where('representante_id', $representante->id)->sum('fator'), 1, ',', '.'); ?></b></td>
                    </tr>
                </tfoot>       
            </table>
            <br>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/consignado/pdf/pdf_consignados.blade.php ENDPATH**/ ?>