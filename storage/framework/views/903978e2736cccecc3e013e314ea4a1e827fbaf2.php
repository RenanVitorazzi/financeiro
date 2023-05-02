<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório Mensal <?php echo e($mes); ?>/<?php echo e($ano); ?></title>
</head>
<style>
    table {
        width:49%;
        border-collapse: collapse;
        font-size: 14px;
        page-break-inside: avoid;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
    }
    th {
        background-color: #b0b8c2;
    }
    h1 {
        text-align: center;
    }
    .table-representantes {
        float: right;
    }
    tfoot {
        background-color: #d9dde2;
    }
</style>
<body>
    <table class='table-representantes'>
        <thead>
            <tr>
                <th colspan = 5>Representantes</th>
            </tr>
            <tr>
                <th rowspan=2>Nome</th>
                <th colspan=2>Reposição</th>
                <th colspan=2>Venda</th>
            </tr>
            <tr>
                <th>Peso</th>
                <th>Fator</th>
                <th>Peso</th>
                <th>Fator</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $cc_representantes->groupBy('representante_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($representantes->where('id', $key)->first()->pessoa->nome); ?></td>
                    <td><?php echo number_format($cc->where('balanco', 'LIKE', 'Reposição')->sum('peso'), 2, ',', '.'); ?></td>
                    <td><?php echo number_format($cc->where('balanco', 'LIKE', 'Reposição')->sum('fator'), 1, ',', '.'); ?></td>
                    <td><?php echo number_format($cc->where('balanco', 'LIKE', 'Venda')->sum('peso'), 2, ',', '.'); ?></td>
                    <td><?php echo number_format($cc->where('balanco', 'LIKE', 'Venda')->sum('fator'), 1, ',', '.'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan = 5>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td><?php echo number_format($cc_representantes->where('balanco', 'LIKE', 'Reposição')->sum('peso'), 2, ',', '.'); ?></td>
                <td><?php echo number_format($cc_representantes->where('balanco', 'LIKE', 'Reposição')->sum('fator'), 1, ',', '.'); ?></td>
                <td><?php echo number_format($cc_representantes->where('balanco', 'LIKE', 'Venda')->sum('peso'), 2, ',', '.'); ?></td>
                <td><?php echo number_format($cc_representantes->where('balanco', 'LIKE', 'Venda')->sum('fator'), 1, ',', '.'); ?></td>
            </tr>
            <tr>
                <td rowspan=2>Saldo total</td>
                <td colspan=2>Peso</td>
                <td colspan=2>Fator</td>
            </tr>
            <tr>
                <td colspan=2><?php echo number_format($cc_representantes->where('balanco', 'LIKE', 'Venda')->sum('peso') - $cc_representantes->where('balanco', 'LIKE', 'Reposição')->sum('peso'), 2, ',', '.'); ?> </td>
                <td colspan=2><?php echo number_format($cc_representantes->where('balanco', 'LIKE', 'Venda')->sum('fator') - $cc_representantes->where('balanco', 'LIKE', 'Reposição')->sum('fator'), 1, ',', '.'); ?> </td>
            </tr>
        </tfoot>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan = 3>Fornecedores</th>
            </tr>
            <tr>
                <th>Nome</th>
                <th>Compra</th>
                <th>Fechamento</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $cc_fornecedores->groupBy('fornecedor_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($fornecedores->where('id', $key)->first()->pessoa->nome); ?></td>
                    <td><?php echo number_format($cc->where('balanco', 'LIKE', 'Débito')->sum('peso'), 2, ',', '.'); ?></td>
                    <td><?php echo number_format($cc->where('balanco', 'LIKE', 'Crédito')->sum('peso'), 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan = 3>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td><?php echo number_format($cc_fornecedores->where('balanco', 'LIKE', 'Débito')->sum('peso'), 2, ',', '.'); ?></td>
                <td><?php echo number_format($cc_fornecedores->where('balanco', 'LIKE', 'Crédito')->sum('peso'), 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td>Saldo total</td>
                <td colspan=2> <?php echo number_format($cc_fornecedores->where('balanco', 'LIKE', 'Crédito')->sum('peso') - $cc_fornecedores->where('balanco', 'LIKE', 'Débito')->sum('peso'), 2, ',', '.'); ?> </td>
            </tr>
        </tfoot>
    </table>

    <br>

    <table class='table-representantes'>
        <thead>
            <tr>
                <th colspan = 2>Adiamentos</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total de cheques adiado</td>
                <td><?php echo e($adiamentos->total); ?></td>
            </tr>
            <tr>
                <td>Total de Juros</td>
                <td><?php echo 'R$ ' . number_format($adiamentos->juros, 2, ',', '.'); ?></td>
            </tr>
        </tbody>

    </table>

    <table>
        <thead>
            <tr>
                <th colspan = 2>Depósitos e OPs</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Depósitos de cheques em conta</td>
                <td><?php echo 'R$ ' . number_format($depositosConta, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td>OPs</td>
                <td><?php echo 'R$ ' . number_format($ops, 2, ',', '.'); ?></td>
            </tr>
        </tbody>

    </table>

    <br>
    <table>
        <thead>
            <tr>
                <th colspan = 2>Despesa</th>
            </tr>
            <tr>
                <th>Local</th>
                <th>Valor</th>

            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $despesa_mensal->groupBy('local_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $despesa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($locais->where('id', $key)->first()->nome); ?></td>
                    <td><?php echo 'R$ ' . number_format($despesa->sum('valor'), 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan = 2>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td><?php echo 'R$ ' . number_format($despesa_mensal->sum('valor'), 2, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/fornecedor/pdf/pdf_relatorio_mensal.blade.php ENDPATH**/ ?>