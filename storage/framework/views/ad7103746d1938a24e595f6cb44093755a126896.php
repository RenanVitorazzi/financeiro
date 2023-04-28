
<?php $__env->startSection('title'); ?>
Editar recebimento
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('recebimentos.index')); ?>">Recebimentos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>

<form method="POST" action="<?php echo e(route('recebimentos.update', $pagamentosRepresentantes)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Editar pagamento</h5>
            <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <tr>
                        <th colspan=6>Informações do cheque</th>
                    </tr>
                    <tr>
                        <th>Nome titular</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Representante</th>
                        <th>Parceiro</th>
                        <th>Status</th>
                    </tr>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?> 
                <tbody>
                    <tr>
                        <td><?php echo e($pagamentosRepresentantes->parcela->nome_cheque ?? $pagamentosRepresentantes->parcela->venda->cliente->pessoa->nome); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($pagamentosRepresentantes->parcela->data_parcela)); ?></td>
                        <td><?php echo 'R$ ' . number_format($pagamentosRepresentantes->parcela->valor_parcela, 2, ',', '.'); ?></td>
                        <td><?php echo e($pagamentosRepresentantes->parcela->representante->pessoa->nome); ?></td>
                        <td><?php echo e($pagamentosRepresentantes->parcela->parceiro->pessoa->nome ?? 'Carteira'); ?></td>
                        <td><?php echo e($pagamentosRepresentantes->parcela->status); ?></td>
                    </tr>
                </tbody>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
            <?php if(!$outrosPagamentos->isEmpty()): ?>
                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <tr>
                            <th colspan=3>Pagamentos relacionados ao mesmo cheque</th>
                        </tr>
                        <tr>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Conta</th>
                        </tr>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?> 
                    <tbody>
                        <?php $__currentLoopData = $outrosPagamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outroPagamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($outroPagamento->data)); ?></td>
                                <td><?php echo 'R$ ' . number_format($outroPagamento->valor, 2, ',', '.'); ?></td>
                                <td><?php echo e($outroPagamento->conta->nome); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan=2>Total</th>
                            <th><?php echo 'R$ ' . number_format($outrosPagamentos->sum('valor'), 2, ',', '.'); ?></th>
                        </tr>
                    </tfoot>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
            <?php endif; ?>
            <div class="row">
                <div class="col-4">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['type' => 'date','name' => 'data','value' => ''.e($pagamentosRepresentantes->data ?? old('data')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'date','name' => 'data','value' => ''.e($pagamentosRepresentantes->data ?? old('data')).'']); ?>Data <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <div class="col-4">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'valor','value' => ''.e($pagamentosRepresentantes->valor ?? old('valor')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'valor','value' => ''.e($pagamentosRepresentantes->valor ?? old('valor')).'']); ?>Valor <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                
                <div class="col-4 form-group">
                    <label for="conta_id">Conta</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'conta_id']); ?>
                        <option></option>
                        <?php $__currentLoopData = $contas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value=<?php echo e($conta->id); ?> <?php echo e($pagamentosRepresentantes->conta_id == $conta->id ? 'selected' : ''); ?>>
                                <?php echo e($conta->nome); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <option value="999">Conta de Parceiro</option>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>
                <div class="col-4 form-group">
                    <label for="forma_pagamento">Forma de Pagamento</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'forma_pagamento']); ?>
                        <?php $__currentLoopData = $formasPagamento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formaPagamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value=<?php echo e($formaPagamento); ?> <?php echo e($pagamentosRepresentantes->forma_pagamento == $formaPagamento ? 'selected' : ''); ?>>
                                <?php echo e($formaPagamento); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>
                <div class="col-4 form-group">
                    <label for="confirmado">Pagamento Confirmado?</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'confirmado','value' => ''.e(old('confirmado')).'']); ?>
                        <option value=1 <?php echo e($pagamentosRepresentantes->confirmado ? 'selected' : ''); ?>> Sim </option>
                        <option value=0 <?php echo e($pagamentosRepresentantes->confirmado ? '' : 'selected'); ?>> Não </option>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>
                
                <div class="col-12">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['type' => 'text','name' => 'comprovante_id','value' => ''.e($pagamentosRepresentantes->comprovante_id ?? old('comprovante_id')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','name' => 'comprovante_id','value' => ''.e($pagamentosRepresentantes->comprovante_id ?? old('comprovante_id')).'']); ?>Comprovante ID <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <div class="col-12 form-group">
                    <label for="observacao">Observação</label>
                    <?php if (isset($component)) { $__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TextArea::class, []); ?>
<?php $component->withName('text-area'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'observacao','type' => 'text','value' => ''.e($pagamentosRepresentantes->observacao ?? old('observacao')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405)): ?>
<?php $component = $__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405; ?>
<?php unset($__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405); ?>
<?php endif; ?>
                </div>
            </div> 
        </div>
    </div>

    <input type="submit" class='btn btn-success'>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/recebimento/edit.blade.php ENDPATH**/ ?>