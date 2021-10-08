@extends('layout')
@section('title')
Devolvidos
@endsection
@section('body')
<div class='mb-2 d-flex justify-content-between'>
    <h3> Devolvidos </h3>
</div>
       
<x-table id="tabelaBalanco">
    <x-table-header>
        <tr>
            {{-- <th>Cliente</th> --}}
            <th>Titular</th>
            @if (!auth()->user()->is_representante)
            <th>Representante</th>
            @endif
            <th>Data</th>
            <th>Valor</th>
            <th>Número</th>
            <th>Status</th>
            <th>Observação</th>
            <th>Ações</th>
        </tr>
    </x-table-header>
    <tbody>
        @forelse ($cheques as $cheque)
            <tr>
                {{-- <td>{{ $cheque->venda_id ? $cheque->cliente : 'Não informado' }}</td> --}}
                <td>{{ $cheque->nome_cheque }}</td>
                @if (!auth()->user()->is_representante)
                    @if ($cheque->representante_id)
                    <td>{{ $cheque->representante->pessoa->nome }}</td>
                    @else
                    <td></td>
                    @endif
                @endif
                <td>@data($cheque->data_parcela)</td>
                <td>@moeda($cheque->valor_parcela)</td>
                <td>{{ $cheque->numero_cheque }}</td>
                <td>{{ $cheque->status }}</td>
                <td>{{ $cheque->observacao }}</td>
                <td>
                    <button class="btn btn-success btn-pago" data-id="{{ $cheque->id }}">Pago</button> 
                    <button class="btn btn-danger btn-devolvido" 
                        data-id="{{ $cheque->id }}" 
                        data-nome="{{$cheque->nome_cheque}}"
                        data-data="{{$cheque->data_parcela}}"
                        data-valor="{{$cheque->valor_parcela}}"
                    >Devolvido</button>     
                </td>
            </tr>
        @empty
        <tr>
            <td colspan=7>Nenhum registro</td>
        </tr>
        @endforelse
    </tbody>
</x-table>

@endsection
@section('script')
<script>
    const TAXA = 3
    const MODAL = $("#modal")
    const MODAL_BODY = $("#modal-body")
    const MOTIVOS = JSON.parse(@json($motivos));
 
    function criarOpcaoMotivos() {
        let options = ``;

        MOTIVOS.forEach( (element) => {
            options += `<option value=${element.motivo_id}>${element.motivo_id} - ${element.descricao}</option>`
        });

        return options;
    }

    $(".btn-devolvido").each( (index, element) => {
        $(element).click( () => {
            InformarDevolucao(element)
        })
    });
    
    function InformarDevolucao(element) {

        let data = $(element).data()
        let opcaoMotivo = criarOpcaoMotivos()
        
        MODAL.modal("show")
        
        $("#modal-title").html("Prorrogação")
        
        MODAL_BODY.html(`
            <form id="formDevolvido" action="{{ route('devolvidos.store') }}"> 
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <p>Titular: <b>${data.nome}</b></p>
                <p>Valor do cheque: R$ <b>${data.valor}</b></p>
                <p>Data: <b>${data.data}</b></p>

                <div class="form-group">
                    <label for="nova_data">Informe o motivo</label>
                    <x-select name="motivo">
                        ${opcaoMotivo}
                    </x-select>
                </div>
               
                <div class="form-group">
                    <label for="observacao">Observação</label>
                    <textarea class="form-control" name="observacao" id="observacao"></textarea>
                </div>
            </form>
        `)

        $("#taxa_juros, #nova_data").change( () => {
            let dataNova = $("#nova_data").val()
            let diferencaDias = calcularDiferencaDias(data.dia, dataNova)

            let jurosNovos = calcularNovosJuros(element, diferencaDias)
            let jurosTotais = parseFloat(jurosNovos)

            $("#diasAdiados").html(diferencaDias)
            $("#juros_totais").val((jurosTotais).toFixed(2))
        })

        $(".modal-footer > .btn-primary").click( () => {
            let dataForm = $("#formAdiamento").serialize() 
                + "&parcela_data=" + data.dia 
                + "&parcela_id=" + data.id
                    
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
        let taxa = $("#taxa_juros").val();
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
</script>
@endsection