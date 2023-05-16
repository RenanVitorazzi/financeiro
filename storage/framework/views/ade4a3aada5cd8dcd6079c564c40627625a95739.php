<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Vendas </title>
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
    h1, h3 {
        text-align: center;
    }
    .nome {
        font-size:10px;
    }
</style>
<body>
    <h3>
        Relatório Vendas - <?php echo e($representante->pessoa->nome); ?>

    </h3>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Cliente</th>
                <th>Peso</th>
                <th>Peso pago</th>
                <th>Fator</th>
                <th>Fator Pago</th>
                <th>Total</th>
                <th>Total Pago</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $vendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($venda->data_venda)); ?></td>
                    <td class='nome'><?php echo e(substr($venda->cliente->pessoa->nome,0,25)); ?></td>
                    <td><?php echo number_format($venda->peso, 2, ',', '.'); ?></td>
                    <td><?php echo 'R$ ' . number_format($venda->cotacao_peso, 2, ',', '.'); ?></td>
                    <td><?php echo number_format($venda->fator, 1, ',', '.'); ?></td>
                    <td><?php echo 'R$ ' . number_format($venda->cotacao_fator, 2, ',', '.'); ?></td>
                    <td><?php echo 'R$ ' . number_format(($venda->peso * $venda->cotacao_peso) + ($venda->fator * $venda->cotacao_fator), 2, ',', '.'); ?></td>
                    <td><?php echo 'R$ ' . number_format($venda->valor_total, 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=8>Nenhum registro</td>
                </tr>
            <?php endif; ?>
            <tfoot>
                <tr>
                    <td colspan=2><b>Total</b></td>
                    <td colspan=2><b><?php echo number_format($vendas->sum('peso'), 2, ',', '.'); ?></b></td>
                    <td colspan=2><b><?php echo number_format($vendas->sum('fator'), 1, ',', '.'); ?></b></td>
                    <td colspan=2><b><?php echo 'R$ ' . number_format($vendas->sum('valor_total'), 2, ',', '.'); ?></b></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>Média Preço Peso</th>
                <th>Média Preço Fator</th>
                <th>Total Vendas (Prazo)</th>
                <th>Total Vendas (À Vista)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo 'R$ ' . number_format($vendas->avg('cotacao_peso'), 2, ',', '.'); ?></td>
                <td><?php echo 'R$ ' . number_format($vendas->avg('cotacao_fator'), 2, ',', '.'); ?></td>
                <td><?php echo e($vendas->where('metodo_pagamento', '=', 'Parcelado')->count()); ?></td>
                <td><?php echo e($vendas->where('metodo_pagamento', '=', 'À vista')->count()); ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>Forma Pagamento</th>
                <th>Status</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pagamentosPorForma; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pagamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($pagamento->first()->forma_pagamento); ?></td>
                    <td><?php echo e($pagamento->first()->status); ?></td>
                    <td><?php echo 'R$ ' . number_format($pagamento->sum('valor_parcela'), 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=5>Nenhum registro</td>
                </tr>
            <?php endif; ?>
            <tfoot>
                <tr>
                    <td colspan=2><b>Total</b></td>
                    <td><b><?php echo 'R$ ' . number_format($pagamentos_total, 2, ',', '.'); ?></b></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
</body>
</html>

<?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/venda/pdf/pdf_conferencia_relatorio_vendas.blade.php ENDPATH**/ ?>