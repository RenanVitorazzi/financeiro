@extends('layout')

@section('title')
Vendas - {{$representante->pessoa->nome}} 
@endsection

@section('body')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @if (!auth()->user()->is_representante)
        <li class="breadcrumb-item"><a href="{{ route('representantes.index') }}">Representantes</a></li>    
        @endif
        <li class="breadcrumb-item active" aria-current="page">Vendas</li>
    </ol>
</nav>
<div class='mb-2 d-flex justify-content-between'>
    <h3>Vendas - {{ $representante->pessoa->nome}}</h3> 
    <div> 
        {{-- <x-botao-imprimir class="mr-2" href=""></x-botao-imprimir> --}}
        <x-botao-novo href="{{ route('venda.create', ['id' => $representante->id]) }}"></x-botao-novo>
    </div>
</div>
<x-table id="tableVendas">
    <x-table-header>
        <th>
            <input type="checkbox" id="checkAll">
        </th>
        <th>Data</th>
        <th>Cliente</th>
        <th>Valor</th>
        <th>Pagamento</th>
        <th>Ações</th>
    </x-table-header>
    <tbody>
        @forelse ($vendas as $venda)
        <tr>
            <td><input type="checkbox" name="id_venda[]" value="{{ $venda->id }}"></td>
            <td>@data($venda->data_venda)</td>
            <td>{{ $venda->cliente->pessoa->nome }}</td>
            <td>@moeda($venda->valor_total)</td>
            <td>
                <b>{{$venda->metodo_pagamento}}</b>
                @foreach ($venda->parcela as $parcela)
                <br>
                <small class="text-muted">
                    @data($parcela->data_parcela) - @moeda($parcela->valor_parcela) ({{ $parcela->status }})
                </small> 
                @endforeach
            </td>
            <td>
                <x-botao-editar href='{{ route("venda.edit", $venda->id) }}'></x-botao-editar>
                <x-botao-excluir action='{{ route("venda.destroy", $venda->id) }}'></x-botao-excluir>
            </td>
        </tr>

        @empty
        <tr><td colspan="7" class="table-danger">Nenhum registro criado</td></tr>
        @endforelse
    </tbody>
</x-table>

<div id="enviarCC" class="btn btn-dark">
    Enviar para o conta corrente
</div>
@endsection
@section('script')
<script>
    @if(Session::has('message'))
        toastr["success"]("{{ Session::get('message') }}")
    @endif
    
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

        $.ajax({
            method: "POST",
            url: "{{ route('enviar_conta_corrente') }}",
            data: { 
                vendas_id: arrayId, 
                _token: CSRF_TOKEN 
            },
            dataType: 'json'
        }).done( (response) => {
            
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
@endsection