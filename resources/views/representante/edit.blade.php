@extends('layout')
@section('title')
Adicionar representante
@endsection
@push('script')
    <script type="text/javascript" src="{{ asset('js/cep.js') }}"></script>
@endpush

@section('body')
    <form method="POST" action="{{ route('representantes.update', $representante->id)}}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <x-form-group name='nome' value='{{ $representante->pessoa->nome }}'>Nome completo</x-form-group>
            </div>
            <div class="col-md-6">
                <x-form-group name='nascimento' type='date' value='{{ $representante->pessoa->nascimento }}'>Data de nascimento</x-form-group>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipoCadastro">Tipo de cadastro</label>
                    <select type="text" name="tipoCadastro" id="tipoCadastro" class="form-control" required>
                        {{ ($representante->pessoa->tipoCadastro == 'Pessoa Física') ? 'selected' : '' }}
                        {{ ($representante->pessoa->tipoCadastro == 'Pessoa Jurídica') ? 'selected' : '' }}
                        <option value='Pessoa Física'  > Pessoa Física</option>
                        <option value='Pessoa Jurídica' > Pessoa Jurídica</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div id='cpfGroup'>
                    <x-form-group name='cpf' value='{{ $representante->pessoa->cpf }}'>CPF</x-form-group>
                </div>
                <div style='display:none' id='cnpjGroup'>
                    <x-form-group name='cnpj' value='{{ $representante->pessoa->cnpj }}'>CPNJ</x-form-group>
                </div>
            </div>
        </div> 

        <div>
            <div class='row'>
                <div class="col-6">
                    <x-form-group name='cep' value='{{ $representante->pessoa->cep }}'>CEP</x-form-group>
                    
                    <div class='form-group'>
                        <label for='municipio'>Município</label>
                        <select class='form-control' name='municipio' id='municipio'>
                            @if (isset($representante->pessoa->municipio))
                                <option value='{{ $representante->pessoa->municipio }}'></option>
                            @endif
                        </select>
                    </div>
        
                    <x-form-group name='bairro' value='{{ $representante->pessoa->bairro }}'>Bairro</x-form-group>
                </div>
                <div class="col-6">
                    <div class='form-group'>
                        <label for='estado'>Estado</label>
                        <select class='form-control' name='estado' id='estado'>
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
                        </select>
                    </div>
                    <x-form-group name='logradouro' value='{{ $representante->pessoa->logradouro }}'>Logradouro</x-form-group>
                    <x-form-group name='numero' value='{{ $representante->pessoa->numero }}'>Número</x-form-group>
                </div>   
            </div>
            <x-form-group name='complemento' value='{{ $representante->pessoa->complemento }}'>Complemento</x-form-group>
        </div>  

        <div class="row">
            <div class="col-md-6">
                <x-form-group name='telefone' value='{{ $representante->pessoa->telefone }}'>Telefone com DDD</x-form-group>
            </div>
            <div class="col-md-6">
                <x-form-group name='celular' value='{{ $representante->pessoa->celular }}'>Celular com DDD</x-form-group>
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