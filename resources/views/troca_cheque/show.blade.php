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
        {{-- @if (count($contaCorrente) > 0) --}}
        <x-botao-imprimir class="mr-2" href="{{ route('pdf_troca', $troca->id) }}"></x-botao-imprimir>
        {{-- @endif --}}
        {{-- <x-botao-novo href="{{ route('conta_corrente_representante.create', ['representante_id' => $representante->id]) }}"></x-botao-novo> --}}
    </div>
</div>

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
                <th>Número Cheque</th>
                <th>Data</th>
                {{-- <th>Status</th> --}}
                <th>Dias</th>
                <th>Valor Bruto</th>
                <th>Juros</th>
                <th>Valor líquido</th>
                {{-- <th>Ações</th> --}}
        </tr>
    </x-table-header>
    <tbody>
        @foreach ($troca->cheques as $cheque)
            @if ($cheque->parcelas->first()->status === 'Adiado')
            <tr>
                <td><p>{{ $cheque->parcelas->first()->nome_cheque }}</p></td>
                <td><p>{{ $cheque->parcelas->first()->numero_cheque }}</p></td>
                <td>
                    <s>@data($cheque->parcelas->first()->data_parcela)</s>
                    <p>@data($cheque->adiamento->last()->data)</p>
                </td>
                {{-- <td><p>{{ $cheque->parcelas->first()->status }} ({{ $cheque->adiamento->count() }})</p></td> --}}
                <td>
                    <s>{{ $cheque->dias }}</s>
                    <p>{{ $cheque->dias + $cheque->adiamento->last()->dias_totais }}</p>
                </td>
                <td><p>@moeda($cheque->parcelas->first()->valor_parcela)</p></td>
                <td>
                    <s>@moeda($cheque->valor_juros)</s>
                    <p>@moeda($cheque->adiamento->last()->juros_totais)</p>
                </td>
                <td>
                    {{-- <s>@moeda($cheque->valor_liquido)</s> --}}
                    <p>@moeda($cheque->valor_liquido)</p>
                </td>
                {{-- <td>
                    <div class="btn btn-dark btn-adiar" 
                        data-id="{{ $cheque->parcela_id }}" 
                        data-dia="{{ $cheque->adiamento->last()->data }}" 
                        data-valor="{{ $cheque->parcelas->first()->valor_parcela }}" 
                        data-juros="{{ $cheque->adiamento->last()->juros_totais }}" 
                        data-troca_parcela_id="{{ $cheque->id }}"
                        data-nome="{{ $cheque->parcelas->first()->nome_cheque }}"
                    > Adiar <i class="far fa-clock"></i> </div>              
                    <form class="form-resgate" method="POST" action="{{ route('resgatar_cheque', $cheque->parcela_id) }}">
                        @csrf
                        <input type="hidden" name="troca_id" value="{{ $cheque->id }}">
                        <button type="submit" class="btn btn-primary btn-resgatar">Resgatar</button>
                    </form>      
                </td> --}}
            </tr>
            @else
            <tr>
                <td>{{ $cheque->parcelas->first()->nome_cheque }}</td>
                <td><p>{{ $cheque->parcelas->first()->numero_cheque }}</p></td>
                <td>@data($cheque->parcelas->first()->data_parcela)</td>
                {{-- <td>{{ $cheque->parcelas->first()->status }}</td> --}}
                <td>{{ $cheque->dias }}</td>
                <td>@moeda($cheque->parcelas->first()->valor_parcela)</td>
                <td>@moeda($cheque->valor_juros)</td>
                <td>@moeda($cheque->valor_liquido)</td>
                {{-- <td>
                    @if ($cheque->parcelas->first()->status !== 'Resgatado')
                    <div class="btn btn-dark btn-adiar" 
                            data-id="{{ $cheque->parcela_id }}" 
                            data-dia="{{ $cheque->parcelas->first()->data_parcela }}" 
                            data-valor="{{ $cheque->parcelas->first()->valor_parcela }}" 
                            data-juros="{{ $cheque->valor_juros }}" 
                            data-troca_parcela_id="{{ $cheque->id }}"
                            data-nome="{{ $cheque->parcelas->first()->nome_cheque }}"
                    > Adiar <i class="far fa-clock"></i> </div>      
                    <form class="form-resgate" method="POST" action="{{ route('resgatar_cheque', $cheque->parcela_id) }}">
                        @csrf
                        <input type="hidden" name="troca_id" value="{{ $cheque->id }}">
                        <button type="submit" class="btn btn-primary btn-resgatar">Resgatar</button>
                    </form>
                    @endif
                </td> --}}
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