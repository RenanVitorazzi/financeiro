<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title">Dados Gerais</h5>
        <div class="row">
            <div class="col-4">
                <x-form-group name='nome' autofocus value="{{ old('nome') }}">Nome</x-form-group>
            </div>
            {{-- <div class="col-md-6">
                <x-form-group name='nascimento' type='date' value="{{ old('nascimento') }}">Data de nascimento</x-form-group>
            </div> --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="tipoCadastro">Tipo de cadastro</label>
                    <x-select name="tipoCadastro" required>
                        <option value='Pessoa Física' {{ (old('tipoCadastro') == 'Pessoa Física') ? 'selected' : '' }} > Pessoa Física</option>
                        <option value='Pessoa Jurídica' {{ (old('tipoCadastro') == 'Pessoa Jurídica') ? 'selected' : '' }} > Pessoa Jurídica</option>
                    </x-select>
                </div>
            </div>
            <div class="col-4">
                <div {{ (old('tipoCadastro') == 'Pessoa Jurídica') ? 'style=display:none' : '' }} id='cpfGroup'>
                    <x-form-group name='cpf'>CPF</x-form-group>
                </div>
                <div {{ (old('tipoCadastro') == 'Pessoa Jurídica') ? '' : 'style=display:none' }} id='cnpjGroup'>
                    <x-form-group name='cnpj'>CPNJ</x-form-group>
                </div>
            </div>
        </div> 
    </div> 
</div> 