<div class="card mt-2 mb-2">
    <div class="card-body">
        <h5 class="card-title">Contato</h5>
        <div class="row">
            <div class="col-4">
                <x-form-group name="telefone" value="{{ old('telefone') }}" placeholder="(00)0000-0000">
                    Telefone
                </x-form-group>
            </div>
            <div class="col-4">
                <x-form-group name="celular" value="{{ old('celular') }}" placeholder="(00)00000-0000">
                    Celular
                </x-form-group>
            </div>
            <div class="col-4">
                <x-form-group name="email" type="email" value="{{ old('email') }}">
                    E-mail
                </x-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <x-form-group name="telefone2" value="{{ old('telefone2') }}" placeholder="(00)0000-0000">
                    Segundo Telefone
                </x-form-group>
            </div>
            <div class="col-4">
                <x-form-group name="celular2" value="{{ old('celular2') }}" placeholder="(00)00000-0000">
                    Segundo Celular
                </x-form-group>
            </div>
        </div>
    </div>
</div>