<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório Geral</title>
</head>
<style>
    .right {
        float: right;
        width: 49%;
    }
    .left {
        float:left;
        width: 49%;
    }
    table {
        border-collapse: collapse;
        font-size: 14px;
        page-break-inside: avoid;
    }
    .grande {
        width: 100%;
    }

    td, th {
        border: 1px solid black;
        text-align: center;
    }

    tr:nth-child(even) {
        background-color: #d9dde2;
    }

</style>
<body>

    <table class="grande">
        <thead>
            <tr>
                <th colspan = 2>Carteira <?php echo e($hoje); ?></th>
            </tr>
            <tr>
                <th>Mês</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $carteira; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carteira_mensal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($loop->iteration >= 7 && !$loop->last): ?>
                    <?php echo e($totalCarteiraMaisSeisMeses += $carteira_mensal->total_mes); ?>

                <?php endif; ?>
                <?php if($loop->last): ?>
                    <tr>
                        <td>Próximos meses</td>
                        <td><?php echo 'R$ ' . number_format($totalCarteiraMaisSeisMeses, 2, ',', '.'); ?></td>
                    </tr>
                <?php elseif($loop->iteration < 7): ?>
                    <tr>
                        <td><?php echo e($carteira_mensal->month); ?>/<?php echo e($carteira_mensal->year); ?></td>
                        <td><?php echo 'R$ ' . number_format($carteira_mensal->total_mes, 2, ',', '.'); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=2>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Total</b></td>
                <td><b><?php echo 'R$ ' . number_format($totalCarteira[0]->totalCarteira, 2, ',', '.'); ?></b></td>
            </tr>
        </tfoot>
    </table>

    <br>

    <table class="right">
        <thead>
            <tr>
                <th colspan=2>Fornecedores</th>
            </tr>
            <tr>
                <th>Nome</th>
                <th>Saldo</th>
                <!-- <th>%</th> -->
                
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $fornecedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fornecedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($fornecedor->conta_corrente_sum_peso_agregado != 0): ?>
                    <tr>
                        <td><?php echo e($fornecedor->pessoa->nome); ?></td>
                        <td><?php echo number_format($fornecedor->conta_corrente_sum_peso_agregado, 2, ',', '.'); ?></td>
                        <!-- <td> <?php echo e(number_format($fornecedor->conta_corrente_sum_peso_agregado / $fornecedores->sum('conta_corrente_sum_peso_agregado') * 100, 2)); ?> % </td> -->
                        
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=2>Nenhum registro</td>
                </tr>
            <?php endif; ?>
            <tfoot>
                <tr>
                    <td><b>Total</b></td>
                    <td><b><?php echo number_format($fornecedores->sum('conta_corrente_sum_peso_agregado'), 2, ',', '.'); ?></b></td>
                    
                    <!-- <td></td> -->
                </tr>
            </tfoot>
        </tbody>
    </table>

    <table class="left">
        <thead>
            <tr>
                <th colspan=4>Representantes</th>
            </tr>
            <tr>
                <th>Nome</th>
                <th>Peso</th>
                <th>Fator</th>
                <th>Total</th>
                <!-- <th>Devolvidos</th>
                <th>Prorrogações</th> -->
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $representantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $representante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($representante->conta_corrente_sum_peso_agregado != 0 || $representante->conta_corrente_sum_fator_agregado != 0): ?>
                    <tr>
                        <td><?php echo e($representante->pessoa->nome); ?></td>
                        <td><?php echo number_format(abs($representante->conta_corrente_sum_peso_agregado), 2, ',', '.'); ?></td>
                        <td><?php echo number_format(abs($representante->conta_corrente_sum_fator_agregado), 1, ',', '.'); ?></td>
                        <td><?php echo number_format(abs($representante->conta_corrente_sum_peso_agregado + ($representante->conta_corrente_sum_fator_agregado / 32)), 2, ',', '.'); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=4>Nenhum registro</td>
                </tr>
            <?php endif; ?>
            <tfoot>
                <tr>
                    <td>ESTOQUE</td>
                    <td><?php echo number_format($estoque->sum('peso_agregado'), 2, ',', '.'); ?></td>
                    <td><?php echo number_format($estoque->sum('fator_agregado'), 1, ',', '.'); ?></td>
                    <td><?php echo number_format($estoque->sum('peso_agregado') + ($estoque->sum('fator_agregado') / 32), 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td><b>Total</b></td>
                    <td><b><?php echo number_format(abs($representantes->sum('conta_corrente_sum_peso_agregado')) + $estoque->sum('peso_agregado'), 2, ',', '.'); ?></b></td>
                    <td>
                        <b>
                            <?php echo number_format(abs($representantes->sum('conta_corrente_sum_fator_agregado'))
                                + $estoque->sum('fator_agregado'), 1, ',', '.'); ?>
                        </b>
                    </td>
                    <td>
                        <b>
                            <?php echo number_format(abs($representantes->sum('conta_corrente_sum_peso_agregado'))
                                + abs($representantes->sum('conta_corrente_sum_fator_agregado') / 32 )
                                + $estoque->sum('peso_agregado')
                                + ($estoque->sum('fator_agregado') / 32), 2, ',', '.'); ?>
                        </b>
                    </td>
                </tr>
            </tfoot>
        </tbody>
    </table>

<!--
    <table>
        <thead>
            <tr>
                <th colspan=2>Juros adiamentos</th>
            </tr>
            <tr>
                <th>Parceiro</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $parceiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parceiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($parceiro->nomeParceiro); ?></td>
                    <td><?php echo 'R$ ' . number_format($parceiro->totalJuros, 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=2>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
-->




</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/fornecedor/pdf/diario2.blade.php ENDPATH**/ ?>