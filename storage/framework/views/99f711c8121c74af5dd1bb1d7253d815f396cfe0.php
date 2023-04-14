
<?php $__env->startSection('title'); ?>
Cadastro de consignado
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('consignado.index')); ?>">Consignados</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
    </ol>
</nav>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

<form method="POST" action="<?php echo e(route('consignado.update', $consignado)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="row">
        <div class="col-4">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'data','type' => 'date','value' => ''.e(old('data', $consignado->data)).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'data','type' => 'date','value' => ''.e(old('data', $consignado->data)).'']); ?>
                Data
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        <div class="col-4">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'peso','value' => ''.e(old('peso', $consignado->peso)).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'peso','value' => ''.e(old('peso', $consignado->peso)).'']); ?>
                Peso
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        <div class="col-4">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'fator','value' => ''.e(old('fator', $consignado->fator)).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'fator','value' => ''.e(old('fator', $consignado->fator)).'']); ?>
                Fator
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        <div class="col-4">
            <label for="representante_id">Representante</label>
            <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'representante_id']); ?>
                <option value=""></option>
                    <?php $__currentLoopData = $representantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $representante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option 
                            value="<?php echo e($representante->id); ?>" 
                            <?php echo e(old('representante_id', $consignado->representante_id) == $representante->id ? 'selected' : ''); ?>

                        >
                            <?php echo e($representante->pessoa->nome); ?>

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
            <label for="cliente_id">Cliente</label>
            <div class="d-flex">
                <select name="cliente_id" 
                    class="<?php echo e($errors->has('cliente_id') ? 'is-invalid form-control' : 'form-control'); ?>"
                    id="cliente_id">
                    <option></option>
                </select>
                <div class="btn btn-dark procurarCliente">
                    <span class="fas fa-search"></span>
                </div>
            </div>
            <?php $__errorArgs = ['cliente_id'];
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
    <input type="submit" class='btn btn-success mt-2'>
</form>
<input type="hidden" value="<?php echo e($consignado->representante_id); ?>" id="old_representante_id">
<input type="hidden" value="<?php echo e($consignado->cliente_id); ?>" id="old_cliente_id">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    $(function() {
        let antigoRepresentanteId =  $("#old_representante_id").val()
        let antigoClienteId = $("#old_cliente_id").val()
        let campoRepresentante = $("#representante_id")

        campoRepresentante.change( (e) => {
            $("#cliente_id").val('')
            $("#cliente_id").empty()
            procurarCliente (e.target.value)
        })

        $(".procurarCliente").click( () => {
            let representante_id = campoRepresentante.val()
            
            if (!representante_id) {
                swal.fire(
                    'Atenção!',
                    'Informe o representante',
                    'warning'
                ).then((result) => {
                    swal.close()
                    campoRepresentante.focus()
                })
                return
            }

            $("#modal2").modal('show')
            
            $("#modal-header2").text(`Procurar cliente`)
            $("#modal-footer2 > .btn-primary").remove()

            $("#modal-body2").html(`
                <form id="formProcurarCliente" method="GET" action="<?php echo e(route('procurarCliente')); ?>">
                    <input type='hidden' value="${representante_id}" name="representante_id">
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

                if (!campoRepresentante.val()) {
                    $("#respostaProcura").html(`<div class="alert alert-danger">Informe o representante</div>`)
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

        function popularOption(response) {
            if (response.length === 0) {
                Swal.fire({
                    title: 'Atenção!',
                    text: 'Nenhum cliente cadastrado para esse representante',
                    icon: 'warning',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                })
                return
            }

            let option = `<option></option>`

            response.forEach( (element, key) => {
                option += `
                    <option value='${element.id}' ${antigoClienteId == element.id ? 'selected': ''}>
                        ${element.pessoa.nome}
                    </option>`
            })

            $("#cliente_id").append(option)
            swal.close()
        }

        if (antigoRepresentanteId) {
            procurarCliente(antigoRepresentanteId)
        }

        function procurarCliente(representante_id) {
            $.ajax({
                type: 'GET',
                url: '<?php echo e(url("procurarCliente")); ?>',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'representante_id': representante_id
                },
                dataType: 'json',
                beforeSend: () => {
                    Swal.showLoading()
                },
                success: (response) => {
                    popularOption(response)
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error(jqXHR)
                    console.error(textStatus)
                    console.error(errorThrown)
                }
            });
        }
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/consignado/edit.blade.php ENDPATH**/ ?>