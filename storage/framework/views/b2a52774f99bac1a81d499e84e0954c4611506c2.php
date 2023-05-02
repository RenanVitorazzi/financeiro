
<?php $__env->startSection('title'); ?>
Editar Troca
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('troca_cheques.index')); ?>">Troca de cheques</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e($troca->titulo); ?></li>
    </ol>
</nav>
    <div class="container">
        <div class="d-flex justify-content-between">
            <h3>Trocar cheques</h3>
        </div>
        <form action="<?php echo e(route('troca_cheques.update', $troca->id)); ?>" method="POST" id="formTrocaCheques">
            
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="row">
                <div class="form-group col-6">
                    <label for="titulo">Título</label>
                    <?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'titulo','value' => ''.e($troca->titulo).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?>
                </div>
                <div class="col-6">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['type' => 'date','name' => 'data_troca','value' => ''.e($troca->data_troca).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'date','name' => 'data_troca','value' => ''.e($troca->data_troca).'']); ?>Data da troca <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
            </div>            

            <div class="row">
                
                <div class="col-6">
                    <label for="parceiro_id">Parceiro</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'parceiro_id']); ?>
                        <option value=""></option>
                        <?php $__currentLoopData = $parceiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parceiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option data-porcentagem="<?php echo e($parceiro->porcentagem_padrao); ?>" value="<?php echo e($parceiro->id); ?> "
                                <?php echo e($parceiro->id == $troca->parceiro_id ? 'selected' : ''); ?>

                            > 
                                <?php echo e($parceiro->pessoa->nome); ?> (<?php echo e($parceiro->porcentagem_padrao); ?>%)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>
                
                <div class="form-group col-6">
                    <label for="taxa_juros">Taxa (%)</label>
                    <?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'taxa_juros','type' => 'number','value' => ''.e($troca->taxa_juros).'','max' => '100','step' => '0.01']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?>
                </div>

                <div class="form-group col-12">
                    <label for="observacao">Observação</label>
                    <?php if (isset($component)) { $__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TextArea::class, []); ?>
<?php $component->withName('text-area'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'observacao']); ?><?php echo e(old('observacao')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405)): ?>
<?php $component = $__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405; ?>
<?php unset($__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405); ?>
<?php endif; ?>
                </div>
                
            </div>
           
            <input class="btn btn-success" type="submit">
            
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    $("#parceiro_id").change( (e) => {
        let porcentagem_troca = $(e.target).find('option:selected').data("porcentagem") 
        console.log(porcentagem_troca);
        $("#taxa_juros").val(porcentagem_troca)
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/troca_cheque/edit.blade.php ENDPATH**/ ?>