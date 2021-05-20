@extends('layout')
@section('title')
Troca de cheques {{ $troca->parceiro->pessoa->nome }} - {{ date('d/m/Y', strtotime($troca->data_troca) ) }}
@endsection
@section('body')
<h1>
      {{$troca->parceiro->pessoa->nome}} - {{date("d/m/Y", strtotime($troca->data_troca))}}
</h1>
<x-table>
      <x-table-header>
            <tr>
                  <th>Total Bruto</th>
                  <th>Total Juros</th>
                  <th>Total Líquido</th>
                  <th>Taxa</th>
            </tr>
      </x-table-header>
      <tbody>
            <tr>
                  <td><b>R$ {{ number_format($troca->valor_bruto, 2, ',', '.') }}</b></td>
                  <td><b>R$ {{ number_format($troca->valor_juros, 2, ',', '.') }}</b></td>
                  <td><b>R$ {{ number_format($troca->valor_liquido, 2, ',', '.') }}</b></td>
                  <td><b>{{ $troca->parceiro->porcentagem_padrao }}%</b></td>
            </tr>
      </tbody>
</x-table>
<p></p>
<x-table>
      <x-table-header>
            <tr>
                  <th>Nome</th>
                  <th>Data</th>
                  <th>Dias</th>
                  <th>Valor</th>
                  <th>Juros</th>
                  <th>Valor líquido</th>
                  <th>Ações</th>
            </tr>
      </x-table-header>
      <tbody>
            @foreach ($troca->cheques as $cheque)
            <tr>
                  <td>{{ $cheque->parcelas->first()->venda->cliente->pessoa->nome }}</td>
                  <td>{{ date("d/m/Y", strtotime($cheque->parcelas->first()->data_parcela)) }}</td>
                  <td>{{ $cheque->dias }}</td>
                  <td>R$ {{ number_format($cheque->parcelas->first()->valor_parcela, 2) }}</td>
                  <td>R$ {{ number_format($cheque->valor_juros, 2) }}</td>
                  <td>R$ {{ number_format($cheque->valor_liquido, 2) }}</td>
                  <td>
                        <div class="btn btn-warning btn-adiar" 
                              data-id="{{ $cheque->parcela_id }}" 
                              data-dia="{{ $cheque->parcelas->first()->data_parcela }}" 
                              data-valor="{{ $cheque->parcelas->first()->valor_parcela }}" 
                              data-juros="{{$cheque->valor_juros}}" 
                              data-nome="{{ $cheque->parcelas->first()->venda->cliente->pessoa->nome }}" data-troca_parcela_id="{{ $cheque->id }}"
                        > Adiar <i class="far fa-clock"></i> </div>      
                        <div class="btn btn-primary btn-resgatar">Resgatar</div>      
                  </td>
            </tr>
            @endforeach
      </tbody>
</x-table>
@endsection
@section('script')
<script>
      const TAXA = {{ $troca->parceiro->porcentagem_padrao }}
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
            let jurosAntigos = (data.juros).toFixed(2)
            let jurosTotais = parseFloat(jurosNovos) + parseFloat(jurosAntigos)
            MODAL.modal("show")
            
            $("#modal-title").html("Adiamento")
            
            MODAL_BODY.html(`
                  <form id="formAdiamento" action="{{ route('adiarCheque') }}"> 
                        <meta name="csrf-token" content="{{ csrf_token() }}">
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
                  let jurosAntigos = (data.juros).toFixed(2)
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

      $(".btn-resgatar").each( (index, element) => {
            // console.log(element);
            $(element).click( () => {
                  resgatar()
            })
      })
      
      function resgatar() {
            Swal.fire({
                  title: 'Tem certeza de que deseja resgatar esse cheque?',
                  icon: 'info',
                  showConfirmButton: true,
                  showCancelButton: true
            }).then((result) => {
                  if (result.isConfirmed) {
                        $.ajax({
                              type: 'POST',
                              headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              },
                              dataType: 'json',
                              url: "{{ route('resgatarCheque') }}",
                              data: {
                                    parcela_id : 15
                              },
                              beforeSend: () => {
                                    swal.showLoading()
                              },
                              success: (response) => {
                                    console.log(response);
                                    Swal.fire('Resgatado!', '', 'success')
                              },
                              error: (jqXHR, textStatus, errorThrown) => {
                                    console.error(jqXHR.responseText)
                              }
                        });
                  }
            })
     }
</script>
@endsection