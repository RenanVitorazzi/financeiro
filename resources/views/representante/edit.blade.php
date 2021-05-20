@extends('layout')
@section('title')
Editar representante
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('representantes.index') }}">Representantes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>

<form method="POST" action="{{ route('representantes.update', $representante->id)}}">
    @csrf
    @method('PUT')
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Dados Gerais</h5>
            <div class="row">
                <div class="col-4">
                    <x-form-group name='nome' value="{{ $representante->pessoa->nome }}">Nome</x-form-group>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="tipoCadastro">Tipo de cadastro</label>
                        <x-select name="tipoCadastro" required>
                            <option value='Pessoa Física' {{ ($representante->pessoa->tipoCadastro == 'Pessoa Física') ? 'selected' : '' }} > Pessoa Física</option>
                            <option value='Pessoa Jurídica' {{ ($representante->pessoa->tipoCadastro == 'Pessoa Jurídica') ? 'selected' : '' }} > Pessoa Jurídica</option>
                        </x-select>
                    </div>
                </div>
                <div class="col-4">
                    <div {{ ($representante->pessoa->tipoCadastro == 'Pessoa Jurídica') ? 'style=display:none' : '' }} id='cpfGroup'>
                        <x-form-group name='cpf' value='{{ $representante->pessoa->cpf }}'>CPF</x-form-group>
                    </div>
                    <div {{ ($representante->pessoa->tipoCadastro == 'Pessoa Jurídica') ? '' : 'style=display:none' }} id='cnpjGroup'>
                        <x-form-group name='cnpj' value='{{ $representante->pessoa->cnpj }}'>CPNJ</x-form-group>
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
                    <x-form-group name='cep' value="{{ $representante->pessoa->cep }}">CEP</x-form-group>
    
                    <x-form-group name='bairro' value="{{ $representante->pessoa->bairro }}">Bairro</x-form-group>
                </div>
                <div class="col-4">
                    <div class='form-group'>
                        <label for='estado'>Estado</label>
                        <x-select name='estado'>
                            <option></option>
                            <option {{ ($representante->pessoa->estado == 'AC') ? 'selected' : '' }} value="AC">Acre</option>
                            <option {{ ($representante->pessoa->estado == 'AL') ? 'selected' : '' }} value="AL">Alagoas</option>
                            <option {{ ($representante->pessoa->estado == 'AP') ? 'selected' : '' }} value="AP">Amapá</option>
                            <option {{ ($representante->pessoa->estado == 'AM') ? 'selected' : '' }} value="AM">Amazonas</option>
                            <option {{ ($representante->pessoa->estado == 'BA') ? 'selected' : '' }} value="BA">Bahia</option>
                            <option {{ ($representante->pessoa->estado == 'CE') ? 'selected' : '' }} value="CE">Ceará</option>
                            <option {{ ($representante->pessoa->estado == 'DF') ? 'selected' : '' }} value="DF">Distrito Federal</option>
                            <option {{ ($representante->pessoa->estado == 'ES') ? 'selected' : '' }} value="ES">Espírito Santo</option>
                            <option {{ ($representante->pessoa->estado == 'GO') ? 'selected' : '' }} value="GO">Goiás</option>
                            <option {{ ($representante->pessoa->estado == 'MA') ? 'selected' : '' }} value="MA">Maranhão</option>
                            <option {{ ($representante->pessoa->estado == 'MT') ? 'selected' : '' }} value="MT">Mato Grosso</option>
                            <option {{ ($representante->pessoa->estado == 'MS') ? 'selected' : '' }} value="MS">Mato Grosso do Sul</option>
                            <option {{ ($representante->pessoa->estado == 'MG') ? 'selected' : '' }} value="MG">Minas Gerais</option>
                            <option {{ ($representante->pessoa->estado == 'PA') ? 'selected' : '' }} value="PA">Pará</option>
                            <option {{ ($representante->pessoa->estado == 'PB') ? 'selected' : '' }} value="PB">Paraíba</option>
                            <option {{ ($representante->pessoa->estado == 'PR') ? 'selected' : '' }} value="PR">Paraná</option>
                            <option {{ ($representante->pessoa->estado == 'PE') ? 'selected' : '' }} value="PE">Pernambuco</option>
                            <option {{ ($representante->pessoa->estado == 'PI') ? 'selected' : '' }} value="PI">Piauí</option>
                            <option {{ ($representante->pessoa->estado == 'RJ') ? 'selected' : '' }} value="RJ">Rio de Janeiro</option>
                            <option {{ ($representante->pessoa->estado == 'RN') ? 'selected' : '' }} value="RN">Rio Grande do Norte</option>
                            <option {{ ($representante->pessoa->estado == 'RS') ? 'selected' : '' }} value="RS">Rio Grande do Sul</option>
                            <option {{ ($representante->pessoa->estado == 'RO') ? 'selected' : '' }} value="RO">Rondônia</option>
                            <option {{ ($representante->pessoa->estado == 'RR') ? 'selected' : '' }} value="RR">Roraima</option>
                            <option {{ ($representante->pessoa->estado == 'SC') ? 'selected' : '' }} value="SC">Santa Catarina</option>
                            <option {{ ($representante->pessoa->estado == 'SP') ? 'selected' : '' }} value="SP">São Paulo</option>
                            <option {{ ($representante->pessoa->estado == 'SE') ? 'selected' : '' }} value="SE">Sergipe</option>
                            <option {{ ($representante->pessoa->estado == 'TO') ? 'selected' : '' }} value="TO">Tocantins</option>
                        </x-select>
                    </div>
                    
                    <x-form-group name='logradouro' value="{{ $representante->pessoa->logradouro }}">Logradouro</x-form-group>
                
                </div>
            
                <div class="col-4">
                    <div class='form-group'>
                        <label for='municipio'>Município</label>
                        <x-select name='municipio'>
                            @if ($representante->pessoa->municipio)
                                <option value="{{ $representante->pessoa->municipio }}">{{ $representante->pessoa->municipio }}</option>
                            @endif
                        </x-select>
                    </div>
                    <x-form-group name='numero' value="{{ $representante->pessoa->numero }}">Número</x-form-group>
                </div>
            
            </div>
            <x-form-group name='complemento' value="{{ $representante->pessoa->complemento }}">Complemento</x-form-group>
        </div>  
    </div>  

    <div class="card mt-2 mb-2">
        <div class="card-body">
            <h5 class="card-title">Contato</h5>
            <div class="row">
                <div class="col-4">
                    <x-form-group name="telefone" value="{{$representante->pessoa->telefone }}" placeholder="(00)0000-0000">
                        Telefone
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="celular" value="{{$representante->pessoa->celular }}" placeholder="(00)00000-0000">
                        Celular
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="email" type="email" value="{{$representante->pessoa->email }}">
                        E-mail
                    </x-form-group>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <x-form-group name="telefone2" value="{{ $representante->pessoa->telefone2 }}" placeholder="(00)0000-0000">
                        Segundo Telefone
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="celular2" value="{{ $representante->pessoa->celular2 }}" placeholder="(00)00000-0000">
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