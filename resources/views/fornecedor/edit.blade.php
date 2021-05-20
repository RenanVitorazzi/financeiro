@extends('layout')
@section('title')
Editar fornecedor
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('fornecedores.index') }}">Fornecedores</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>

<form method="POST" action="{{ route('fornecedores.update', $fornecedor->id)}}">
    @csrf
    @method('PUT')
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Dados Gerais</h5>
            <div class="row">
                <div class="col-4">
                    <x-form-group name='nome' value="{{ $fornecedor->pessoa->nome }}">Nome</x-form-group>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="tipoCadastro">Tipo de cadastro</label>
                        <x-select name="tipoCadastro" required>
                            <option value='Pessoa Física' {{ ($fornecedor->pessoa->tipoCadastro == 'Pessoa Física') ? 'selected' : '' }} > Pessoa Física</option>
                            <option value='Pessoa Jurídica' {{ ($fornecedor->pessoa->tipoCadastro == 'Pessoa Jurídica') ? 'selected' : '' }} > Pessoa Jurídica</option>
                        </x-select>
                    </div>
                </div>
                <div class="col-4">
                    <div {{ ($fornecedor->pessoa->tipoCadastro == 'Pessoa Jurídica') ? 'style=display:none' : '' }} id='cpfGroup'>
                        <x-form-group name='cpf' value='{{ $fornecedor->pessoa->cpf }}'>CPF</x-form-group>
                    </div>
                    <div {{ ($fornecedor->pessoa->tipoCadastro == 'Pessoa Jurídica') ? '' : 'style=display:none' }} id='cnpjGroup'>
                        <x-form-group name='cnpj' value='{{ $fornecedor->pessoa->cnpj }}'>CPNJ</x-form-group>
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
                    <x-form-group name='cep' value="{{ $fornecedor->pessoa->cep }}">CEP</x-form-group>
    
                    <x-form-group name='bairro' value="{{ $fornecedor->pessoa->bairro }}">Bairro</x-form-group>
                </div>
                <div class="col-4">
                    <div class='form-group'>
                        <label for='estado'>Estado</label>
                        <x-select name='estado'>
                            <option></option>
                            <option {{ ($fornecedor->pessoa->estado == 'AC') ? 'selected' : '' }} value="AC">Acre</option>
                            <option {{ ($fornecedor->pessoa->estado == 'AL') ? 'selected' : '' }} value="AL">Alagoas</option>
                            <option {{ ($fornecedor->pessoa->estado == 'AP') ? 'selected' : '' }} value="AP">Amapá</option>
                            <option {{ ($fornecedor->pessoa->estado == 'AM') ? 'selected' : '' }} value="AM">Amazonas</option>
                            <option {{ ($fornecedor->pessoa->estado == 'BA') ? 'selected' : '' }} value="BA">Bahia</option>
                            <option {{ ($fornecedor->pessoa->estado == 'CE') ? 'selected' : '' }} value="CE">Ceará</option>
                            <option {{ ($fornecedor->pessoa->estado == 'DF') ? 'selected' : '' }} value="DF">Distrito Federal</option>
                            <option {{ ($fornecedor->pessoa->estado == 'ES') ? 'selected' : '' }} value="ES">Espírito Santo</option>
                            <option {{ ($fornecedor->pessoa->estado == 'GO') ? 'selected' : '' }} value="GO">Goiás</option>
                            <option {{ ($fornecedor->pessoa->estado == 'MA') ? 'selected' : '' }} value="MA">Maranhão</option>
                            <option {{ ($fornecedor->pessoa->estado == 'MT') ? 'selected' : '' }} value="MT">Mato Grosso</option>
                            <option {{ ($fornecedor->pessoa->estado == 'MS') ? 'selected' : '' }} value="MS">Mato Grosso do Sul</option>
                            <option {{ ($fornecedor->pessoa->estado == 'MG') ? 'selected' : '' }} value="MG">Minas Gerais</option>
                            <option {{ ($fornecedor->pessoa->estado == 'PA') ? 'selected' : '' }} value="PA">Pará</option>
                            <option {{ ($fornecedor->pessoa->estado == 'PB') ? 'selected' : '' }} value="PB">Paraíba</option>
                            <option {{ ($fornecedor->pessoa->estado == 'PR') ? 'selected' : '' }} value="PR">Paraná</option>
                            <option {{ ($fornecedor->pessoa->estado == 'PE') ? 'selected' : '' }} value="PE">Pernambuco</option>
                            <option {{ ($fornecedor->pessoa->estado == 'PI') ? 'selected' : '' }} value="PI">Piauí</option>
                            <option {{ ($fornecedor->pessoa->estado == 'RJ') ? 'selected' : '' }} value="RJ">Rio de Janeiro</option>
                            <option {{ ($fornecedor->pessoa->estado == 'RN') ? 'selected' : '' }} value="RN">Rio Grande do Norte</option>
                            <option {{ ($fornecedor->pessoa->estado == 'RS') ? 'selected' : '' }} value="RS">Rio Grande do Sul</option>
                            <option {{ ($fornecedor->pessoa->estado == 'RO') ? 'selected' : '' }} value="RO">Rondônia</option>
                            <option {{ ($fornecedor->pessoa->estado == 'RR') ? 'selected' : '' }} value="RR">Roraima</option>
                            <option {{ ($fornecedor->pessoa->estado == 'SC') ? 'selected' : '' }} value="SC">Santa Catarina</option>
                            <option {{ ($fornecedor->pessoa->estado == 'SP') ? 'selected' : '' }} value="SP">São Paulo</option>
                            <option {{ ($fornecedor->pessoa->estado == 'SE') ? 'selected' : '' }} value="SE">Sergipe</option>
                            <option {{ ($fornecedor->pessoa->estado == 'TO') ? 'selected' : '' }} value="TO">Tocantins</option>
                        </x-select>
                    </div>
                    
                    <x-form-group name='logradouro' value="{{ $fornecedor->pessoa->logradouro }}">Logradouro</x-form-group>
                
                </div>
            
                <div class="col-4">
                    <div class='form-group'>
                        <label for='municipio'>Município</label>
                        <x-select name='municipio'>
                            @if ($fornecedor->pessoa->municipio)
                                <option value="{{ $fornecedor->pessoa->municipio }}">{{ $fornecedor->pessoa->municipio }}</option>
                            @endif
                        </x-select>
                    </div>
                    <x-form-group name='numero' value="{{ $fornecedor->pessoa->numero }}">Número</x-form-group>
                </div>
            
            </div>
            <x-form-group name='complemento' value="{{ $fornecedor->pessoa->complemento }}">Complemento</x-form-group>
        </div>  
    </div>  

    <div class="card mt-2 mb-2">
        <div class="card-body">
            <h5 class="card-title">Contato</h5>
            <div class="row">
                <div class="col-4">
                    <x-form-group name="telefone" value="{{$fornecedor->pessoa->telefone }}" placeholder="(00)0000-0000">
                        Telefone
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="celular" value="{{$fornecedor->pessoa->celular }}" placeholder="(00)00000-0000">
                        Celular
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="email" type="email" value="{{$fornecedor->pessoa->email }}">
                        E-mail
                    </x-form-group>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <x-form-group name="telefone2" value="{{ $fornecedor->pessoa->telefone2 }}" placeholder="(00)0000-0000">
                        Segundo Telefone
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="celular2" value="{{ $fornecedor->pessoa->celular2 }}" placeholder="(00)00000-0000">
                        Segundo Celular
                    </x-form-group>
                </div>
            </div>
        </div>
    </div>

    <input type="submit" class='btn btn-success'>
</form>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js1/cep.js') }}"></script>
@endsection