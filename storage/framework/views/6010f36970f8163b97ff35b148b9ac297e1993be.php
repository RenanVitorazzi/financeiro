
<input <?php echo e($attributes->merge(([
    'class' => $errors->has($attributes['name']) ? 'is-invalid form-control' : 'form-control' , 
    'type' => 'text', 
    'id' => $attributes['name']
]))); ?>>

<?php $__errorArgs = [$attributes['name']];
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
unset($__errorArgs, $__bag); ?><?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/components/input.blade.php ENDPATH**/ ?>