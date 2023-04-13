
<?php $__env->startSection('title'); ?>
<?php echo e($representante->pessoa->nome); ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <?php if(!auth()->user()->is_representante): ?>
        <li class="breadcrumb-item"><a href="<?php echo e(route('representantes.index')); ?>">Representantes</a></li>
        <?php endif; ?>
        <li class="breadcrumb-item active"><?php echo e($representante->pessoa->nome); ?> </li>
    </ol>
</nav>

<div class='mb-2 d-flex justify-content-between'>
    <h3><?php echo e($representante->pessoa->nome); ?></h3>
    <?php if (isset($component)) { $__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoImprimir::class, []); ?>
<?php $component->withName('botao-imprimir'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['href' => ''.e(route('fechamento_representante', $representante->id)).'']); ?> <?php if (isset($__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5)): ?>
<?php $component = $__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5; ?>
<?php unset($__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
</div>

<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-header">Conta Corrente</div>
            <div class="card-body"> 
                <p>Peso: <?php echo number_format($representante->conta_corrente_sum_peso_agregado, 2, ',', '.'); ?>g</p>
                <p>Fator: <?php echo number_format($representante->conta_corrente_sum_fator_agregado, 1, ',', '.'); ?></p>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">Devolvidos</div>
            <div class="card-body">
                <p><?php echo 'R$ ' . number_format($devolvidos->sum('valor_parcela'), 2, ',', '.'); ?></p>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">Prorrogações</div>
            <div class="card-body">
                <p><?php echo 'R$ ' . number_format($representante->parcelas->sum('adiamentos_sum_juros_totais'), 2, ',', '.'); ?></p>
            </div>
        </div>
    </div>
</div>
<p></p>
<form action=<?php echo e(route('baixarDebitosRepresentantes', $representante->id)); ?> method="POST">
    <?php echo csrf_field(); ?>
    <div class="card">
        <div class="card-header">Cheques Prorrogados</div>
        <div class="card-body"> 
            <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                <thead>
                    <tr>
                        <th>Titular</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Nova data</th>
                        <th>Juros</th>
                        <th>Parceiro</th>
                        <th><input type='checkbox' id='selecionarAdiados'></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $representante->parcelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($cheque->nome_cheque); ?></td>
                        <td><?php echo 'R$ ' . number_format($cheque->valor_parcela, 2, ',', '.'); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($cheque->data_parcela)); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($cheque->adiamentos->nova_data)); ?></td>
                        <td><?php echo 'R$ ' . number_format($cheque->adiamentos->juros_totais, 2, ',', '.'); ?></td>
                        <td><?php echo e($cheque->parceiro->pessoa->nome  ?? 'Carteira'); ?></td>
                        <td>
                            <input type='checkbox' name='adiamentos[]' value="<?php echo e($cheque->adiamentos->id); ?>">
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan=6>Nenhum cheque devolvido</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
             <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
        </div>
    </div>

    <p></p>
    <div class="card">
        <div class="card-header">Cheques Devolvidos</div>
        <div class="card-body"> 
            <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                <thead>
                    <tr>
                        <th>Titular</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Parceiro</th>
                        <th><input type='checkbox' id='selecionarDevolvidos'></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $devolvidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($cheque->nome_cheque); ?></td>
                        <td><?php echo 'R$ ' . number_format($cheque->valor_parcela, 2, ',', '.'); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($cheque->data_parcela)); ?></td>
                        <td><?php echo e($cheque->parceiro->pessoa->nome  ?? 'Carteira'); ?></td>
                        <td><input type='checkbox' name='devolvidos[]' value="<?php echo e($cheque->id); ?>"></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan=5>Nenhum cheque devolvido</td>
                        </tr>
                    <?php endif; ?> 
                </tbody>
             <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
        </div>
    </div>
    <br>
    <button type='submit' class="btn btn-dark float-right">Baixar pagamentos</button>
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    $("#selecionarAdiados").click( (e) => {
        let status = $(e.target).prop("checked");
        $("input[name='adiamentos[]']").each( (index, element) => {
           $(element).prop("checked", status);
        });
    })
    $("#selecionarDevolvidos").click( (e) => {
        let status = $(e.target).prop("checked");
        $("input[name='devolvidos[]']").each( (index, element) => {
           $(element).prop("checked", status);
        });
    })


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/representante/show.blade.php ENDPATH**/ ?>