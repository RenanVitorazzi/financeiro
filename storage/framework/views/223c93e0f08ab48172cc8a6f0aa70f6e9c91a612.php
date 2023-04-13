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
    .pagamentos, .status {
        font-size:10px;
    }
    .pagamentos {
        width:30%;
    }
    .tabelaloca {
        font-size: 14px;
    } 
    .vencido {
        background-color:rgb(209, 92, 92);
    }
    .vencimento {
        width:10%;
    }
    .linha-pagamento {
        margin: 0px;
    }
</style>
<body>
    <h3>Acerto de documentos - <?php echo e($representante->pessoa->nome); ?></h3>
   
    <?php $__currentLoopData = $acertos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acerto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <table>
            <thead>
                <tr>
                    <th colspan=6><?php echo e($acerto->cliente); ?></th>
                </tr>
                <tr>
                    <th class="vencimento">Vencimento</th>
                    <th>Status</th>
                    <th>Forma</th>
                    <th>Valor</th>
                    <th>Pagamentos</th>
                    <th>Total Aberto</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $sql = DB::select( "SELECT 
                        p.data_parcela as vencimento,
                        p.valor_parcela AS valor,
                        p.status,
                        p.forma_pagamento,
                        (SELECT nome from pessoas WHERE id = r.pessoa_id) as representante,
                        SUM(pr.valor) AS valor_pago,
                        p.id as parcela_id
                    FROM
                        vendas v
                            INNER JOIN
                        parcelas p ON p.venda_id = v.id
                            LEFT JOIN clientes c ON c.id = v.cliente_id
                            LEFT JOIN representantes r ON r.id = v.representante_id
                            LEFT JOIN pagamentos_representantes pr ON pr.parcela_id = p.id 
                    WHERE
                        p.deleted_at IS NULL
                        AND v.deleted_at IS NULL 
                        AND r.id = ?
                        AND (
                        p.forma_pagamento like 'Cheque' AND p.status like 'Aguardando Envio'
                        OR 
                        p.forma_pagamento != 'Cheque' AND p.status != 'Pago'
                        )
                        AND pr.deleted_at IS NULL
                        AND pr.baixado IS NULL
                        AND c.id = ?
                    GROUP BY p.id
                    ORDER BY c.pessoa_id, data_parcela , valor_parcela", 
                    [$representante_id, $acerto->cliente_id]
                );

                $cliente_valor = 0;
                $cliente_valor_pago = 0;
            ?>
                
                <?php $__currentLoopData = $sql; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $divida): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $pgtos = DB::select( "SELECT c.nome as conta_nome, pr.* 
                            FROM pagamentos_representantes pr 
                            INNER JOIN contas c ON c.id=pr.conta_id
                            WHERE pr.parcela_id = ?
                                AND pr.baixado IS NULL
                                AND pr.deleted_at IS NULL", 
                            [$divida->parcela_id]
                        );
                        $cliente_valor += $divida->valor;
                        $cliente_valor_pago += $divida->valor_pago;

                        $total_divida_valor += $divida->valor;
                        $total_divida_valor_pago += $divida->valor_pago;
                    ?>
                    <tr class="<?php echo e($divida->vencimento < $hoje ? 'vencido' : ''); ?>">
                        <td><?php echo date('d/m/Y', strtotime($divida->vencimento)); ?></td>
                        <td class='status'><?php echo e($divida->status); ?></td>
                        <td><?php echo e($divida->forma_pagamento == 'Transferência Bancária' ? 'Op' : $divida->forma_pagamento); ?></td>
                        <td><?php echo 'R$ ' . number_format($divida->valor, 2, ',', '.'); ?></td>
                        <td class='pagamentos'>
                            <?php $__currentLoopData = $pgtos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pgto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="linha-pagamento"> 
                                    <?php echo date('d/m/Y', strtotime($pgto->data)); ?> - <?php echo 'R$ ' . number_format($pgto->valor, 2, ',', '.'); ?> (<?php echo e($pgto->conta_nome); ?>) 
                                    <b><?php echo e($pgto->confirmado ? '' : 'PAGAMENTO NÃO CONFIRMADO'); ?></b>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td><?php echo 'R$ ' . number_format($divida->valor - $divida->valor_pago, 2, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan=3><b>TOTAL</b></td>
                    <td><?php echo 'R$ ' . number_format($cliente_valor, 2, ',', '.'); ?></td>
                    <td><?php echo 'R$ ' . number_format($cliente_valor_pago, 2, ',', '.'); ?></td>
                    <td><b><?php echo 'R$ ' . number_format($cliente_valor - $cliente_valor_pago, 2, ',', '.'); ?></b></td>
                </tr>
            </tfoot>
        </table>
        <br>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <table class="tabelaloca">
        <thead>
            <tr><th colspan=3>RESUMO</th></tr>
            <tr>
                <th>VALOR</th>
                <th>VALOR RECEBIDO</th>
                <th>VALOR EM ABERTO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo 'R$ ' . number_format($total_divida_valor, 2, ',', '.'); ?></td>
                <td><?php echo 'R$ ' . number_format($total_divida_valor_pago, 2, ',', '.'); ?></td>
                <td><b><?php echo 'R$ ' . number_format($total_divida_valor - $total_divida_valor_pago, 2, ',', '.'); ?></b></td>
            </tr>
        </tbody>
    </table>
</body>
</html>

<?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/venda/pdf/pdf_acerto_documento.blade.php ENDPATH**/ ?>