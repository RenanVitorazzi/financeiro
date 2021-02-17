@extends('layout')
@section('title')
Adicionar cliente
@endsection
@push('script')
    <script type="text/javascript" src="{{ asset('js/cep.js') }}"></script>
@endpush
@section('body')
    <form method="POST" action="{{ route('clientes.store')}}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-form-group name='nome' autofocus >Nome completo</x-form-group>
            </div>
            <div class="col-md-6">
                <x-form-group name='nascimento' type='date' >Data de nascimento</x-form-group>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipoCadastro">Tipo de cadastro</label>
                    <select type="text" name="tipoCadastro" id="tipoCadastro" class="form-control" required>
                        <option value='Pessoa Física'> Pessoa Física</option>
                        <option value='Pessoa Jurídica'> Pessoa Jurídica</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div id='cpfGroup'>
                    <x-form-group name='cpf'>CPF</x-form-group>
                </div>
                <div style='display:none' id='cnpjGroup'>
                    <x-form-group name='cnpj'>CPNJ</x-form-group>
                </div>
            </div>
        </div> 

        @include('formEndereco')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="representante">Representante</label>
                    <select type="text" name="representante" id="representante" class="form-control">
                        <option></option>
                        @foreach ($representantes as $representante)
                            <option value="{{ $representante->id }}">
                                {{ $representante->pessoa->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> 
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class='mt-2'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <input type="submit" class='btn btn-success'>
    </form>
@endsection