
<?php $__env->startSection('title'); ?>
<?php echo e($troca->titulo); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('troca_cheques.index')); ?>">Trocas</a></li>
        <li class="breadcrumb-item active"><?php echo e($troca->titulo); ?></li>
    </ol>
</nav>

<div class='mb-2 d-flex justify-content-between'>
    <h3> <?php echo e($troca->titulo); ?> </h3>
    <div>
        <?php if (isset($component)) { $__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BotaoImprimir::class, []); ?>
<?php $component->withName('botao-imprimir'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'mr-2','href' => ''.e(route('pdf_troca', $troca->id)).'']); ?> <?php if (isset($__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5)): ?>
<?php $component = $__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5; ?>
<?php unset($__componentOriginale7af6f5f93c3f23c2bd6667675861a3352692bb5); ?>
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
<?php $component->withAttributes([]); ?>
      <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <tr>
                <th>Data da Troca</th>
                <th>Total Bruto</th>
                <th>Total Juros</th>
                <th>Total Líquido</th>
                <th>Taxa</th>
            </tr>
       <?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
      <tbody>
            <tr>
                <td><b><?php echo date('d/m/Y', strtotime($troca->data_troca)); ?></b></td>
                <td><b><?php echo 'R$ ' . number_format($troca->valor_bruto, 2, ',', '.'); ?></b></td>
                <td><b><?php echo 'R$ ' . number_format($troca->valor_juros, 2, ',', '.'); ?></b></td>
                <td><b><?php echo 'R$ ' . number_format($troca->valor_liquido, 2, ',', '.'); ?></b></td>
                <td><b><?php echo e($troca->taxa_juros); ?>%</b></td>
            </tr>
      </tbody>
 <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<p></p>
<?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, []); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'dataTable']); ?>
    <?php if (isset($component)) { $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\TableHeader::class, []); ?>
<?php $component->withName('table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <tr>
            <th>Nome</th>
            <th>Número</th>
            <th>Data</th>
            <th>Dias</th>
            <th>Valor Bruto</th>
            <th>Juros</th>
            <th>Valor líquido</th>
        </tr>
     <?php if (isset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36)): ?>
<?php $component = $__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36; ?>
<?php unset($__componentOriginalc30ad8c2a191ad4361a1cb232afac54beb39ce36); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    <tbody>
        <?php $__currentLoopData = $troca->cheques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($cheque->parcelas->status === 'Adiado'): ?>
            <tr>
                <td><p><?php echo e($cheque->parcelas->nome_cheque); ?></p></td>
                <td><p><?php echo e($cheque->parcelas->numero_cheque); ?></p></td>
                <td>
                    <s><?php echo date('d/m/Y', strtotime($cheque->parcelas->data_parcela)); ?></s>
                    <p><?php echo date('d/m/Y', strtotime($cheque->parcelas->adiamentos->nova_data)); ?></p>
                </td>
                <td>
                    <s><?php echo e($cheque->dias); ?></s>
                </td>
                <td><p><?php echo 'R$ ' . number_format($cheque->parcelas->valor_parcela, 2, ',', '.'); ?></p></td>
                <td>
                    <p><?php echo 'R$ ' . number_format($cheque->valor_juros, 2, ',', '.'); ?></p>
                </td>
                <td>
                    <p><?php echo 'R$ ' . number_format($cheque->valor_liquido, 2, ',', '.'); ?></p>
                </td>
            </tr>
            <?php else: ?>
            <tr>
                <td><?php echo e($cheque->parcelas->nome_cheque); ?></td>
                <td><p><?php echo e($cheque->parcelas->numero_cheque); ?></p></td>
                <td><?php echo date('d/m/Y', strtotime($cheque->parcelas->data_parcela)); ?></td>
                <td><?php echo e($cheque->dias); ?></td>
                <td><?php echo 'R$ ' . number_format($cheque->parcelas->valor_parcela, 2, ',', '.'); ?></td>
                <td><?php echo 'R$ ' . number_format($cheque->valor_juros, 2, ',', '.'); ?></td>
                <td><?php echo 'R$ ' . number_format($cheque->valor_liquido, 2, ',', '.'); ?></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
 <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
      const TAXA = <?php echo e($troca->taxa_juros); ?>

      const MODAL = $("#modal")
      const MODAL_BODY = $("#modal-body")

      $(".btn-adiar").each( (index, element) => {
            $(element).click( () => {
                  adiarCheque(element)
            })
      });

      function adiarCheque(element) {

            let data = $(element).data()
            let novaData = addDays(data.dia, 15)
            let jurosNovos = calcularNovosJuros(element, 15)
            let jurosAntigos = data.juros
            let jurosTotais = parseFloat(jurosNovos) + parseFloat(jurosAntigos)
            MODAL.modal("show")
            
            $("#modal-title").html("Adiamento")
            
            MODAL_BODY.html(`
                  <form id="formAdiamento"> 
                        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
                        <p>Nome: <b>${data.nome}</b></p>
                        <p>Data: <b>${data.dia}</b></p>
                        <p>Taxa: <b>${TAXA}%</b></p>
                        <p>Juros atuais: <b>R$ ${jurosAntigos}</b></p>
                        <p>Dias adiados: <b><span id="diasAdiados">15</span></b></p>
                        <div class="row">
                              <div class="form-group col-6">
                                    <label for="data">Informe a nova data</label>
                                    <input class="form-control" type="date" value="${novaData}" id="data" name="data">
                              </div>
                              <div class="form-group col-6">
                                    <label for="taxa">Informe a taxa de juros (%)</label>
                                    <input class="form-control" type="number" value="${TAXA}" id="taxa" name="taxa">
                              </div>
                              <div class="form-group col-6">
                                    <label for="juros_adicionais">Adicional de juros</label>
                                    <input class="form-control" readonly type="number" value="${jurosNovos}" id="juros_adicionais" name="juros_adicionais">
                              </div>
                              <div class="form-group col-6">
                                    <label for="juros_novos">Valor total de juros</label>
                                    <input class="form-control" readonly type="number" value="${(jurosTotais).toFixed(2)}" id="juros_novos" name="juros_novos">
                              </div>
                              
                        </div>
                        <div class="form-group">
                              <label for="observacao">Observação</label>
                              <textarea class="form-control" name="observacao" id="observacao"></textarea>
                        </div>
                  </form>
            `)

            $("#taxa, #data").change( () => {
                  let dataNova = $("#data").val()
                  let diferencaDias = calcularDiferencaDias(data.dia, dataNova)

                  let jurosNovos = calcularNovosJuros(element, diferencaDias)
                  let jurosAntigos = data.juros
                  let jurosTotais = parseFloat(jurosNovos) + parseFloat(jurosAntigos)

                  $("#diasAdiados").html(diferencaDias)
                  $("#juros_adicionais").val(jurosNovos)
                  $("#juros_novos").val((jurosTotais).toFixed(2))
            })

            $(".modal-footer > .btn-primary").one('click', () => {
                  let dataForm = $("#formAdiamento").serialize() 
                        + "&data_cheque=" + data.dia 
                        + "&cheque_id=" + data.id
                        + "&troca_parcela_id=" + data.troca_parcela_id

                  $.ajax({
                        type: 'POST',
                        headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: $('#formAdiamento').attr('action'),
                        data: dataForm,
                        dataType: 'json',
                        beforeSend: () => {
                              swal.showLoading()
                        },
                        success: (response) => {
                              console.log(response);
                              Swal.fire({
                                    title: response.title,
                                    icon: response.icon,
                                    text: response.text
                              })
                              
                              MODAL.modal("hide")
                        },
                        error: (jqXHR, textStatus, errorThrown) => {
                
                              var response = JSON.parse(jqXHR.responseText)
                              var errorString = ''
                              $.each( response.errors, function( key, value) {
                                    errorString += '<div>' + value + '</div>'
                              });
                        
                              Swal.fire({
                                    title: 'Erro',
                                    icon: 'error',
                                    html: errorString
                              })
                        }
                  });
            })
      }

      function addDays (date, days) {
            var result = new Date(date)
            result.setDate(result.getDate() + days)
            return result.toISOString().slice(0,10)
      }

      function calcularNovosJuros (element, dias) {
            let taxa = $("#taxa").val();
            let valor_cheque = $(element).data("valor")
            let porcentagem = taxa / 100 || TAXA / 100 ;
            
            return ( ( (valor_cheque * porcentagem) / 30 ) * dias).toFixed(2)
      }

      function calcularDiferencaDias (dataAntiga, dataNova) {
            let date1 = new Date(dataAntiga)
            let date2 = new Date(dataNova)
            if (date1.getTime() > date2.getTime()) {
                  Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'A data de adiamento deve ser maior que a data do cheque!'
                  })
            }
            
            const diffTime = Math.abs(date2 - date1)
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24))
      }

    $(".form-resgate").submit( (e) => {
        e.preventDefault()
        console.log($(e.target));
        Swal.fire({
            title: 'Tem certeza de que deseja resgatar esse cheque?',
            icon: 'warning',
            showConfirmButton: true,
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                $(e.target)[0].submit()
            }
        })
    })
    
    $(document).ready( function () {
        $("#dataTable").DataTable({
            "order": [['3', 'asc'],['5','asc']]
        });
    } );
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BKP Asus\Usuário\Desktop\DL financeiro\DL-financeiro\resources\views/troca_cheque/show.blade.php ENDPATH**/ ?>