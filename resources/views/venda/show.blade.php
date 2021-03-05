@extends('layout')

@section('title')
Vendas - {{$representante->pessoa->nome}}
@endsection

@section('body')
<div class='mb-4'>
    <h3 class='d-inline' style="color:#212529">Vendas - {{ $representante->pessoa->nome}}</h3>  
    <x-botao-novo href="{{ route('venda.create', ['id' => $representante->id]) }}"></x-botao-novo>
</div>
    @if(Session::has('message'))
        <p class="alert alert-success">{{ Session::get('message') }}</p>
    @endif
    {{-- <div class='alert alert-success'>
        Valor total de cheques para o mês: <b>{{ number_format($chequesMes, 2) }}</b>
    </div>  --}}
    {{-- <div>
        <h3 class="{{ $balancoFator > 0 ? 'text-success' : 'text-danger' }} font-weight-bold float-right">
            Fator: {{ number_format($balancoFator, 2) }}g
        </h3> 
    </div> --}}
  
    <x-table>
        {{-- <x-table-header>
            <th colspan=7>Vendas </th>
        </x-table-header> --}}
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
                    <x-botao-editar href='{{ route("venda.edit", $venda->id) }}'></x-botao-editar>
                    <x-botao-excluir action='{{ route("venda.destroy", $venda->id) }}'></x-botao-excluir>
                </td>
            </tr>

            @empty
            <tr><td colspan="7" class="table-danger">Nenhum registro criado</td></tr>
            @endforelse
        </tbody>
        {{-- <tfoot class="thead-dark"><th colspan=7>TOTAL: 300000 </th></tfoot> --}}
    </x-table>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div id="enviarCC" class="btn btn-primary">
        Enviar para o conta corrente
    </div>
    {{-- <x-table>
        <x-table-header>
            <tr>
                <th colspan=6> Abertos </th>
            </tr>
        </x-table-header>
        <x-table-header>
            <tr>
                <th>Data</th>
                <th>Cliente</th>
                <th>Balanço</th>
                <th>Peso</th>
                <th>Fator</th>
                <th>Ações</th>
            </tr>
        </x-table-header>
        <tbody>
            @forelse ($abertos as $aberto)
            <tr>
                <td>{{ date('d/m/Y', strtotime($aberto->data_aberto)) }}</td>
                <td>{{ $aberto->cliente->pessoa->nome }}</td>
                <td class="{{ $aberto->balanco !== 'Devolução' ? 'text-danger' : 'text-success' }}">
                    <b>{{ $aberto->balanco }}</b>
                    <i class="fas {{ $aberto->balanco !== 'Devolução' ? 'fa-angle-down' : 'fa-angle-up' }}"></i>
                </td>
                <td>{{ number_format($aberto->peso, 2) }}</td>
                <td>{{ number_format($aberto->fator, 2) }}</td>
                <td>
                    <x-botao-editar href='{{ route("venda.edit", $aberto->id) }}'></x-botao-editar>
                    <x-botao-excluir action='{{ route("venda.destroy", $aberto->id) }}'></x-botao-excluir>
                </td>
            </tr>

            @empty
            <tr><td colspan="6" class="table-danger">Nenhum registro criado</td></tr>
            @endforelse
        </tbody>
    </x-table>
    {{ $abertos->links() }} --}}
@endsection
@push('script')
<script>
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
        $("input[name='id_venda[]']").each(function (index,element) {
            arrayId.push( $( element ).val() );
        })

        $.ajax({
            method: "POST",
            url: "{{ route('enviarContaCorrente') }}",
            data: { vendas_id: arrayId, _token: CSRF_TOKEN },
            dataType: 'json'
        }).done( (response) => {
            
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
@endpush