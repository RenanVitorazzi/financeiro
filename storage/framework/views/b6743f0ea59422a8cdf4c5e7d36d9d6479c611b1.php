
<?php $__env->startSection('title'); ?>
Adicionar conta corrente (representante)
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <?php if(!auth()->user()->is_representante): ?>
        <li class="breadcrumb-item"><a href="<?php echo e(route('representantes.index')); ?>">Representantes</a></li>
        <?php endif; ?>
        <li class="breadcrumb-item"><a href="<?php echo e(route('conta_corrente_representante.show', $representante->id)); ?>">Conta Corrente <?php echo e($representante->pessoa->nome); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
<form method="POST" action="<?php echo e(route('conta_corrente_representante.store')); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-6">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'data','type' => 'date','autofocus' => true,'value' => ''.e(date('Y-m-d')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'data','type' => 'date','autofocus' => true,'value' => ''.e(date('Y-m-d')).'']); ?>Data <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        <div class="col-6 form-group">
            <label for="balanco">Tipo</label>
            <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'balanco','required' => true]); ?>
                <?php $__currentLoopData = $balanco; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value='<?php echo e($tipo); ?>' <?php echo e(old('balanco') == $tipo ? 'selected': ''); ?>> <?php echo e($tipo); ?> </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
        </div>
        
        <input type="hidden" name="representante_id" value=<?php echo e($representante->id); ?>>

        <div class="col-6">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'peso','value' => ''.e(old('peso')).'','type' => 'number','step' => '0.001','min' => '0']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'peso','value' => ''.e(old('peso')).'','type' => 'number','step' => '0.001','min' => '0']); ?>Peso <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>

        <div class="col-6">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'fator','value' => ''.e(old('fator')).'','type' => 'number','step' => '0.001','min' => '0']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'fator','value' => ''.e(old('fator')).'','type' => 'number','step' => '0.001','min' => '0']); ?>Fator <?php echo $__env->renderComponent(); ?>
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
<?php $component->withAttributes(['name' => 'observacao']); ?><?php echo e(old('observacao')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalada24a059c331be0784ec187913c2ecfacd51890)): ?>
<?php $component = $__componentOriginalada24a059c331be0784ec187913c2ecfacd51890; ?>
<?php unset($__componentOriginalada24a059c331be0784ec187913c2ecfacd51890); ?>
<?php endif; ?>
    </div>
    <div class="form-group">
        <label for="anexo">Anexo de Arquivo</label>
        <input type="file" id="anexo" name="anexo[]" class="form-control-file" multiple >
    </div>

    <input type="submit" class='btn btn-success'>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/conta_corrente_representante/create.blade.php ENDPATH**/ ?>