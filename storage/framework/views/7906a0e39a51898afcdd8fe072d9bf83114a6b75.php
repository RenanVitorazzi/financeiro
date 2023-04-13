

<?php $__env->startSection('title'); ?>
Vendas - <?php echo e($representante->pessoa->nome); ?> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <?php if(!auth()->user()->is_representante): ?>
        <li class="breadcrumb-item"><a href="<?php echo e(route('representantes.index')); ?>">Representantes</a></li>    
        <?php endif; ?>
        <li class="breadcrumb-item active" aria-current="page">Vendas</li>
    </ol>
</nav>
<div class='mb-2 d-flex justify-content-between'>
    <h3>Vendas - <?php echo e($representante->pessoa->nome); ?></h3> 
    <div> 
        <?php if (isset($component)) { $__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoImprimir::class, []); ?>
<?php $component->withName('botao-imprimir'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'mr-2','href' => ''.e(route('pdf_conferencia_relatorio_vendas', ['representante_id' => $representante->id])).'']); ?> <?php if (isset($__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5)): ?>
<?php $component = $__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5; ?>
<?php unset($__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoNovo::class, []); ?>
<?php $component->withName('botao-novo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['href' => ''.e(route('venda.create', ['id' => $representante->id])).'']); ?> <?php if (isset($__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd)): ?>
<?php $component = $__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd; ?>
<?php unset($__componentOriginale4c265d4ffee8fab925ff5f69279324cd3ba69cd); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    </div>
</div>
<?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'tableVendas']); ?>
    <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <th>
            <input type="checkbox" id="checkAll">
        </th>
        <th>Data</th>
        <th>Cliente</th>
        <th>Peso</th>
        <th>Fator</th>
        <th>Valor</th>
        <th>Pagamento</th>
        <th>Ações</th>
     <?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $vendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><input type="checkbox" name="id_venda[]" value="<?php echo e($venda->id); ?>"></td>
            <td><?php echo date('d/m/Y', strtotime($venda->data_venda)); ?></td>
            <td><?php echo e($venda->cliente->pessoa->nome); ?></td>
            <td><?php echo number_format($venda->peso, 2, ',', '.'); ?></td>
            <td><?php echo number_format($venda->fator, 1, ',', '.'); ?></td>
            <td><?php echo 'R$ ' . number_format($venda->valor_total, 2, ',', '.'); ?></td>
            <td>
                <b><?php echo e($venda->metodo_pagamento); ?></b>
                <?php $__currentLoopData = $venda->parcela; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parcela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <br>
                <small class="text-muted">
                    <?php echo date('d/m/Y', strtotime($parcela->data_parcela)); ?> - <?php echo 'R$ ' . number_format($parcela->valor_parcela, 2, ',', '.'); ?> (<?php echo e($parcela->status); ?>)
                </small> 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </td>
            <td>
                <?php if (isset($component)) { $__componentOriginal13702a75d66702067dad623af293364e28e151a7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoEditar::class, []); ?>
<?php $component->withName('botao-editar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['href' => ''.e(route("venda.edit", $venda->id)).'']); ?> <?php if (isset($__componentOriginal13702a75d66702067dad623af293364e28e151a7)): ?>
<?php $component = $__componentOriginal13702a75d66702067dad623af293364e28e151a7; ?>
<?php unset($__componentOriginal13702a75d66702067dad623af293364e28e151a7); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoExcluir::class, []); ?>
<?php $component->withName('botao-excluir'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['action' => ''.e(route("venda.destroy", $venda->id)).'']); ?> <?php if (isset($__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247)): ?>
<?php $component = $__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247; ?>
<?php unset($__componentOriginalc7dfdfe339a23ddfcb22882c80952c28748ef247); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
            </td>
        </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="8" class="table-danger">Nenhum registro criado</td>
        </tr>
        <?php endif; ?>
    </tbody>
 <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<div id="enviarCC" class="btn btn-dark">
    Enviar para o conta corrente
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    <?php if(Session::has('message')): ?>
        toastr["success"]("<?php echo e(Session::get('message')); ?>")
    <?php endif; ?>
    
    $("#checkAll").click( (e) => {
        let state = $(e.target).prop('checked');
        $("input[name='id_venda[]']").each(function (index,element) {
            $( element ).prop( "checked", state );
        })
    })

    $("#enviarCC").click( (e) => {
        if ($("input:checked[name='id_venda[]']").length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Informe pelo menos uma venda!'
            })
            return
        }

        Swal.fire({
            title: 'Tem certeza de que deseja criar um novo registro no conta corrente?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#343a40',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Enviar'
        }).then((result) => {
            if (result.isConfirmed) {
                enviarCC()
            }
        })
    }) 
    function enviarCC() {
        let arrayId = [];
        
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        
        $("input[name='id_venda[]']:checked").each(function (index,element) {
            arrayId.push( $( element ).val() );
        })

        console.log(arrayId)
        
        $.ajax({
            method: "POST",
            url: "<?php echo e(route('enviar_conta_corrente')); ?>",
            data: { 
                vendas_id: arrayId, 
                _token: CSRF_TOKEN 
            },
            dataType: 'json'
        }).done( (response) => {
            console.log(response)    
            Swal.fire({
                title: 'Sucesso!',          
                icon: 'success'
            }).then((result) => {
                window.location.href = response.route;
            })

        }).fail( (jqXHR, textStatus, errorThrown) => {
            console.error({jqXHR, textStatus, errorThrown})

            Swal.fire(
                'Erro!',
                '' + errorThrown,
                'error'
            )
        })
    }

    $(document).ready( function () {
        $('#tableVendas').DataTable({});
    } );
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/venda/show.blade.php ENDPATH**/ ?>