@extends('layout')
@section('title')
Editar cliente
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js1/cep.js') }}"></script>
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>

<form method="POST" action="{{ route('clientes.update', $cliente->id)}}">
    @csrf
    @method('PUT')

    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Dados Gerais</h5>
            <div class="row">
                <div class="col-4">
                    <x-form-group name='nome' autofocus value="{{ $cliente->pessoa->nome }}">Nome</x-form-group>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="tipoCadastro">Tipo de cadastro</label>
                        <x-select name="tipoCadastro" required>
                            <option value='Pessoa Física' {{ ($cliente->pessoa->tipoCadastro == 'Pessoa Física') ? 'selected' : '' }} > Pessoa Física</option>
                            <option value='Pessoa Jurídica' {{ ($cliente->pessoa->tipoCadastro == 'Pessoa Jurídica') ? 'selected' : '' }} > Pessoa Jurídica</option>
                        </x-select>
                    </div>
                </div>
                <div class="col-4">
                    <div {{ ($cliente->pessoa->tipoCadastro == 'Pessoa Jurídica') ? 'style=display:none' : '' }} id='cpfGroup'>
                        <x-form-group name='cpf'>CPF</x-form-group>
                    </div>
                    <div {{ ($cliente->pessoa->tipoCadastro == 'Pessoa Jurídica') ? '' : 'style=display:none' }} id='cnpjGroup'>
                        <x-form-group name='cnpj'>CPNJ</x-form-group>
                    </div>
                </div>
            </div> 
        </div> 
    </div> 

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Endereço</h5>
            <div class='row'>
                <div class="col-4">
                    <x-form-group name='cep' value="{{ $cliente->pessoa->cep }}">CEP</x-form-group>
    
                    <x-form-group name='bairro' value="{{ $cliente->pessoa->bairro }}">Bairro</x-form-group>
                </div>
                <div class="col-4">
                    <div class='form-group'>
                        <label for='estado'>Estado</label>
                        <x-select name='estado'>
                            <option></option>
                            <option {{ $cliente->pessoa->estado == 'AC' ? 'selected' : '' }} value="AC">Acre</option>
                            <option {{ $cliente->pessoa->estado == 'AL' ? 'selected' : '' }} value="AL">Alagoas</option>
                            <option {{ $cliente->pessoa->estado == 'AP' ? 'selected' : '' }} value="AP">Amapá</option>
                            <option {{ $cliente->pessoa->estado == 'AM' ? 'selected' : '' }} value="AM">Amazonas</option>
                            <option {{ $cliente->pessoa->estado == 'BA' ? 'selected' : '' }} value="BA">Bahia</option>
                            <option {{ $cliente->pessoa->estado == 'CE' ? 'selected' : '' }} value="CE">Ceará</option>
                            <option {{ $cliente->pessoa->estado == 'DF' ? 'selected' : '' }} value="DF">Distrito Federal</option>
                            <option {{ $cliente->pessoa->estado == 'ES' ? 'selected' : '' }} value="ES">Espírito Santo</option>
                            <option {{ $cliente->pessoa->estado == 'GO' ? 'selected' : '' }} value="GO">Goiás</option>
                            <option {{ $cliente->pessoa->estado == 'MA' ? 'selected' : '' }} value="MA">Maranhão</option>
                            <option {{ $cliente->pessoa->estado == 'MT' ? 'selected' : '' }} value="MT">Mato Grosso</option>
                            <option {{ $cliente->pessoa->estado == 'MS' ? 'selected' : '' }} value="MS">Mato Grosso do Sul</option>
                            <option {{ $cliente->pessoa->estado == 'MG' ? 'selected' : '' }} value="MG">Minas Gerais</option>
                            <option {{ $cliente->pessoa->estado == 'PA' ? 'selected' : '' }} value="PA">Pará</option>
                            <option {{ $cliente->pessoa->estado == 'PB' ? 'selected' : '' }} value="PB">Paraíba</option>
                            <option {{ $cliente->pessoa->estado == 'PR' ? 'selected' : '' }} value="PR">Paraná</option>
                            <option {{ $cliente->pessoa->estado == 'PE' ? 'selected' : '' }} value="PE">Pernambuco</option>
                            <option {{ $cliente->pessoa->estado == 'PI' ? 'selected' : '' }} value="PI">Piauí</option>
                            <option {{ $cliente->pessoa->estado == 'RJ' ? 'selected' : '' }} value="RJ">Rio de Janeiro</option>
                            <option {{ $cliente->pessoa->estado == 'RN' ? 'selected' : '' }} value="RN">Rio Grande do Norte</option>
                            <option {{ $cliente->pessoa->estado == 'RS' ? 'selected' : '' }} value="RS">Rio Grande do Sul</option>
                            <option {{ $cliente->pessoa->estado == 'RO' ? 'selected' : '' }} value="RO">Rondônia</option>
                            <option {{ $cliente->pessoa->estado == 'RR' ? 'selected' : '' }} value="RR">Roraima</option>
                            <option {{ $cliente->pessoa->estado == 'SC' ? 'selected' : '' }} value="SC">Santa Catarina</option>
                            <option {{ $cliente->pessoa->estado == 'SP' ? 'selected' : '' }} value="SP">São Paulo</option>
                            <option {{ $cliente->pessoa->estado == 'SE' ? 'selected' : '' }} value="SE">Sergipe</option>
                            <option {{ $cliente->pessoa->estado == 'TO' ? 'selected' : '' }} value="TO">Tocantins</option>
                        </x-select>
                    </div>
                    
                    <x-form-group name='logradouro' value="{{ $cliente->pessoa->logradouro }}">Logradouro</x-form-group>
                
                </div>
            
                <div class="col-4">
                    <div class='form-group'>
                        <label for='municipio'>Município</label>
                        <x-select name='municipio'>
                            <option value="{{ $cliente->pessoa->logradouro }}">{{ $cliente->pessoa->logradouro }}</option>
                        </x-select>
                    </div>
                    <x-form-group name='numero' value="{{ $cliente->pessoa->numero }}">Número</x-form-group>
                </div>
            
            </div>
            <x-form-group name='complemento' value="{{ $cliente->pessoa->complemento }}">Complemento</x-form-group>
        </div>  
    </div>  

    <div class="card mt-2 mb-2">
        <div class="card-body">
            <h5 class="card-title">Contato</h5>
            <div class="row">
                <div class="col-4">
                    <x-form-group name="telefone" value="{{ $cliente->pessoa->telefone }}" placeholder="(00)0000-0000">
                        Telefone
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="celular" value="{{ $cliente->pessoa->celular }}" placeholder="(00)00000-0000">
                        Celular
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="email" type="email" value="{{ $cliente->pessoa->email }}">
                        E-mail
                    </x-form-group>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <x-form-group name="telefone2" value="{{ $cliente->pessoa->telefone2 }}" placeholder="(00)0000-0000">
                        Segundo Telefone
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="celular2" value="{{ $cliente->pessoa->celular2 }}" placeholder="(00)00000-0000">
                        Segundo Celular
                    </x-form-group>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Outros</h5>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="representante">Representante</label>
                        <select type="text" name="representante" id="representante" class="form-control">
                            <option></option>
                            @foreach ($representantes as $representante)
                                <option value="{{ $representante->id }}" 
                                    {{ ($cliente->representante_id == $representante->id) ? 'selected' : '' }}>
                                    {{ $representante->pessoa->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> 
        </div>
    </div>

    <input type="submit" class='btn btn-success'>
</form>
@endsection