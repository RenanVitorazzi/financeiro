@extends('layout')
@section('title')
Adicionar parceiro
@endsection
@push('script')
    <script type="text/javascript" src="{{ asset('js1/cep.js') }}"></script>
@endpush

@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('parceiros.index') }}">Parceiros</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>

<form method="POST" action="{{ route('parceiros.update', $parceiro->id)}}">
    @csrf
    @method('PUT')
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Dados Gerais</h5>
            <div class="row">
                <div class="col-4">
                    <x-form-group name='nome' value="{{ $parceiro->pessoa->nome }}">Nome</x-form-group>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="tipoCadastro">Tipo de cadastro</label>
                        <x-select name="tipoCadastro" required>
                            <option value='Pessoa Física' {{ ($parceiro->pessoa->tipoCadastro == 'Pessoa Física') ? 'selected' : '' }} > Pessoa Física</option>
                            <option value='Pessoa Jurídica' {{ ($parceiro->pessoa->tipoCadastro == 'Pessoa Jurídica') ? 'selected' : '' }} > Pessoa Jurídica</option>
                        </x-select>
                    </div>
                </div>
                <div class="col-4">
                    <div {{ ($parceiro->pessoa->tipoCadastro == 'Pessoa Jurídica') ? 'style=display:none' : '' }} id='cpfGroup'>
                        <x-form-group name='cpf' value='{{ $parceiro->pessoa->cpf }}'>CPF</x-form-group>
                    </div>
                    <div {{ ($parceiro->pessoa->tipoCadastro == 'Pessoa Jurídica') ? '' : 'style=display:none' }} id='cnpjGroup'>
                        <x-form-group name='cnpj' value='{{ $parceiro->pessoa->cnpj }}'>CPNJ</x-form-group>
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
                    <x-form-group name='cep' value="{{ $parceiro->pessoa->cep }}">CEP</x-form-group>
    
                    <x-form-group name='bairro' value="{{ $parceiro->pessoa->bairro }}">Bairro</x-form-group>
                </div>
                <div class="col-4">
                    <div class='form-group'>
                        <label for='estado'>Estado</label>
                        <x-select name='estado'>
                            <option></option>
                            <option {{ ($parceiro->pessoa->estado == 'AC') ? 'selected' : '' }} value="AC">Acre</option>
                            <option {{ ($parceiro->pessoa->estado == 'AL') ? 'selected' : '' }} value="AL">Alagoas</option>
                            <option {{ ($parceiro->pessoa->estado == 'AP') ? 'selected' : '' }} value="AP">Amapá</option>
                            <option {{ ($parceiro->pessoa->estado == 'AM') ? 'selected' : '' }} value="AM">Amazonas</option>
                            <option {{ ($parceiro->pessoa->estado == 'BA') ? 'selected' : '' }} value="BA">Bahia</option>
                            <option {{ ($parceiro->pessoa->estado == 'CE') ? 'selected' : '' }} value="CE">Ceará</option>
                            <option {{ ($parceiro->pessoa->estado == 'DF') ? 'selected' : '' }} value="DF">Distrito Federal</option>
                            <option {{ ($parceiro->pessoa->estado == 'ES') ? 'selected' : '' }} value="ES">Espírito Santo</option>
                            <option {{ ($parceiro->pessoa->estado == 'GO') ? 'selected' : '' }} value="GO">Goiás</option>
                            <option {{ ($parceiro->pessoa->estado == 'MA') ? 'selected' : '' }} value="MA">Maranhão</option>
                            <option {{ ($parceiro->pessoa->estado == 'MT') ? 'selected' : '' }} value="MT">Mato Grosso</option>
                            <option {{ ($parceiro->pessoa->estado == 'MS') ? 'selected' : '' }} value="MS">Mato Grosso do Sul</option>
                            <option {{ ($parceiro->pessoa->estado == 'MG') ? 'selected' : '' }} value="MG">Minas Gerais</option>
                            <option {{ ($parceiro->pessoa->estado == 'PA') ? 'selected' : '' }} value="PA">Pará</option>
                            <option {{ ($parceiro->pessoa->estado == 'PB') ? 'selected' : '' }} value="PB">Paraíba</option>
                            <option {{ ($parceiro->pessoa->estado == 'PR') ? 'selected' : '' }} value="PR">Paraná</option>
                            <option {{ ($parceiro->pessoa->estado == 'PE') ? 'selected' : '' }} value="PE">Pernambuco</option>
                            <option {{ ($parceiro->pessoa->estado == 'PI') ? 'selected' : '' }} value="PI">Piauí</option>
                            <option {{ ($parceiro->pessoa->estado == 'RJ') ? 'selected' : '' }} value="RJ">Rio de Janeiro</option>
                            <option {{ ($parceiro->pessoa->estado == 'RN') ? 'selected' : '' }} value="RN">Rio Grande do Norte</option>
                            <option {{ ($parceiro->pessoa->estado == 'RS') ? 'selected' : '' }} value="RS">Rio Grande do Sul</option>
                            <option {{ ($parceiro->pessoa->estado == 'RO') ? 'selected' : '' }} value="RO">Rondônia</option>
                            <option {{ ($parceiro->pessoa->estado == 'RR') ? 'selected' : '' }} value="RR">Roraima</option>
                            <option {{ ($parceiro->pessoa->estado == 'SC') ? 'selected' : '' }} value="SC">Santa Catarina</option>
                            <option {{ ($parceiro->pessoa->estado == 'SP') ? 'selected' : '' }} value="SP">São Paulo</option>
                            <option {{ ($parceiro->pessoa->estado == 'SE') ? 'selected' : '' }} value="SE">Sergipe</option>
                            <option {{ ($parceiro->pessoa->estado == 'TO') ? 'selected' : '' }} value="TO">Tocantins</option>
                        </x-select>
                    </div>
                    
                    <x-form-group name='logradouro' value="{{ $parceiro->pessoa->logradouro }}">Logradouro</x-form-group>
                
                </div>
            
                <div class="col-4">
                    <div class='form-group'>
                        <label for='municipio'>Município</label>
                        <x-select name='municipio'>
                            @if ($parceiro->pessoa->municipio)
                                <option value="{{ $parceiro->pessoa->municipio }}">{{ $parceiro->pessoa->municipio }}</option>
                            @endif
                        </x-select>
                    </div>
                    <x-form-group name='numero' value="{{ $parceiro->pessoa->numero }}">Número</x-form-group>
                </div>
            
            </div>
            <x-form-group name='complemento' value="{{ $parceiro->pessoa->complemento }}">Complemento</x-form-group>
        </div>  
    </div>  

    <div class="card mt-2 mb-2">
        <div class="card-body">
            <h5 class="card-title">Contato</h5>
            <div class="row">
                <div class="col-4">
                    <x-form-group name="telefone" value="{{$parceiro->pessoa->telefone }}" placeholder="(00)0000-0000">
                        Telefone
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="celular" value="{{$parceiro->pessoa->celular }}" placeholder="(00)00000-0000">
                        Celular
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="email" type="email" value="{{$parceiro->pessoa->email }}">
                        E-mail
                    </x-form-group>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <x-form-group name="telefone2" value="{{ $parceiro->pessoa->telefone2 }}" placeholder="(00)0000-0000">
                        Segundo Telefone
                    </x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="celular2" value="{{ $parceiro->pessoa->celular2 }}" placeholder="(00)00000-0000">
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
                    <x-form-group type="number" step="0.01" name='porcentagem_padrao' value="{{ $parceiro->porcentagem_padrao }}">Taxa Padrão (%)</x-form-group>
                </div>
            </div> 
        </div>
    </div>

    <input type="submit" class='btn btn-success'>
</form>
@endsection