<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movimentação diária <?php echo date('d/m/Y', strtotime($hoje)); ?></title>
</head>
<style>
    table { 
        width:100%;
        border-collapse: collapse;
        font-size: 12   px;
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
    .titular {
        font-size:9px;
    }
</style>
<body>
    <h5>Movimentação diária - <?php echo date('d/m/Y', strtotime($hoje)); ?></h5>
    <table>
        <thead>
            <tr>
                <th colspan = 5>Representantes</th>
            </tr>
            <tr>
                <th>Representante</th>
                <th>Balanço</th>
                <th>Peso</th>
                <th>Fator</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $cc_representante; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $representante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($representante->nome); ?></td>
                    <td><?php echo e($representante->balanco); ?></td>
                    <td><?php echo number_format($representante->peso, 2, ',', '.'); ?></td>
                    <td><?php echo number_format($representante->fator, 1, ',', '.'); ?></td>
                    <td><?php echo e($representante->observacao); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=5>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<br>
    <table>
        <thead>
            <tr>
                <th colspan = 4>Fornecedores</th>
            </tr>
            <tr>
                <th>Representante</th>
                <th>Balanço</th>
                <th>Peso</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $cc_fornecedor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fornecedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($fornecedor->nome); ?></td>
                    <td><?php echo e($fornecedor->balanco); ?></td>
                    <td><?php echo number_format($fornecedor->peso, 2, ',', '.'); ?></td>
                    <td>
                        <?php echo e($fornecedor->observacao); ?>

                        <?php if($fornecedor->balanco == 'Crédito'): ?>
                            <?php echo 'R$ ' . number_format($fornecedor->valor, 2, ',', '.'); ?> / <?php echo 'R$ ' . number_format($fornecedor->cotacao, 2, ',', '.'); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=4>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
   <br>
   <table>
        <thead>
            <tr>
                <th colspan = 7>Adiamentos</th>
            </tr>
            <tr>
                <th>Cliente</th>
                <th>Data</th>
                <th>Para</th>
                <th>Valor</th>
                <th>Juros</th>
                <th>Rep</th>
                <th>Parceiro</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $adiamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adiamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class='titular'><?php echo e($adiamento->nome_cheque); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($adiamento->data_parcela)); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($adiamento->nova_data)); ?></td>
                    <td><?php echo 'R$ ' . number_format($adiamento->valor_parcela, 2, ',', '.'); ?></td>
                    <td><?php echo 'R$ ' . number_format($adiamento->juros_totais, 2, ',', '.'); ?></td>
                    <td><?php echo e($adiamento->nome_representante); ?></td>
                    <td><?php echo e($adiamento->nome_parceiro); ?></td>
                </tr>
                <?php 
                    $juros_totais += $adiamento->juros_totais;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=7>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan=4>Juros Totais</th>
                <th colspan=3><?php echo 'R$ ' . number_format($juros_totais, 2, ',', '.'); ?></th>
            </tr>
        </tfoot>
    </table>
    <br>
   <table>
        <thead>
            <tr>
                <th colspan = 6>Cheques Devolvidos/Resgatados</th>
            </tr>
            <tr>
                <th>Cliente</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Rep</th>
                <th>Parceiro</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $devolvidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $devolvido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class='titular'><?php echo e($devolvido->nome_cheque); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($devolvido->data_parcela)); ?></td>
                    <td><?php echo 'R$ ' . number_format($devolvido->valor_parcela, 2, ',', '.'); ?></td>
                    <td><?php echo e($devolvido->status); ?> <?php echo e($devolvido->motivo); ?></td>
                    <td><?php echo e($devolvido->nome_representante); ?></td>
                    <td><?php echo e($devolvido->nome_parceiro); ?></td>
                </tr>
                <?php 
                    $total_devolvido += $devolvido->valor_parcela;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=6>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan=4>Total</th>
                <th colspan=2><?php echo 'R$ ' . number_format($total_devolvido, 2, ',', '.'); ?></th>
            </tr>
        </tfoot>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th colspan = 4>Cheques Depositados</th>
            </tr>
            <tr>
                <th>Cliente</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Representante</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $depositados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depositado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class='titular'><?php echo e($depositado->nome_cheque); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($depositado->data_parcela)); ?></td>
                    <td><?php echo 'R$ ' . number_format($depositado->valor_parcela, 2, ',', '.'); ?></td>
                    <td><?php echo e($depositado->nome_representante); ?></td>
                </tr>
                <?php 
                    $total_depositado += $depositado->valor_parcela;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=4>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan=3>Total</th>
                <th colspan=1><?php echo 'R$ ' . number_format($total_depositado, 2, ',', '.'); ?></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>

<?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/fornecedor/pdf/mov_diario.blade.php ENDPATH**/ ?>