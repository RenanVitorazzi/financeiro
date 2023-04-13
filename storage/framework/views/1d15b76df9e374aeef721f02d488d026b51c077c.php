
<?php $__env->startSection('title'); ?>
Adicionar estoque
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('estoque.index')); ?>">Estoque</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
    </ol>
</nav>
<?php if($conta_corrente): ?>
<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title">Lançado no Conta Corrente</h5>
        <div class="row">
            <div class="col-3">
                <label for="balanco">Data</label>
                <input class="form-control" disabled type="date" value="<?php echo e($conta_corrente->data); ?>"></input>
            </div>
            
            <div class="col-3">
                <label for="balanco">Nome</label>
                <input class="form-control" disabled type="text" value="<?php echo e($conta_corrente->nome); ?>"></input>
            </div>
            <div class="col-3">
                <label for="balanco">Peso (g)</label>
                <input class="form-control" disabled type="number" value="<?php echo e($conta_corrente->peso); ?>"></input>
            </div>
            <div class="col-3">
                <label for="balanco">Balanço</label>
                <input class="form-control" disabled type="text" value="<?php echo e($balancoReal); ?>"></input>
            </div>
        </div> 
    </div>
</div>
<?php endif; ?>
<form method="POST" action="<?php echo e(route('estoque.store')); ?>">
    <?php echo csrf_field(); ?>
    <?php if($conta_corrente): ?>
        <input type="hidden" value="<?php echo e($tabela); ?>" name="tabela"></input>
        <input type="hidden" value="<?php echo e($conta_corrente->id); ?>" name="conta_corrente_id"></input>
    <?php endif; ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Cadastrar</h5>
            <div class="row">
                <div class="col-3">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['type' => 'date','name' => 'data','value' => ''.e($conta_corrente->data ?? old('data')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'date','name' => 'data','value' => ''.e($conta_corrente->data ?? old('data')).'']); ?>Data <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <div class="col-3">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['type' => 'number','name' => 'peso','value' => ''.e(old('peso')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'number','name' => 'peso','value' => ''.e(old('peso')).'']); ?>Peso <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <div class="col-3">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['type' => 'text','name' => 'fator','value' => ''.e(old('fator')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','name' => 'fator','value' => ''.e(old('fator')).'']); ?>Fator <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <div class="col-3">
                    <label for="balanco">Balanço</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'balanco','value' => ''.e(old('balanco')).'']); ?>
                        <!-- COMPRA DO FORNECEDOR OU DEVOLUÇÃO ATACADO -->
                        <?php if( ($balancoReal=='Compra' && $tabela == 'conta_corrente') || ($balancoReal=='Devolução' && $tabela == 'conta_corrente_representante')): ?>
                            <option value='Crédito' selected>Crédito (Entrada)</option>
                        <!-- REPOSIÇÃO/COMPRA DO REPRESENTANTE -->
                        <?php elseif( ($balancoReal=='Reposição' && $tabela == 'conta_corrente_representante')): ?>
                            <option value='Débito' selected>Débito (Saída)</option>
                        <?php else: ?>                            
                            <option></option>
                            <option value='Crédito'>Crédito (Entrada)</option>
                            <option value='Débito'>Débito (Saída)</option>
                        <?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>
            </div> 
        </div>
    </div>
    <input type="submit" class='btn btn-success'>
</form>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/estoque/create.blade.php ENDPATH**/ ?>