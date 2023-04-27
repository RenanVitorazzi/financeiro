
<?php $__env->startSection('title'); ?>
Entrega de cheques
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Entrega de cheques</li>
        
    </ol>
</nav>
<div class='d-flex justify-content-between'>

    <a class='btn btn-block btn-dark m-2' id='entrega_representante' >
        <p></p>
        <h3>Entregar cheques para representantes </h3>
        <p></p>
    </a>
    <a class='btn btn-block btn-dark m-2' id='receber_parceiro'>
        <p></p>
        <h3>Receber cheques dos parceiros </h3>
        <p></p>
    </a>
   
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    const REPRESENTANTES = <?php echo json_encode($representantes, 15, 512) ?>;
    const PARCEIROS = <?php echo json_encode($parceiros, 15, 512) ?>;

    let opRepresentante = '';
    REPRESENTANTES.forEach(element => {
        opRepresentante += `<option value='${element.id}'>${element.pessoa.nome}</option>`
    });

    let opParceiro = '';
    PARCEIROS.forEach(element => {
        opParceiro += `<option value='${element.id}'>${element.pessoa.nome}</option>`
    });

    $("#entrega_representante").click( () => {
        $("#modal2").modal('show')
        $("#modal-header2").text('Escolha o representante')
        $("#modal-body2").html(`
            <div class='row'>
                <div class="col-12 form-group">
                    <label for="representante_id">Representante</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'representante_id','data-tipo' => 'representante']); ?>
                        <option></option>
                        ${opRepresentante}
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>
            </div>
            <div id='btnEscolha'></div>
        `)
        trocaPessoa()
    })

    $("#receber_parceiro").click( () => {
        $("#modal2").modal('show')
        $("#modal-header2").text('Escolha o parceiro')
        $("#modal-body2").html(`
            <div class='row'>
                <div class="col-12 form-group">
                    <label for="parceiro_id">Parceiro</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'parceiro_id','data-tipo' => 'parceiro']); ?>
                        <option></option>
                        ${opParceiro}
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>
            </div>
            <div id='btnEscolha'></div>
        `)
        trocaPessoa()
    })

    function trocaPessoa () {
        $("#parceiro_id, #representante_id").change( (e) => {
            let element = $(e.target)

            let route = (element.data('tipo') == 'parceiro') ? 'receber_parceiro' : 'entrega_representante'

            $('#btnEscolha').html(`<a class='btn btn-block btn-dark' href='/entrega_parcela/${route}/${element.val()}'>Lançar</a>`)

        })
    }
    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/entrega_parcela/index.blade.php ENDPATH**/ ?>