@extends('layout')
@section('title')
Parceiros
@endsection
@section('body')
<div class='mb-2 d-flex justify-content-between'>
    <h3>Parceiros</h3>  
    <div>
        <x-botao-novo href="{{ route('parceiros.create') }}"></x-botao-novo>
    </div>
</div>
<ul class="d-flex list-group list-group">
    @forelse ($parceiros as $parceiro)
        <li class='list-group-item d-flex justify-content-between'>
            <div class='mt-2'>
                {{ $parceiro->pessoa->nome }}
                <span class="text-muted">{{ $parceiro->porcentagem_padrao }}%</span>
            </div>
            <div class='d-flex'>
                <x-botao-editar class="mr-2" href="{{ route('parceiros.edit', $parceiro->id) }}"></x-botao-editar>
                <x-botao-excluir action="{{ route('parceiros.destroy', $parceiro->id) }}"></x-botao-excluir>
            </div>
        </li>
        
    @empty
        <li class='list-group-item list-group-item-danger'>Nenhum registro criado!</li>
    @endforelse
</ul>
        
@endsection
@section('script')
<script>
    @if(Session::has('message'))
        toastr["success"]("{{ Session::get('message') }}")
    @endif
</script>
@endsection