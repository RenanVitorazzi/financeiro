@extends('layout')
@section('title')
Adicionar representante
@endsection
@push('script')
    <script type="text/javascript" src="{{ asset('js/cep.js') }}"></script>
@endpush

@section('body')
    <form method="POST" action="{{ route('fornecedores.update', $fornecedor->id)}}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <x-form-group name='nome' value='{{ $fornecedor->pessoa->nome }}'>Nome completo</x-form-group>
            </div>
            <div class="col-md-6">
                <x-form-group name='nascimento' type='date' value='{{ $fornecedor->pessoa->nascimento }}'>Data de nascimento</x-form-group>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipoCadastro">Tipo de cadastro</label>
                    <select type="text" name="tipoCadastro" id="tipoCadastro" class="form-control" required>
                        {{ ($fornecedor->pessoa->tipoCadastro == 'Pessoa Física') ? 'selected' : '' }}
                        {{ ($fornecedor->pessoa->tipoCadastro == 'Pessoa Jurídica') ? 'selected' : '' }}
                        <option value='Pessoa Física'  > Pessoa Física</option>
                        <option value='Pessoa Jurídica' > Pessoa Jurídica</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div id='cpfGroup'>
                    <x-form-group name='cpf' value='{{ $fornecedor->pessoa->cpf }}'>CPF</x-form-group>
                </div>
                <div style='display:none' id='cnpjGroup'>
                    <x-form-group name='cnpj' value='{{ $fornecedor->pessoa->cnpj }}'>CPNJ</x-form-group>
                </div>
            </div>
        </div> 

        <div>
            <div class='row'>
                <div class="col-6">
                    <x-form-group name='cep' value='{{ $fornecedor->pessoa->cep }}'>CEP</x-form-group>
                    
                    <div class='form-group'>
                        <label for='municipio'>Município</label>
                        <select class='form-control' name='municipio' id='municipio'>
                            @if (isset($fornecedor->pessoa->municipio))
                                <option value='{{ $fornecedor->pessoa->municipio }}'></option>
                            @endif
                        </select>
                    </div>
        
                    <x-form-group name='bairro' value='{{ $fornecedor->pessoa->bairro }}'>Bairro</x-form-group>
                </div>
                <div class="col-6">
                    <div class='form-group'>
                        <label for='estado'>Estado</label>
                        <select class='form-control' name='estado' id='estado'>
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
                        </select>
                    </div>
                    <x-form-group name='logradouro' value='{{ $fornecedor->pessoa->logradouro }}'>Logradouro</x-form-group>
                    <x-form-group name='numero' value='{{ $fornecedor->pessoa->numero }}'>Número</x-form-group>
                </div>   
            </div>
            <x-form-group name='complemento' value='{{ $fornecedor->pessoa->complemento }}'>Complemento</x-form-group>
        </div>  

        <div class="row">
            <div class="col-md-6">
                <x-form-group name='telefone' value='{{ $fornecedor->pessoa->telefone }}'>Telefone com DDD</x-form-group>
            </div>
            <div class="col-md-6">
                <x-form-group name='celular' value='{{ $fornecedor->pessoa->celular }}'>Celular com DDD</x-form-group>
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