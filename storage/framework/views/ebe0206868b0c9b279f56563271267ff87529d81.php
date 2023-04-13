<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carteira de cheques</title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
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
    h1 {
        text-align: center;
    }
</style>
<body>
    <h1>Carteira de cheques</h1>
    <table>
        <thead>
            <tr>
                <th>Mês</th>
                <th>Valor</th>
                <th>Valor (Adiados)</th>
                <th>Valor (Total)</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $carteira; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carteira_mensal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>
                    <td><?php echo e($carteira_mensal->month); ?>/<?php echo e($carteira_mensal->year); ?></td>
                    <td><?php echo 'R$ ' . number_format($carteira_mensal->valor, 2, ',', '.'); ?></td>
                    <?php
                        $adiadoMes = DB::select('SELECT 
                                SUM(p1.valor_parcela) as total_adiado,
                                YEAR(nova_data) year, 
                                MONTH(nova_data) month 
                            FROM adiamentos a 
                            INNER JOIN parcelas p1 ON a.parcela_id = p1.id  
                            WHERE NOT EXISTS (SELECT id FROM adiamentos AS M2 WHERE M2.parcela_id = a.parcela_id AND M2.id > a.id) 
                            AND p1.parceiro_id is null
                            AND MONTH(nova_data) = ?
                            GROUP BY month, year', 
                            [$carteira_mensal->month]
                        );
                        // dd($totalAdiado);
                    ?>
                    <?php if(count($adiadoMes) > 0): ?>
                        <td><?php echo 'R$ ' . number_format($adiadoMes[0]->total_adiado, 2, ',', '.'); ?></td>
                        <td><?php echo 'R$ ' . number_format($carteira_mensal->valor + $adiadoMes[0]->total_adiado, 2, ',', '.'); ?></td>
                    <?php else: ?>
                        <td><?php echo 'R$ ' . number_format(0, 2, ',', '.'); ?></td>
                        <td><?php echo 'R$ ' . number_format($carteira_mensal->valor, 2, ',', '.'); ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan=4>Nenhum registro</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Total</b></td>
                <td><b><?php echo 'R$ ' . number_format($carteira->sum('valor'), 2, ',', '.'); ?></b></td>
                <?php
                    $totalAdiado = DB::select('SELECT 
                            SUM(p1.valor_parcela) as total_adiado,
                            YEAR(nova_data) year, 
                            MONTH(nova_data) month 
                        FROM adiamentos a 
                        INNER JOIN parcelas p1 ON a.parcela_id = p1.id 
                        WHERE NOT EXISTS (SELECT id FROM adiamentos AS M2 WHERE M2.parcela_id = a.parcela_id AND M2.id > a.id) 
                        AND p1.parceiro_id is null
                        GROUP BY month, year'
                    );
                    // dd($totalAdiado->sum('total_adiado'));
                    $valorTotalAdiado = 0;

                    foreach ($totalAdiado as $valor => $value) {
                        $valorTotalAdiado += $value->total_adiado;
                    }
                ?>
                <td><b><?php echo 'R$ ' . number_format($valorTotalAdiado, 2, ',', '.'); ?></b></td>
                <td><b><?php echo 'R$ ' . number_format($carteira->sum('valor') + $valorTotalAdiado, 2, ',', '.'); ?></b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

<?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/cheque/pdf/carteira.blade.php ENDPATH**/ ?>