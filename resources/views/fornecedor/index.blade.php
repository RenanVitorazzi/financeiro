@extends('layout')
@section('title')
Fornecedores
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Fornecedores</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">Cadastro</li> --}}
    </ol>
</nav>
<div class='mb-2 d-flex justify-content-between'>
    <h3> Fornecedores </h3>
    <div>
        <x-botao-imprimir class="mr-2" href="{{ route('pdf_fornecedores') }}"></x-botao-imprimir>
        <x-botao-novo href="{{ route('fornecedores.create') }}"></x-botao-novo>
    </div>
</div>
<div class='row'>
    <div class="col-6">
        <ul class="d-flex list-group list-group">
            @forelse ($fornecedores as $fornecedor)
            
                <li class='list-group-item d-flex justify-content-between'>
                    <div class='mt-2'>
                        <span>{{ $fornecedor->pessoa->nome }}</span>
                        <span class="font-weight-bold ml-2 badge badge-pill {{ $fornecedor->conta_corrente_sum_peso_agregado < 0 ? 'badge-danger' : 'badge-dark' }}">@peso($fornecedor->conta_corrente_sum_peso_agregado)</span>
                    </div>
                    <div class='d-flex'>
                        <a class="btn btn-dark mr-2" title="Conta corrente" href="{{ route('fornecedores.show', $fornecedor->id) }}">
                            <i class="fas fa-chart-area"></i>
                        </a>
                        <x-botao-editar class="mr-2" href="{{ route('fornecedores.edit', $fornecedor->id) }}"></x-botao-editar>
                        <x-botao-excluir action="{{ route('fornecedores.destroy', $fornecedor->id) }}">
                        </x-botao-excluir>
                    </div>
                </li>
            @empty
                <li class='list-group-item list-group-item-danger'>Nenhum registro criado!</li>
            @endforelse
        </ul>
    </div>
    <div class="col-6">
        <canvas id="myChart"></canvas>
    </div>
   
</div>


@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const LABELS = @json($labels);
    const DATA_GRAFICO = @json($data);

    @if(Session::has('message'))
        toastr["success"]("{{ Session::get('message') }}")
    @endif
    
    var poolColors = function (a) {
        var pool = [];
        for(i=0;i<a;i++){
            pool.push(dynamicColors());
        }
        return pool;
    }

    var dynamicColors = function() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    }

    const data = {
        labels: JSON.parse(LABELS),
        datasets: [{
            data: JSON.parse(DATA_GRAFICO),
            backgroundColor: 
                poolColors(20)
            
            ,
        }]
    };

    const config = {
        type: 'pie',
        data: data
    };
    
    var myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
@endsection