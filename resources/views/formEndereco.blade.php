<div>
    <div class='row'>
        <div class="col-6">
            <x-form-group name='cep'
            value="{{ old('cep') }}">CEP</x-form-group>
            
            <div class='form-group'>
                <label for='municipio'>Município</label>
                <select class='form-control' name='municipio' id='municipio'>
                    
                </select>
            </div>

            <x-form-group name='bairro' value="{{ old('bairro') }}">Bairro</x-form-group>
        </div>
        <div class="col-6">
            <div class='form-group'>
                <label for='estado'>Estado</label>
                <select class='form-control' name='estado' id='estado'>
                    <option></option>
                    <option {{ (old('estado') == 'AC') ? 'selected' : '' }} value="AC">Acre</option>
                    <option {{ (old('estado') == 'AL') ? 'selected' : '' }} value="AL">Alagoas</option>
                    <option {{ (old('estado') == 'AP') ? 'selected' : '' }} value="AP">Amapá</option>
                    <option {{ (old('estado') == 'AM') ? 'selected' : '' }} value="AM">Amazonas</option>
                    <option {{ (old('estado') == 'BA') ? 'selected' : '' }} value="BA">Bahia</option>
                    <option {{ (old('estado') == 'CE') ? 'selected' : '' }} value="CE">Ceará</option>
                    <option {{ (old('estado') == 'DF') ? 'selected' : '' }} value="DF">Distrito Federal</option>
                    <option {{ (old('estado') == 'ES') ? 'selected' : '' }} value="ES">Espírito Santo</option>
                    <option {{ (old('estado') == 'GO') ? 'selected' : '' }} value="GO">Goiás</option>
                    <option {{ (old('estado') == 'MA') ? 'selected' : '' }} value="MA">Maranhão</option>
                    <option {{ (old('estado') == 'MT') ? 'selected' : '' }} value="MT">Mato Grosso</option>
                    <option {{ (old('estado') == 'MS') ? 'selected' : '' }} value="MS">Mato Grosso do Sul</option>
                    <option {{ (old('estado') == 'MG') ? 'selected' : '' }} value="MG">Minas Gerais</option>
                    <option {{ (old('estado') == 'PA') ? 'selected' : '' }} value="PA">Pará</option>
                    <option {{ (old('estado') == 'PB') ? 'selected' : '' }} value="PB">Paraíba</option>
                    <option {{ (old('estado') == 'PR') ? 'selected' : '' }} value="PR">Paraná</option>
                    <option {{ (old('estado') == 'PE') ? 'selected' : '' }} value="PE">Pernambuco</option>
                    <option {{ (old('estado') == 'PI') ? 'selected' : '' }} value="PI">Piauí</option>
                    <option {{ (old('estado') == 'RJ') ? 'selected' : '' }} value="RJ">Rio de Janeiro</option>
                    <option {{ (old('estado') == 'RN') ? 'selected' : '' }} value="RN">Rio Grande do Norte</option>
                    <option {{ (old('estado') == 'RS') ? 'selected' : '' }} value="RS">Rio Grande do Sul</option>
                    <option {{ (old('estado') == 'RO') ? 'selected' : '' }} value="RO">Rondônia</option>
                    <option {{ (old('estado') == 'RR') ? 'selected' : '' }} value="RR">Roraima</option>
                    <option {{ (old('estado') == 'SC') ? 'selected' : '' }} value="SC">Santa Catarina</option>
                    <option {{ (old('estado') == 'SP') ? 'selected' : '' }} value="SP">São Paulo</option>
                    <option {{ (old('estado') == 'SE') ? 'selected' : '' }} value="SE">Sergipe</option>
                    <option {{ (old('estado') == 'TO') ? 'selected' : '' }} value="TO">Tocantins</option>
                </select>
            </div>
            <x-form-group name='logradouro' value="{{ old('logradouro') }}">Logradouro</x-form-group>
            <x-form-group name='numero' value="{{ old('numero') }}">Número</x-form-group>
        </div>   
    </div>
    <x-form-group name='complemento' value="{{ old('complemento') }}">Complemento</x-form-group>
</div>  