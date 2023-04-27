<?php $__env->startSection('title'); ?>
Adicionar recebimento
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<style>
    .info-cheque-selecionado {
        display: none;
    }
</style>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('recebimentos.index')); ?>">Recebimentos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastrar</li>
    </ol>
</nav>

<form method="POST" action="<?php echo e(route('recebimentos.store')); ?>">
    <?php echo csrf_field(); ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Cadastrar</h5>

            <div class="btn btn-dark informar_parcela">Relacionar o pagamento à um cheque ou parcela</div>

            <div>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['readonly' => true,'type' => 'date','name' => 'data_parcela','value' => ''.e(old('data_parcela')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'type' => 'date','name' => 'data_parcela','value' => ''.e(old('data_parcela')).'']); ?>Data do cheque <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div class="col-4">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['readonly' => true,'type' => 'text','name' => 'nome_parcela','value' => ''.e(old('nome_parcela')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'type' => 'text','name' => 'nome_parcela','value' => ''.e(old('nome_parcela')).'']); ?>Titular do cheque <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div class="col-4">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['readonly' => true,'type' => 'number','name' => 'valor_parcela','value' => ''.e(old('valor_parcela')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'type' => 'number','name' => 'valor_parcela','value' => ''.e(old('valor_parcela')).'']); ?>Valor do cheque <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div class="col-4">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['readonly' => true,'type' => 'number','name' => 'parcela_id','value' => ''.e(old('parcela_id')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'type' => 'number','name' => 'parcela_id','value' => ''.e(old('parcela_id')).'']); ?>Código do cheque <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div class="col-4 form-group">
                        <label for="representante_id">Representante</label>
                        <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'name' => 'representante_id']); ?>
                            <option></option>
                            <?php $__currentLoopData = $representantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $representante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($representante->id); ?>" <?php echo e(old('representante_id') == $representante->id ? 'selected' : ''); ?> >
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
                        <label for="parceiro_id">Parceiro</label>
                        <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'name' => 'parceiro_id']); ?>
                            <option value="">Carteira</option>
                            <?php $__currentLoopData = $parceiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parceiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($parceiro->id); ?>" <?php echo e(old('parceiro_id') == $parceiro->id ? 'selected' : ''); ?> >
                                    <?php echo e($parceiro->pessoa->nome); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                    </div>
                </div>
                <hr>
            </div>
            <p></p>
            <div id='pagamentosParcela'></div>
            <p></p>
            <div class="row">
                <div class="col-4">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['type' => 'date','name' => 'data','value' => ''.e(old('data', $data) ?? date('Y-m-d')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'date','name' => 'data','value' => ''.e(old('data', $data) ?? date('Y-m-d')).'']); ?>Data <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <div class="col-4">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['name' => 'valor','value' => ''.e(old('valor', $valor)).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'valor','value' => ''.e(old('valor', $valor)).'']); ?>Valor <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>

                <div class="col-4 form-group">
                    <label for="conta_id">Conta</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'conta_id']); ?>
                        <option></option>
                        <?php $__currentLoopData = $contas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value=<?php echo e($conta->id); ?> <?php echo e(old('conta_id', $contaImportacao) == $conta->id ? 'selected' : ''); ?>><?php echo e($conta->nome); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <option value="999">Conta de Parceiro</option>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>
                <div class="col-4 form-group">
                    <label for="forma_pagamento">Forma de Pagamento</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'forma_pagamento','value' => ''.e(old('forma_pagamento')).'']); ?>
                        <option></option>
                        <option value='Pix' <?php echo e(old('forma_pagamento') == 'PIX' ? 'selected' : ''); ?> > PIX </option>
                        <option value='TED' <?php echo e(old('forma_pagamento') == 'TED' ? 'selected' : ''); ?> > TED </option>
                        <option value='Depósito' <?php echo e(old('forma_pagamento') == 'Depósito' ? 'selected' : ''); ?> > Depósito </option>
                        <option value='DOC' <?php echo e(old('forma_pagamento') == 'DOC' ? 'selected' : ''); ?> > DOC </option>
                        <option value='Dinheiro' <?php echo e(old('forma_pagamento') == 'Dinheiro' ? 'selected' : ''); ?> > Dinheiro </option>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>
                <div class="col-4 form-group">
                    <label for="confirmado">Pagamento Confirmado?</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'confirmado']); ?>
                        <option></option>
                        <option value=1 <?php echo e(old('confirmado') == 'Sim' ? 'selected' : ''); ?> > Sim </option>
                        <option value=0 <?php echo e(old('confirmado') == 'Não' ? 'selected' : ''); ?> > Não </option>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>
                <div class="col-4 form-group">
                    <label for="tipo_pagamento">Pagamento</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'tipo_pagamento','value' => ''.e(old('tipo_pagamento')).'']); ?>
                        <option></option>
                        <option value=2 <?php echo e(old('tipo_pagamento') == '2' ? 'selected' : ''); ?> > Cliente para a empresa </option>
                        <option value=1 <?php echo e(old('tipo_pagamento') == '1' ? 'selected' : ''); ?> > Empresa para o parceiro </option>
                        <option value=3 <?php echo e(old('tipo_pagamento') == '3' ? 'selected' : ''); ?> > Cliente para o parceiro </option>
                        <option value=4 <?php echo e(old('tipo_pagamento') == '4' ? 'selected' : ''); ?> > Cliente para outro parceiro </option>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>
                <div class="col-12">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form-group','data' => ['type' => 'text','name' => 'comprovante_id','value' => ''.e(old('comprovante_id')).'']]); ?>
<?php $component->withName('form-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','name' => 'comprovante_id','value' => ''.e(old('comprovante_id')).'']); ?>Comprovante ID <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
                <!-- <div class="col-4 form-group">
                    <label for="parceiro_id">Parceiro</label>
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'parceiro_id','value' => ''.e(old('parceiro_id')).'']); ?>
                        <option></option>
                        <?php $__currentLoopData = $parceiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parceiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value=<?php echo e($parceiro->id); ?>> <?php echo e($parceiro->pessoa->nome); ?> </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div> -->
                <div class="col-12 form-group">
                    <label for="observacao">Observação</label>
                    <?php if (isset($component)) { $__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TextArea::class, []); ?>
<?php $component->withName('text-area'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'observacao','type' => 'text','value' => ''.e(old('observacao')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405)): ?>
<?php $component = $__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405; ?>
<?php unset($__componentOriginal3d2c91b5536e3d54aed1822705c324a24f801405); ?>
<?php endif; ?>
                </div>
                <!-- <div class="col-12 form-group">
                    <label for="anexo">Anexo de Arquivo</label>
                    <input type="file" id="anexo" name="anexo[]" class="form-control-file">
                </div>
                 -->
            </div>
        </div>
    </div>

    <input type="submit" class='btn btn-success'>
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    $("#modal-body2").html(`
        <form id="form_procura_cheque" method="POST" action="<?php echo e(route('consulta_parcela_pagamento')); ?>">
            <?php echo csrf_field(); ?>

            <div class="row">
                <div class="col-3 form-group">
                    <?php if (isset($component)) { $__componentOriginal9664ac210be45add4be058f3177c16028511e71a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Select::class, []); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'tipo_select','type' => 'number','value' => ''.e(old('tipo_select')).'']); ?>
                        <option value="valor_parcela">Valor</option>
                        <option value="numero_cheque">Número</option>
                        <option value="nome_cheque">Titular</option>
                        <option value="data_parcela">Data</option>
                        <option value="representante_id">Representante</option>
                        <option value="status">Status</option>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a)): ?>
<?php $component = $__componentOriginal9664ac210be45add4be058f3177c16028511e71a; ?>
<?php unset($__componentOriginal9664ac210be45add4be058f3177c16028511e71a); ?>
<?php endif; ?>
                </div>

                <div class="col-7 form-group">
                    <?php if (isset($component)) { $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input::class, []); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'texto_pesquisa']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7)): ?>
<?php $component = $__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7; ?>
<?php unset($__componentOriginal11c02d5af8eef3b9ca8b54c54983d5cb581e68d7); ?>
<?php endif; ?>
                </div>
                <div class="col-2 form-group">
                    <input type="submit" class='btn btn-dark'>
                </div>
            </div>

        </form>
        <div id="table_div"></div>
    `)

    $("#form_procura_cheque").submit( (e) => {

        e.preventDefault()
        let dataForm = $(e.target).serialize()

        $.ajax({
            type: 'GET',
            url: e.target.action,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: dataForm,
            dataType: 'json',
            beforeSend: () => {
                Swal.showLoading()
            },
            success: (response) => {
                let tableBody = ''
                if (response.length > 0) {

                    response.forEach(element => {

                        let nome = element.nome_cheque ?? element.venda.cliente.pessoa.nome
                        let representante = ''
                        let parceiro = 'Carteira'

                        if (element.representante_id) {
                            representante = element.representante.pessoa.nome
                        }

                        if (element.parceiro_id) {
                            parceiro = element.parceiro.pessoa.nome
                        }

                        tableBody += `
                            <tr>
                                <td>${nome}</td>
                                <td>${transformaData(element.data_parcela)}</td>
                                <td>${moeda.format(element.valor_parcela)}</td>
                                <td>${representante}</td>
                                <td>${parceiro}</td>
                                <td>${element.forma_pagamento} ${element.numero_cheque}</td>
                                <td>
                                    <div class="btn btn-dark btn-selecionar-cheque"
                                        data-id="${element.id}"
                                        data-dia="${element.data_parcela}"
                                        data-valor="${element.valor_parcela}"
                                        data-nome="${nome}"
                                        data-parceiro_id="${element.parceiro_id}"
                                        data-representante_id="${element.representante_id}"
                                    > Selecionar </div>
                                </td>
                            </tr>
                        `
                    })

                } else {
                    tableBody += `
                        <tr>
                            <td colspan=7>Nenhum resultado</td>
                        </tr>
                    `
                }

                $(".modal-body > #table_div").html(`
                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                            <tr>
                                <th colspan=10>Número total de resultado: ${response.length}</th>
                            </tr>
                            <tr>
                                <th>Titular</th>
                                <th>Data</th>
                                <th>Valor</th>
                                <th>Representante</th>
                                <th>Parceiro</th>
                                <th>Pgto</th>
                                <th><i class="fas fa-check"></i></th>
                            </tr>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?>
                        <tbody>
                            ${tableBody}
                        </tbody>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
                `)

                $(".btn-selecionar-cheque").each( (index, element) => {
                    $(element).click( (e) => {
                        $("#nome_parcela").val($(e.target).data('nome'))
                        $("#valor_parcela").val($(e.target).data('valor'))
                        $("#valor").val($(e.target).data('valor'))
                        $("#data_parcela").val($(e.target).data('dia'))
                        $("#parcela_id").val($(e.target).data('id'))
                        $("#representante_id").val($(e.target).data('representante_id'))
                        $("#parceiro_id").val($(e.target).data('parceiro_id'))

                        $("#modal2").modal("hide")

                        let pagamentos = procurarPagamentos($(e.target).data('id'))
                    })

                })

                Swal.close()

            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error(jqXHR)
                console.error(textStatus)
                console.error(errorThrown)
            }
        });

    })

    $('.informar_parcela').click( () => {
        $("#modal2").modal('show')
        $("#modal-header2").text(`Procurar Cheque`)

    })

    function procurarPagamentos(parcela_id) {
        let tableBodyPagamentos = '';
        let totalPago = 0;

        $.ajax({
            type: 'GET',
            url: '/procurar_pagamento',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'parcela_id': parcela_id
            },
            dataType: 'json',
            beforeSend: () => {
                Swal.showLoading()
            },
            success: (response) => {

                response.forEach(element => {
                    let valorTratado = parseFloat(element.valor)

                    tableBodyPagamentos += `
                        <tr class = ${element.confirmado ? '' : 'table-danger'}>
                            <td>${transformaData(element.data)}</td>
                            <td>${moeda.format(valorTratado)}</td>
                            <td>${element.conta.nome}</td>
                            <td>${element.forma_pagamento}</td>
                            <td>${element.confirmado ? 'Sim' : 'Não'}</td>
                        <tr>
                    `
                    totalPago += valorTratado;
                })

                $("#pagamentosParcela").html(`
                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                            <tr>
                                <th>Data</th>
                                <th>Conta</th>
                                <th>Forma do Pagamento</th>
                                <th>Valor</th>
                                <th>Confirmado?</th>
                            </tr>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?>
                        <tbody>
                            ${tableBodyPagamentos}
                        </tbody>
                        <t-foot>
                            <tr>
                                <td colspan=3>Total pago</td>
                                <td colspan=2>${moeda.format(totalPago)}</td>
                            </tr>
                        </t-foot>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
                `)

                Swal.close()
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error(jqXHR)
                console.error(textStatus)
                console.error(errorThrown)
            }
        });
    }

    let moeda = Intl.NumberFormat('en-GB', {
        style: 'currency',
        currency: 'BRL',
    });

    function transformaData (data) {
        var parts = data.split("-");
        return parts[2]+'/'+parts[1]+'/'+parts[0];
    }

    function carteiraOuParceiro (id, nome) {
        if (id === null) {
            return 'CARTEIRA'
        }

        return nome
    }

    function tratarNulo (valor) {
        if (valor === null) {
            return '';
        }
        return valor
    }

    $("#tipo_pagamento").change( (e) => {
        let valor = $(e.target).val()
        if (valor === 2) {
            $("#parceiro_id").fadeIn();
        }
        console.log($(e.target).val());
    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/recebimento/create.blade.php ENDPATH**/ ?>