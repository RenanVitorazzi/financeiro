<form method="POST" action="<?php echo e($attributes['action']); ?>" class="d-inline" onsubmit="confirmarExclusao(event, this)">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <button type="submit" class="btn btn-danger" title="Excluir">
        <span class="fas fa-trash-alt"></span>
    </button>
</form><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/components/botao-excluir.blade.php ENDPATH**/ ?>