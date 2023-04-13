
<?php $__env->startSection('title'); ?>
Editar conta
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?> 
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('fornecedores.index')); ?>">Fornecedores</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('fornecedores.show', $contaCorrente->fornecedor_id)); ?>">Conta Corrente</a></li>
        <li class="breadcrumb-item active" aria-current="page">Adicionar</li>
    </ol>
</nav>
<h3>Editar Conta Corrente</h3>
<form method="POST" action="<?php echo e(route('conta_corrente.update', $contaCorrente->id)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <input name="fornecedor_id" type="hidden" value="<?php echo e($contaCorrente->fornecedor_id); ?>" >

    <div class="row">
        <div class="col-4">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'data','type' => 'date','value' => ''.e($contaCorrente->data).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'data','type' => 'date','value' => ''.e($contaCorrente->data).'']); ?>Data <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        <div class="col-4 form-group">
            <label for="balanco">Balanço</label>
            <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'balanco','id' => 'balanco','class' => 'form-control','autofocus' => true,'required' => true]); ?>
                <option value='Débito' <?php echo e($contaCorrente->balanco == 'Débito' ? 'selected' : ''); ?>> Compra (Débito)</option>
                <option value='Crédito' <?php echo e($contaCorrente->balanco == 'Crédito' ? 'selected' : ''); ?>> Fechamento (Crédito)</option>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
        </div>
        <div class="col-4" id="group-peso">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'peso','type' => 'number','step' => '0.001','min' => '0','value' => ''.e($contaCorrente->peso).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'peso','type' => 'number','step' => '0.001','min' => '0','value' => ''.e($contaCorrente->peso).'']); ?>Peso (g) <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        
        <div class="col-4" id="group-cotacao" <?php echo e($contaCorrente->balanco == 'Débito' ? 'style="display:none"' : ''); ?>>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'cotacao','type' => 'number','step' => '0.01','min' => '0','value' => ''.e($contaCorrente->cotacao).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'cotacao','type' => 'number','step' => '0.01','min' => '0','value' => ''.e($contaCorrente->cotacao).'']); ?>Cotação do dia (R$) <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        <div class="col-4" id="group-valor" <?php echo e($contaCorrente->balanco == 'Débito' ? 'style="display:none"' : ''); ?>>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'valor','type' => 'number','step' => '0.01','min' => '0','value' => ''.e($contaCorrente->valor).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'valor','type' => 'number','step' => '0.01','min' => '0','value' => ''.e($contaCorrente->valor).'']); ?>Valor (R$) <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        
    </div> 
    <div class="form-group">
        <label for="observacao">Observação</label>
        <?php if (isset($component)) { $__componentOriginalada24a059c331be0784ec187913c2ecfacd51890 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Textarea::class, []); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'observacao','class' => 'form-control']); ?><?php echo e($contaCorrente->observacao); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalada24a059c331be0784ec187913c2ecfacd51890)): ?>
<?php $component = $__componentOriginalada24a059c331be0784ec187913c2ecfacd51890; ?>
<?php unset($__componentOriginalada24a059c331be0784ec187913c2ecfacd51890); ?>
<?php endif; ?>
    </div>
        
    <input type="submit" class='btn btn-success'>
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    $("#cotacao, #valor").change( () => {
        let cotacao = parseFloat($("#cotacao").val());
        let valor = parseFloat($("#valor").val());

        if (!cotacao || !valor) {
            return false;
        }

        let peso = valor/cotacao;
        $("#peso").val(peso.toFixed(2));
    })

    $("#balanco").change( (e) => {
        $("#group-cotacao").toggle()
        $("#group-valor").toggle()
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/contaCorrente/edit.blade.php ENDPATH**/ ?>