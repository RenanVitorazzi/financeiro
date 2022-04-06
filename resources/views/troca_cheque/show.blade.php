@extends('layout')
@section('title')
{{ $troca->titulo }}
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('troca_cheques.index') }}">Trocas</a></li>
        <li class="breadcrumb-item active">{{ $troca->titulo }}</li>
    </ol>
</nav>

<div class='mb-2 d-flex justify-content-between'>
    <h3> {{ $troca->titulo }} </h3>
    <div>
        <x-botao-imprimir class="mr-2" href="{{ route('pdf_troca', $troca->id) }}"></x-botao-imprimir>
    </div>
</div>

<x-table>
      <x-table-header>
            <tr>
                <th>Data da Troca</th>
                <th>Total Bruto</th>
                <th>Total Juros</th>
                <th>Total Líquido</th>
                <th>Taxa</th>
            </tr>
      </x-table-header>
      <tbody>
            <tr>
                <td><b>@data($troca->data_troca)</b></td>
                <td><b>@moeda($troca->valor_bruto)</b></td>
                <td><b>@moeda($troca->valor_juros)</b></td>
                <td><b>@moeda($troca->valor_liquido)</b></td>
                <td><b>{{ $troca->taxa_juros }}%</b></td>
            </tr>
      </tbody>
</x-table>
<p></p>
<x-table id="dataTable">
    <x-table-header>
        <tr>
            <th>Nome</th>
            <th>Número</th>
            <th>Data</th>
            <th>Dias</th>
            <th>Valor Bruto</th>
            <th>Juros</th>
            <th>Valor líquido</th>
        </tr>
    </x-table-header>
    <tbody>
        @foreach ($troca->cheques as $cheque)
            @if ($cheque->parcelas->status === 'Adiado')
            <tr>
                <td><p>{{ $cheque->parcelas->nome_cheque }}</p></td>
                <td><p>{{ $cheque->parcelas->numero_cheque }}</p></td>
                <td>
                    <s>@data($cheque->parcelas->data_parcela)</s>
                    <p>@data($cheque->parcelas->adiamentos->nova_data)</p>
                </td>
                <td>
                    <s>{{ $cheque->dias }}</s>
                </td>
                <td><p>@moeda($cheque->parcelas->valor_parcela)</p></td>
                <td>
                    <p>@moeda($cheque->valor_juros)</p>
                </td>
                <td>
                    <p>@moeda($cheque->valor_liquido)</p>
                </td>
            </tr>
            @else
            <tr>
                <td>{{ $cheque->parcelas->nome_cheque }}</td>
                <td><p>{{ $cheque->parcelas->numero_cheque }}</p></td>
                <td>@data($cheque->parcelas->data_parcela)</td>
                <td>{{ $cheque->dias }}</td>
                <td>@moeda($cheque->parcelas->valor_parcela)</td>
                <td>@moeda($cheque->valor_juros)</td>
                <td>@moeda($cheque->valor_liquido)</td>
            </tr>
            @endif
        @endforeach
    </tbody>
</x-table>

@endsection
@section('script')
<script>
      const TAXA = {{ $troca->taxa_juros }}
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
@endsection