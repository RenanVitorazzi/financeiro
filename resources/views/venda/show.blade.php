@extends('layout')

@section('title')
Vendas - {{$representante->pessoa->nome}} 
@endsection

@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('representantes.index') }}">Representantes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Vendas</li>
    </ol>
</nav>
<div class='mb-2 d-flex justify-content-between'>
    <h3>Vendas - {{ $representante->pessoa->nome}}</h3> 
    <div> 
        <x-botao-imprimir class="mr-2"></x-botao-imprimir>
        <x-botao-novo href="{{ route('venda.create', ['id' => $representante->id]) }}"></x-botao-novo>
    </div>
</div>
@if(Session::has('message'))
<div class="alert alert-success">{{ Session::get('message') }}</div>
@endif
    <x-table>
        <x-table-header>
            <th>
                <input type="checkbox" id="checkAll">
            </th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Balanço</th>
            <th>Valor</th>
            <th>Pagamento</th>
            <th>Ações</th>
        </x-table-header>
        <tbody>
            @forelse ($vendas as $venda)
            <tr>
                <td>
                    <input type="checkbox" name="id_venda[]" value="{{ $venda->id }}">
                </td>
                <td>{{ date('d/m/Y', strtotime($venda->data_venda)) }}</td>
                <td>{{ $venda->cliente->pessoa->nome }}</td>
                <td class="{{ $venda->balanco !== 'Venda' ? 'text-danger' : 'text-success' }}">
                    <b>{{ $venda->balanco }}</b>
                    <i class="fas {{ $venda->balanco !== 'Venda' ? 'fa-angle-down' : 'fa-angle-up' }}"></i>
                </td>   
                <td>{{ number_format($venda->valor_total, 2) }}</td>
               
                <td>
                    <b>{{$venda->metodo_pagamento}}</b>
                    <br>
                    @foreach ($venda->parcela as $parcela)
                    {{ date('d/m/Y', strtotime($parcela->data_parcela)) }} - 
                    {{ number_format($parcela->valor_parcela, 2) }} 
                    <br>
                    @endforeach
                </td>
                <td>
                    {{-- <x-botao-editar href='{{ route("venda.edit", $venda->id) }}'></x-botao-editar> --}}
                    <x-botao-excluir action='{{ route("venda.destroy", $venda->id) }}'></x-botao-excluir>
                </td>
            </tr>

            @empty
            <tr><td colspan="7" class="table-danger">Nenhum registro criado</td></tr>
            @endforelse
        </tbody>
    </x-table>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div id="enviarCC" class="btn btn-primary">
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
            title: 'Tem certeza disso?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Enviar'
        }).then((result) => {
            if (result.isConfirmed) {
                //funcao Ajax
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
            url: "{{ route('enviarContaCorrente') }}",
            data: { vendas_id: arrayId, _token: CSRF_TOKEN },
            dataType: 'json'
        }).done( (response) => {
            console.log(response);
            // console.log(arrayId);
            Swal.fire({
                title: 'Sucesso!',          
                icon: 'success'

            }).then((result) => {
                document.location.reload(true)
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
</script>
@endsection