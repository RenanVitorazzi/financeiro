<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CLIENTES <?php echo e($representante->pessoa->nome); ?></title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
        font-size:12px;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
    }
    tr:nth-child(even) {
        background-color: #d9dde2;
    }
    h1 {
        text-align: center;
    }
    .nome {
        font-size:10px;
    }
</style>
<body>
    <table>
        <thead>
            <tr>
                <th colspan = 7>Clientes - <?php echo e($representante->pessoa->nome); ?></th>
            </tr>
            <tr>
                <th></th>
                <th>Nome</th>
                <th>Estado</th>
                <th>Município</th>
                <th>CEP</th>
                <th>Endereço</th>
                <th>Telefones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->index+1); ?></td>
                    <td class='nome'><?php echo e($cliente->nome); ?></td>
                    <td><?php echo e($cliente->estado); ?></td>
                    <td><?php echo e(substr($cliente->municipio,0,15)); ?></td>
                    <td><?php echo e($cliente->cep); ?></td>

                    <?php if($cliente->cep): ?>
                        <td><?php echo e($cliente->bairro); ?>, <?php echo e($cliente->logradouro); ?>, <?php echo e($cliente->numero); ?></td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>

                    <td><?php echo e($cliente->celular); ?>

                        <?php if($cliente->telefone): ?>
                        <br>
                        <?php echo e($cliente->telefone); ?>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=7>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>


</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/cliente/pdf/pdf_cliente.blade.php ENDPATH**/ ?>