
<?php $__env->startSection('title'); ?>
Adicionar vendas
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <?php if(!auth()->user()->is_representante): ?>
        <li class="breadcrumb-item"><a href="<?php echo e(route('representantes.index')); ?>">Representantes</a></li>
        <?php endif; ?>
        <li class="breadcrumb-item"><a href="<?php echo e(route('venda.show', $representante_id)); ?>">Vendas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
<form method="POST" action="<?php echo e(route('venda.store')); ?>" id="formEnviarVenda">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-6">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'data_venda','type' => 'date','autofocus' => true,'value' => ''.e(date('Y-m-d')).'','required' => true]]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'data_venda','type' => 'date','autofocus' => true,'value' => ''.e(date('Y-m-d')).'','required' => true]); ?>Data <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div> 
        <div class="col-6 form-group">
            <label for="cliente_id">Cliente</label>
            <div class="d-flex">
                <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'cliente_id','required' => true]); ?>
                    <option></option>
                    <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cliente->id); ?>" <?php echo e(old("cliente_id") == $cliente->id ? 'selected': ''); ?> >
                        <?php echo e($cliente->nome); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                <div class="btn btn-dark procurarCliente">
                    <span class="fas fa-search"></span>
                </div>
            </div>
        </div>
    </div>
        
    <div id="consignado"></div>
        
    <input type="hidden" name="balanco" value="Venda">
    <input type="hidden" name="representante_id" id="representante_id" value="<?php echo e($representante_id); ?>">
        
        <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'table-striped table-bordered']); ?>
            <thead class="thead-dark">
                <tr>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Peso</td>
                    <td><?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'number','name' => 'peso','step' => '0.001','value' => ''.e(old('peso')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?></td>
                    <td><?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'number','name' => 'cotacao_peso','step' => '0.01','value' => ''.e(old('cotacao_peso')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?></td>
                </tr>
                <tr>
                    <td>Fator</td>
                    <td><?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'number','name' => 'fator','step' => '0.01','value' => ''.e(old('fator')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?></td>
                    <td><?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'number','name' => 'cotacao_fator','step' => '0.01','value' => ''.e(old('cotacao_fator')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?></td>
                </tr>
                <tr>
                    <td colspan='2'>Total</td>
                    <td><?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'valor_total','type' => 'number','step' => '0.01','value' => ''.e(old('valor_total')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?></td>
                </tr>
            </tbody>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
        <div class='row'>
            <div class="col-4 form-group">
                <label for="metodo_pagamento">Método de Pagamento</label>
                <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'metodo_pagamento','required' => true]); ?>
                    <option value=""></option>
                    <?php $__currentLoopData = $metodo_pagamento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metodo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option  <?php echo e(old('metodo_pagamento') == $metodo ? 'selected' : ''); ?> value="<?php echo e($metodo); ?>"><?php echo e($metodo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?> 
            </div>
            <div class="col-4 form-group" id="groupDiaVencimento">
                <label for="dia_vencimento">Dia de vencimento</label>
                <?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'dia_vencimento','type' => 'number','value' => ''.e(old('dia_vencimento')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?>
            </div>
            <div class="col-4 form-group" id="groupParcelas">
                <label for="parcelas">Quantidade de parcelas</label>
                <?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'parcelas','type' => 'number','value' => ''.e(old('parcelas')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?>
            </div>
        </div> 
    
    <div id="infoCheques" class="row">
        <?php if(old('parcelas') && old('parcelas') > 0): ?>
            <?php for($i = 0; $i < old('parcelas'); $i++): ?>
                <div class="col-4">
                    <div class="card mb-4 card-hover">
                        <div class="card-body">
                            <h5 class="card-title mb-4"> 
                                <div class="d-flex justify-content-between">
                                    <div><?php echo e($i + 1); ?>ª Parcela</div>
                                    <?php if($i == 0): ?> 
                                        <div class="btn btn-dark copiarDadosPagamento">Copiar</div>
                                    <?php endif; ?>
                                </div>
                            </h5>
                            <div class='form-group'>
                                <label for="forma_pagamento[<?php echo e($i); ?>]">Informe a forma de pagamento</label>
                                <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'form-control '.e($errors->has('forma_pagamento.'.$i) ? 'is-invalid' : '').'','name' => 'forma_pagamento['.e($i).']','id' => 'forma_pagamento['.e($i).']','data-index' => ''.e($i).'']); ?>
                                    <option value=""></option>
                                    <?php $__currentLoopData = $forma_pagamento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($forma); ?>" <?php echo e($forma == old('forma_pagamento.'.$i) ? 'selected' : ''); ?>>
                                            <?php echo e($forma); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['forma_pagamento.'.$i];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-inline">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group <?php echo e(old('forma_pagamento.'.$i) == 'Cheque' ? '' : 'd-none'); ?>" id="groupNome_<?php echo e($i); ?>">
                                <label for="nome_cheque[<?php echo e($i); ?>]">Nome</label>
                                <div class="d-flex">
                                    <?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','name' => 'nome_cheque['.e($i).']','id' => 'nome_cheque['.e($i).']','class' => 'form-control primeiroInputNome '.e($errors->has('nome_cheque.'.$i) ? 'is-invalid' : '').'','value' => ''.e(old('nome_cheque.'.$i)).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?>
                                    <?php $__errorArgs = ['nome_cheque.'.$i];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-inline">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="form-group <?php echo e(old('forma_pagamento.'.$i) == 'Cheque' ? '' : 'd-none'); ?>" id="groupNumero_<?php echo e($i); ?>">
                                <label for="numero_banco[<?php echo e($i); ?>]">Número do Banco</label>
                                <div class="d-flex">
                                    <?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','name' => 'numero_banco['.e($i).']','id' => 'numero_banco['.e($i).']','class' => 'form-control '.e($errors->has('numero_banco.'.$i) ? 'is-invalid' : '').'','value' => ''.e(old('numero_banco.'.$i)).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?>
                                    <?php $__errorArgs = ['numero_banco.'.$i];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-inline">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group <?php echo e(old('forma_pagamento.'.$i) == 'Cheque' ? '' : 'd-none'); ?>" id="groupNumero_<?php echo e($i); ?>">
                                <label for="numero_cheque[<?php echo e($i); ?>]">Número do Cheque</label>
                                <div class="d-flex">
                                    <?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','name' => 'numero_cheque['.e($i).']','id' => 'numero_cheque['.e($i).']','class' => 'form-control '.e($errors->has('numero_cheque.'.$i) ? 'is-invalid' : '').'','value' => ''.e(old('numero_cheque.'.$i)).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?>
                                    <?php $__errorArgs = ['numero_cheque.'.$i];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-inline">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="data_parcela[<?php echo e($i); ?>]">Data da Parcela</label>
                                <?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'date','name' => 'data_parcela['.e($i).']','id' => 'data_parcela['.e($i).']','class' => 'form-control '.e($errors->has('data_parcela.'.$i) ? 'is-invalid' : '').'','value' => ''.e(old('data_parcela.'.$i)).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['data_parcela.'.$i];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-inline">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label for="valor_parcela[<?php echo e($i); ?>]">Valor</label>
                                <?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'number','name' => 'valor_parcela['.e($i).']','id' => 'valor_parcela['.e($i).']','class' => 'form-control primeiroInputValor '.e($errors->has('valor_parcela.'.$i) ? 'is-invalid' : '').'','value' => ''.e(old('valor_parcela.'.$i)).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['valor_parcela.'.$i];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-inline">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                           
                            <div class="form-group">
                                <label for="status[<?php echo e($i); ?>]">Status</label>
                                <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'status['.e($i).']','id' => 'status['.e($i).']','class' => ''.e($errors->has('status.'.$i) ? 'is-invalid' : '').'']); ?>
                                    <option value=""></option>
                                    <?php if(old('forma_pagamento.'.$i) == 'Cheque'): ?>
                                        <option value="Aguardando" <?php echo e(old('status.'.$i) == 'Aguardando' ? 'selected' : ''); ?>>Aguardando Depósito</option>
                                        <option value="Aguardando Envio" <?php echo e(old('status.'.$i) == 'Aguardando Envio' ? 'selected' : ''); ?>>Aguardando Envio</option>
                                    <?php elseif(old('forma_pagamento.'.$i) == 'Pix' || old('forma_pagamento.'.$i) == 'Dinheiro'): ?>
                                        <option value="Pago">Pago</option>
                                    <?php elseif(old('forma_pagamento.'.$i) == 'Transferência Bancária'): ?>  
                                        <option value="Pago" <?php echo e(old('status.'.$i) == 'Pago' ? 'selected' : ''); ?>>Pago</option>
                                        <option value="Aguardando Pagamento" <?php echo e(old('status.'.$i) == 'Aguardando Pagamento' ? 'selected' : ''); ?>>Aguardando Pagamento</option>
                                    <?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>

                                <?php $__errorArgs = ['status.'.$i];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-inline">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                
                            </div>
                            <div class="form-group">
                                <label for="observacao[<?php echo e($i); ?>]">Observação</label>
                                <?php if (isset($component)) { $__componentOriginalada24a059c331be0784ec187913c2ecfacd51890 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Textarea::class, []); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'observacao['.e($i).']','id' => 'observacao['.e($i).']','class' => 'form-control']); ?><?php echo e(old('observacao.'.$i)); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalada24a059c331be0784ec187913c2ecfacd51890)): ?>
<?php $component = $__componentOriginalada24a059c331be0784ec187913c2ecfacd51890; ?>
<?php unset($__componentOriginalada24a059c331be0784ec187913c2ecfacd51890); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        <?php endif; ?>
    </div>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div><?php echo e($error); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
    <input type="submit" class='btn btn-success'>
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script>
<script>
    const FORMA_PAGAMENTO = ['Dinheiro', 'Cheque', 'Transferência Bancária', 'Pix']
    let option = `<option></option>`
    let representanteId = $("#representante_id").val()

    FORMA_PAGAMENTO.forEach(element => {
        option += `<option value="${element}">${element}</option>`;
    })

    $("#metodo_pagamento").change( (e) => {
        let metodo = $(e.target).val()

        $("#infoCheques").html("")
        //tipoPagamento(metodo)

        htmlParcelas()
    })

    function calcularDataVencimento (index, dataVenda, diaVencimento) {
        let dataVendaObj = new Date(dataVenda)
        
        let ultimoDiaDoMes = new Date(
            dataVendaObj.getFullYear(), 
            dataVendaObj.getMonth() + index + 1,
            0
        )
        
        let dataVencimentoObj = (diaVencimento > ultimoDiaDoMes.getDate()) 
        ? ultimoDiaDoMes 
        : new Date(
            dataVendaObj.getFullYear(), 
            dataVendaObj.getMonth() + index,
            diaVencimento
        ) 

        return dataVencimentoObj.getFullYear() + '-' 
        + (adicionaZero(dataVencimentoObj.getMonth()+1).toString()) + "-"
        + adicionaZero(dataVencimentoObj.getDate().toString());
    
    }

    function htmlParcelas () {
        $("#parcelas").change ( (e) => {
            let parcelas = $(e.target).val() || 1
            let diaVencimento = $("#dia_vencimento").val()
            let dataVenda = $("#data_venda").val()
            let valorTotal = $("#valor_total").val() || 0
            let proximaData
            let campoValor = valorTotal / parcelas
            let campoValorTratado = campoValor.toFixed(2)
            let html = "";

            if (!dataVenda) {
                Swal.fire(
                    'Erro!',
                    'Informe a data da venda!',
                    'error'
                ).then((result) => {
                    $("#infoCheques").html('')
                    $("#data_venda").focus()
                    return
                })
            }
            
            for (let index = 0; index < parcelas; index++) {
                
                let dataVencimento = calcularDataVencimento(index, dataVenda, diaVencimento)
                
                let btnCopiarDados = (index == 0) 
                ? '<div class="btn btn-dark copiarDadosPagamento">Copiar</div>' 
                : ''

                html += `
                    <div class="col-4">
                        <div class="card mb-4 card-hover">
                            <div class="card-body">
                                <h5 class="card-title mb-4"> 
                                    <div class="d-flex justify-content-between">
                                        <div>${index + 1}ª Parcela</div>
                                        ${btnCopiarDados}
                                    </div>
                                </h5>
                                <div class='form-group'>
                                    <label for="forma_pagamento[${index}]">Informe a forma de pagamento</label>
                                    <select class="form-control" name="forma_pagamento[${index}]" id="forma_pagamento[${index}]" data-index="${index}">
                                        ${option}
                                    </select>
                                </div>
                                <div class="form-group d-none" id="groupNome_${index}">
                                    <label for="nome_cheque[${index}]">Nome</label>
                                    <div class="d-flex">
                                        <input type="text" name="nome_cheque[${index}]" id="nome_cheque[${index}]" class="form-control primeiroInputNome titularCheque">
                                        
                                    </div>
                                </div>
                                <div class="form-group d-none" id="groupNumero_${index}">
                                    <label for="numero_banco[${index}]">Número do Banco</label>
                                    <div class="d-flex">
                                        <input type="text" name="numero_banco[${index}]" id="numero_banco[${index}]" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group d-none" id="groupBanco_${index}">
                                    <label for="numero_cheque[${index}]">Número do Cheque</label>
                                    <div class="d-flex">
                                        <input type="text" name="numero_cheque[${index}]" id="numero_cheque[${index}]" class="form-control">
                                    </div>
                                </div>
                                

                                <div class="form-group">
                                    <label for="data_parcela[${index}]">Data da Parcela</label>
                                    <input type="date" name="data_parcela[${index}]" id="data_parcela[${index}]" class="form-control" value="${dataVencimento}">
                                </div>
                                <div class="form-group">
                                    <label for="valor_parcela[${index}]">Valor</label>
                                    <input type="number" step="0.01" name="valor_parcela[${index}]" id="valor_parcela[${index}]" class="form-control primeiroInputValor" value="${campoValorTratado}">
                                </div>
                                <div class="form-group">
                                    <label for="status[${index}]">Status</label>
                                    <select name="status[${index}]" id="status[${index}]" class="form-control">
                                        <option value="Aguardando" selected>Aguardando Depósito</option>  
                                        <option value="Pago">Pago</option>
                                        <option value="Aguardando Envio">Aguardando Envio</option>
                                        <option value="Aguardando Pagamento">Aguardando Pagamento</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="observacao[${index}]">Observação</label>
                                    <textarea name="observacao[${index}]" id="observacao[${index}]" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            }
            
            $("#infoCheques").html(html);

            copiarDadosPagamento()
            
            listenerFormaPagamentoParcela()
        })
    }

    $("#cotacao_fator, #fator, #cotacao_peso, #peso").change( (e) => {
        
        if (!$("#cotacao_fator").val() && !$("#cotacao_peso").val()) {
            return false;
        }

        let cotacao_fator = $("#cotacao_fator").val() || 0
        let cotacao_peso = $("#cotacao_peso").val() || 0
        let fator = $("#fator").val() || 0
        let peso = $("#peso").val() || 0

        calcularTotalVenda(cotacao_fator, cotacao_peso, fator, peso)
    })

    function adicionaZero(numero){
        if (numero <= 9) 
            return "0" + numero;
        else
            return numero; 
    }

    function calcularTotalVenda (cotacao_fator, cotacao_peso, fator, peso) {

        let totalFator = cotacao_fator * fator
        let totalPeso = cotacao_peso * peso
        let totalCompra = totalFator + totalPeso
        let valorTotalCompraTratado = totalCompra.toFixed(2)
        
        $("#valor_total").val(valorTotalCompraTratado)
    }

    $(".procurarCliente").click( () => {
        $("#modal2").modal('show')

        $("#modal-header2").text(`Procurar cliente`)
        $("#modal-footer2 > .btn-primary").remove()

        $("#modal-body2").html(`
            <form id="formProcurarCliente" method="GET" action="<?php echo e(route('procurarCliente')); ?>">
                <input type='hidden' value="<?php echo e($representante_id); ?>" name="representante_id">
                <div class="d-flex justify-content-between">
                    <input class="form-control" id="dado" name="dado" placeholder="Informe o CPF ou nome do Cliente">
                    <button type="submit" class="btn btn-dark ml-2">
                        <span class="fas fa-search"></span>
                    </button>
                </div>
            </form>
            <div id="respostaProcura" class="mt-2"></div>
        `);

        $("#formProcurarCliente").submit( (element) => {
            element.preventDefault();
            
            let form = element.target;

            if (!$("#dado").val()) {
                $("#respostaProcura").html(`<div class="alert alert-danger">Informe o nome ou o cpf</div>`)
                return false;
            }

            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: $(form).serialize(),
                dataType: 'json',
                beforeSend: () => {
                    swal.showLoading()
                },
                success: (response) => {
                    swal.close()
                    let clientes = response.clientes
                    let html = ""

                    clientes.forEach(element => {
                        html += `
                            <tr>
                                <td>${element.pessoa.nome}</td>
                                <td>
                                    <div class="btn btn-dark btn-selecionar" data-id="${element.id}">
                                        <span class="fas fa-check"></span>
                                    <div>
                                </td>
                        `
                    });

                    $("#respostaProcura").html(`
                        <table class="table text-center table-light">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th><span class="fas fa-check"></th>
                                </tr>    
                            </thead>
                            <tbody>
                                ${html}
                            </tbody>
                        </table>
                    `)

                    $(".btn-selecionar").each( (index, element) => {
                        $(element).click( () => {
                            let cliente_id = $(element).data("id")
                            $(".modal").modal("hide")
                            $("#cliente_id").val(cliente_id)
                        })
                    })
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error(jqXHR)
                    console.error(textStatus)
                    console.error(errorThrown)
                }
            });
        })
    });

    function copiarDadosPagamento () {
        $(".copiarDadosPagamento").click( () => { 
            
            copiarInput(
                $("input[name^='nome_cheque']:eq(0)").val(), 
                $("input[name^='nome_cheque']:not(:eq(0))")
            )

            copiarInput(
                $("input[name^='valor_parcela']:eq(0)").val(), 
                $("input[name^='valor_parcela']:not(:eq(0))")
            )

            copiarInput(
                $("select[name^='forma_pagamento']:eq(0)").val(), 
                $("select[name^='forma_pagamento']:not(:eq(0))")
            )

            copiarInput(
                $("input[name^='numero_banco']:eq(0)").val(), 
                $("input[name^='numero_banco']:not(:eq(0))")
            )
        })
    }

    function copiarInput (valorInput, campos) {
        if (!valorInput) {
            return
        }
        
        campos.each( (index, element) => {
            $(element).val(valorInput).change()
        })
    }

    function listenerFormaPagamentoParcela () {
        $("select[name^='forma_pagamento']").each( (index, element) => {
            $(element).change( (e) => {
                let select = $(e.target)
                let valorSelect = select.val()
                let indexSelect = $(e.target).data('index')

                if (valorSelect == 'Cheque') {
                    $("#groupNumero_" + indexSelect).removeClass('d-none')
                    $("#groupNome_" + indexSelect).removeClass('d-none')
                    $("#groupBanco_" + indexSelect).removeClass('d-none')
                    
                    listenerNomes()
                    tratarCampoStatus(indexSelect, valorSelect)
                } else if (valorSelect == 'Dinheiro' || valorSelect == 'Pix') {
                    $("#groupNumero_" + indexSelect).addClass('d-none')
                    $("#groupNome_" + indexSelect).addClass('d-none')
                    $("#groupBanco_" + indexSelect).addClass('d-none')
                    
                    tratarCampoStatus(indexSelect, valorSelect)
                } else if (valorSelect == 'Transferência Bancária') {
                    $("#groupNumero_" + indexSelect).addClass('d-none')
                    $("#groupNome_" + indexSelect).addClass('d-none')
                    $("#groupBanco_" + indexSelect).addClass('d-none')

                    tratarCampoStatus(indexSelect, valorSelect)
                }

            });
            
        })
    }

    function tratarCampoStatus(index, valorSelect) {
        let opcoesDisponiveis = []
        let element = $("select[name^='status']:eq(" + index + ")")

        if (valorSelect == 'Cheque') {
            opcoesDisponiveis = {
                '': '',
                'Aguardando Depósito': 'Aguardando',
                'Aguardando Envio': 'Aguardando Envio' 
            }
        } else if (valorSelect == 'Pix' || valorSelect == 'Dinheiro') {
            opcoesDisponiveis = {
                'Pago': 'Pago'
            }
        } else if (valorSelect == 'Transferência Bancária') {
            opcoesDisponiveis = {
                '': '',
                'Pago': 'Pago', 
                'Aguardando Pagamento': 'Aguardando Pagamento'
            }
        }
        
        element.empty()

        $.each(opcoesDisponiveis, function(key,value) {
            element.append($("<option></option>")
            .attr("value", value).text(key));
        });
    }

    function listenerNomes () {
        $(".titularCheque").focus( (e) => {
            $(e.target).autocomplete({
                minLength: 0,
                source: titularDoUltimoCheque,
                autoFocus: true,
            });
        })
    }
    
    let titularDoUltimoCheque = [];

    $("#cliente_id").change( (e) => {
        
        let clienteId = $(e.target).val()

        if (clienteId) {
            $.ajax({
                type: 'GET',
                url: '/titularDoUltimoCheque',
                data: {
                    'cliente_id': clienteId
                },
                dataType: 'json',
                beforeSend: () => {
                    swal.showLoading()
                },
                success: (response) => {
                    titularDoUltimoCheque = []
                    swal.close()

                    for (let i in response) {
                        titularDoUltimoCheque.push(response[i].nome_cheque)
                    }
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error(jqXHR)
                    console.error(textStatus)
                    console.error(errorThrown)
                }
            });

            $.ajax({
                type: 'GET',
                url: '/procurarConsignado',
                data: {
                    'cliente_id': clienteId,
                    'representante_id': representanteId
                },
                dataType: 'json',
                beforeSend: () => {
                    swal.showLoading()
                },
                success: (response) => {
                    criarTextoAlertaConsignado(response)
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error(jqXHR)
                    console.error(textStatus)
                    console.error(errorThrown)
                }
            });
        } 
    })

    function criarTextoAlertaConsignado(response) {
        
        if (response.length === 0) {
            $("#consignado").html('')
            return
        }

        let arrayDataConsignado = response[0].data.split('-')
        let dataConsignadoTratada = arrayDataConsignado[2] + '/' + arrayDataConsignado[1] + '/' + arrayDataConsignado[0]

        let html = `
            <div class='alert alert-dark'>
                <h5>Dados do consignado</h5>
                <hr>  
                <p>Data: <b>${dataConsignadoTratada}</b></p>
                <p>Peso: <b>${response[0].peso}</b></p>
                <p>Fator: <b>${response[0].fator}</b></p> 
               
                <div class="form-group">
                    <label for="baixar"><b>Baixar consignado?</b></label>
                    <input type="checkbox" id="baixar" name="baixar" checked value="${response[0].id}">
                </div>
            </div>
        `

        $("#consignado").html(html)
    }

    listenerFormaPagamentoParcela ()

    let moeda = Intl.NumberFormat('en-GB', {
        style: 'currency',
        currency: 'BRL',
    });

    $("#formEnviarVenda").submit( (element) => {
        element.preventDefault();
        
        let valorTotalPago = 0;
        $("input[name^='valor_parcela']").each( (index, element) => {
            valorTotalPago += parseFloat($(element).val())
            // console.log({index, element})
        })

        let valorTotalPedido = parseFloat($("#valor_total").val())
        let form = element.target;

        if (valorTotalPago < valorTotalPedido) {
           
            Swal.fire({
                title: 'Atenção!',
                html: 
                    "O valor pago é <b>menor</b> que o valor do pedido!" + 
                    "<br> Valor total pago: " + moeda.format(valorTotalPago) + 
                    "<br> Valor total do pedido: " + moeda.format(valorTotalPedido) ,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    return
                }
            })
        }
        form.submit();
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/venda/create.blade.php ENDPATH**/ ?>