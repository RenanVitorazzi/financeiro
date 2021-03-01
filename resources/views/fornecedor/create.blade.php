@extends('layout')
@section('title')
Adicionar representante
@endsection
@push('script')
    <script type="text/javascript" src="{{ asset('js/cep.js') }}"></script>
@endpush

@section('body')
    <form method="POST" action="{{ route('fornecedores.store')}}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-form-group name='nome' autofocus value="{{ old('nome') }}">Nome completo</x-form-group>
            </div>
            <div class="col-md-6">
                <x-form-group name='nascimento' type='date' value="{{ old('nascimento') }}">Data de nascimento</x-form-group>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipoCadastro">Tipo de cadastro</label>
                    <select type="text" name="tipoCadastro" id="tipoCadastro" class="form-control" required>
                        <option value='Pessoa Física' {{ (old('tipoCadastro') == 'Pessoa Física') ? 'selected' : '' }} > Pessoa Física</option>
                        <option value='Pessoa Jurídica' {{ (old('tipoCadastro') == 'Pessoa Jurídica') ? 'selected' : '' }} > Pessoa Jurídica</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div {{ (old('tipoCadastro') == 'Pessoa Jurídica') ? 'style=display:none' : '' }} id='cpfGroup'>
                    <x-form-group name='cpf'>CPF</x-form-group>
                </div>
                <div {{ (old('tipoCadastro') == 'Pessoa Jurídica') ? '' : 'style=display:none' }} id='cnpjGroup'>
                    <x-form-group name='cnpj'>CPNJ</x-form-group>
                </div>
            </div>
        </div> 

        @include('formEndereco')


        <div class="row">
            <div class="col-md-6">
                <x-form-group name='telefone' value="{{ old('telefone') }}">Telefone com DDD</x-form-group>
            </div>
            <div class="col-md-6">
                <x-form-group name='celular' value="{{ old('celular') }}">Celular com DDD</x-form-group>
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