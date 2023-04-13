@extends('layout')
@section('title')
Entrega de cheques
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Entrega de cheques</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">Cadastro</li> --}}
    </ol>
</nav>
<div class='d-flex justify-content-between'>

    <a class='btn btn-block btn-dark m-2' id='entrega_representante' >
        <p></p>
        <h3>Entregar cheques para representantes </h3>
        <p></p>
    </a>
    <a class='btn btn-block btn-dark m-2' id='receber_parceiro'>
        <p></p>
        <h3>Receber cheques dos parceiros </h3>
        <p></p>
    </a>
   
</div>


@endsection
@section('script')
<script>
    const REPRESENTANTES = @json($representantes);
    const PARCEIROS = @json($parceiros);

    let opRepresentante = '';
    REPRESENTANTES.forEach(element => {
        opRepresentante += `<option value='${element.id}'>${element.pessoa.nome}</option>`
    });

    let opParceiro = '';
    PARCEIROS.forEach(element => {
        opParceiro += `<option value='${element.id}'>${element.pessoa.nome}</option>`
    });

    $("#entrega_representante").click( () => {
        $("#modal2").modal('show')
        $("#modal-header2").text('Escolha o representante')
        $("#modal-body2").html(`
            <div class='row'>
                <div class="col-12 form-group">
                    <label for="representante_id">Representante</label>
                    <x-select name="representante_id" data-tipo='representante'>
                        <option></option>
                        ${opRepresentante}
                    </x-select>
                </div>
            </div>
            <div id='btnEscolha'></div>
        `)
        trocaPessoa()
    })

    $("#receber_parceiro").click( () => {
        $("#modal2").modal('show')
        $("#modal-header2").text('Escolha o parceiro')
        $("#modal-body2").html(`
            <div class='row'>
                <div class="col-12 form-group">
                    <label for="parceiro_id">Parceiro</label>
                    <x-select name="parceiro_id" data-tipo='parceiro'>
                        <option></option>
                        ${opParceiro}
                    </x-select>
                </div>
            </div>
            <div id='btnEscolha'></div>
        `)
        trocaPessoa()
    })

    function trocaPessoa () {
        $("#parceiro_id, #representante_id").change( (e) => {
            let element = $(e.target)

            let route = (element.data('tipo') == 'parceiro') ? 'receber_parceiro' : 'entrega_representante'

            $('#btnEscolha').html(`<a class='btn btn-block btn-dark' href='/entrega_parcela/${route}/${element.val()}'>Lançar</a>`)

        })
    }
    
</script>
@endsection