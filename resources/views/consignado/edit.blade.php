@extends('layout')
@section('title')
Cadastro de consignado
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('consignado.index') }}">Consignados</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
    </ol>
</nav>

<meta name="csrf-token" content="{{ csrf_token() }}" />

<form method="POST" action="{{ route('consignado.update', $consignado)}}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-4">
            <x-form-group name="data" type='date' value="{{ old('data', $consignado->data) }}" >
                Data
            </x-form-group>
        </div>
        <div class="col-4">
            <x-form-group name="peso" value="{{ old('peso', $consignado->peso) }}">
                Peso
            </x-form-group>
        </div>
        <div class="col-4">
            <x-form-group name="fator" value="{{ old('fator', $consignado->fator) }}">
                Fator
            </x-form-group>
        </div>
        <div class="col-4">
            <label for="representante_id">Representante</label>
            <x-select name="representante_id" >
                <option value=""></option>
                    @foreach ($representantes as $representante)
                        <option 
                            value="{{ $representante->id }}" 
                            {{old('representante_id', $consignado->representante_id) == $representante->id ? 'selected' : ''}}
                        >
                            {{ $representante->pessoa->nome }}
                        </option>
                    @endforeach
            </x-select>
        </div>
        <div class="col-4 form-group">
            <label for="cliente_id">Cliente</label>
            <div class="d-flex">
                <select name="cliente_id" 
                    class="{{ $errors->has('cliente_id') ? 'is-invalid form-control' : 'form-control' }}"
                    id="cliente_id">
                    <option></option>
                </select>
                <div class="btn btn-dark procurarCliente">
                    <span class="fas fa-search"></span>
                </div>
            </div>
            @error('cliente_id')
                <div class="invalid-feedback d-inline">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <input type="submit" class='btn btn-success mt-2'>
</form>
<input type="hidden" value="{{$consignado->representante_id}}" id="old_representante_id">
<input type="hidden" value="{{$consignado->cliente_id}}" id="old_cliente_id">
@endsection
@section('script')
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
                <form id="formProcurarCliente" method="GET" action="{{ route('procurarCliente') }}">
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
                url: '{{url("procurarCliente")}}',
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
@endsection