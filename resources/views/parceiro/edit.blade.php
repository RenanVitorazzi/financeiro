@extends('layout')
@section('title')
Adicionar representante
@endsection
@push('script')
    <script type="text/javascript" src="{{ asset('js/cep.js') }}"></script>
@endpush

@section('body')
    <form method="POST" action="{{ route('parceiros.update', $parceiro->id)}}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <x-form-group name='nome' value='{{ $parceiro->pessoa->nome }}'>Nome completo</x-form-group>
            </div>
            <div class="col-md-6">
                <x-form-group name='nascimento' type='date' value='{{ $parceiro->pessoa->nascimento }}'>Data de nascimento</x-form-group>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipoCadastro">Tipo de cadastro</label>
                    <select type="text" name="tipoCadastro" id="tipoCadastro" class="form-control" required>
                        {{ ($parceiro->pessoa->tipoCadastro == 'Pessoa Física') ? 'selected' : '' }}
                        {{ ($parceiro->pessoa->tipoCadastro == 'Pessoa Jurídica') ? 'selected' : '' }}
                        <option value='Pessoa Física'  > Pessoa Física</option>
                        <option value='Pessoa Jurídica' > Pessoa Jurídica</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div id='cpfGroup'>
                    <x-form-group name='cpf' value='{{ $parceiro->pessoa->cpf }}'>CPF</x-form-group>
                </div>
                <div style='display:none' id='cnpjGroup'>
                    <x-form-group name='cnpj' value='{{ $parceiro->pessoa->cnpj }}'>CPNJ</x-form-group>
                </div>
            </div>
        </div> 

        <div>
            <div class='row'>
                <div class="col-6">
                    <x-form-group name='cep' value='{{ $parceiro->pessoa->cep }}'>CEP</x-form-group>
                    
                    <div class='form-group'>
                        <label for='municipio'>Município</label>
                        <select class='form-control' name='municipio' id='municipio'>
                            @if (isset($parceiro->pessoa->municipio))
                                <option value='{{ $parceiro->pessoa->municipio }}'></option>
                            @endif
                        </select>
                    </div>
        
                    <x-form-group name='bairro' value='{{ $parceiro->pessoa->bairro }}'>Bairro</x-form-group>
                </div>
                <div class="col-6">
                    <div class='form-group'>
                        <label for='estado'>Estado</label>
                        <select class='form-control' name='estado' id='estado'>
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
                        </select>
                    </div>
                    <x-form-group name='logradouro' value='{{ $parceiro->pessoa->logradouro }}'>Logradouro</x-form-group>
                    <x-form-group name='numero' value='{{ $parceiro->pessoa->numero }}'>Número</x-form-group>
                </div>   
            </div>
            <x-form-group name='complemento' value='{{ $parceiro->pessoa->complemento }}'>Complemento</x-form-group>
        </div>  

        <div class="row">
            <div class="col-md-6">
                <x-form-group name='telefone' value='{{ $parceiro->pessoa->telefone }}'>Telefone com DDD</x-form-group>
            </div>
            <div class="col-md-6">
                <x-form-group name='celular' value='{{ $parceiro->pessoa->celular }}'>Celular com DDD</x-form-group>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <x-form-group name='porcentagem_padrao' value="{{ $parceiro->porcentagem_padrao }}">Taxa Padrão (%)</x-form-group>
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