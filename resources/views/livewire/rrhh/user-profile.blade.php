<div>
    @include('layouts.bt5.partials.flash_message')

    <h3 class="mb-3">Mi Perfil</h3>

    <div class="row g-2 mb-3">
        <div class="form-group col-md-2">
            <label for="run">RUN</label>
            <input type="text" readonly class="form-control-plaintext" id="staticRUN" value="{{ $user->runFormat() }}">
        </div>
        <div class="form-group col-md-3">
            <label for="name">Nombres*</label>
            <input type="text" class="form-control" wire:model.defer="user.name">
        </div>
        <div class="form-group col-md-2">
            <label for="name">Apellido Paterno*</label>
            <input type="text" class="form-control" wire:model.defer="user.fathers_family">
        </div>
        <div class="form-group col-md-2">
            <label for="name">Apellido Materno*</label>
            <input type="text" class="form-control" wire:model.defer="user.mothers_family">
        </div>

        <div class="form-group col-md-1">
            <label for="name">Sexo</label>
            <select class="form-select" wire:model.defer="user.gender">
                <option value=""></option>
                <option value="male">Masculino</option>
                <option value="female">Femenino</option>
            </select>
        </div>

        <fieldset class="form-group col-md-2">
            <label for="forbirthday">Fecha Nacimiento</label>
            <input type="date" class="form-control" id="forbirthday" wire:model.defer="user.birthday">
        </fieldset>

    </div>

    <div class="row g-2 mb-3">
        <fieldset class="form-group col-md-12">
            <label for="forOrganizationalUnit">Establecimiento / Unidad Organizacional</label>
                @livewire('select-organizational-unit', [
                    'establishment_id' => optional($user->organizationalUnit)->establishment_id, 
                    'organizational_unit_id' => optional($user->organizationalUnit)->id,
                    'select_id' => 'organizationalunit',
                    'aditional_ous' => [53]
                ])
        </fieldset>
    </div>

    <div class="row g-2 mb-3">
        <fieldset class="form-group col-12 col-md-6">
            <label for="forPosition">Función que desempeña</label>
            <input type="text" class="form-control" id="forPosition" placeholder="Subdirector(S), Enfermera, Referente..., Jefe." 
                value="{{ $user->position }}">
        </fieldset>

        <div class="form-group col-12 col-md-4">
            <label for="email">Email Institucional</label>
            <input type="email" class="form-control" value="{{$user->email}}">
        </div>
    </div>

    <hr>
    <h5>Datos de contacto</h5>

    <div class="row g-2 mb-3">
        <div class="form-group col-11 col-md-4">
            <label for="for-address">Dirección</label>
            <input type="text" class="form-control" wire:model.defer="user.address">
        </div>
        <div class="form-group col-11 col-md-2">
            <label for="for-commune_id">Comuna</label>
            <select class="form-select" wire:model.defer="user.commune_id">
                <option value=""></option>
                @foreach($communes->sort() as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-11 col-md-2">
            <label for="for-phone_number">Número de teléfono</label>
            <input type="text" class="form-control" wire:model.defer="user.phone_number">
        </div>
        @livewire('rrhh.personal-email-input',['user' => $user])
    </div>


    <hr>
    <h5>Datos bancarios</h5>

    <div class="row g-2 mb-3"> <!--Start Row -->
        <fieldset class="col-12 col-md-5">
            <label>Banco</label>
            <select wire:model.defer="bankAccount.bank_id" class="form-select">
                <option value="">Seleccionar Banco</option>
                @foreach($banks->sort() as $id => $bank)
                <option value="{{ $id }}">{{ $bank }}</option>
                @endforeach
            </select>
            @error('bankAccount.bank_id') <span class="text-danger">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label>Número de Cuenta</label>
            <input type="number" wire:model.defer="bankAccount.number" class="form-control">
            @error('bankAccount.account_number') <span class="text-danger">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_pay_method">Tipo de cuenta</label>
            <select wire:model.defer="bankAccount.type" class="form-select">
            <option value="">Seleccionar Forma de Pago</option>
            <option value="01">CTA CORRIENTE / CTA VISTA</option>
            <option value="02">CTA AHORRO</option>
            <option value="30">CUENTA RUT</option>
            </select>
            @error('bankAccount.pay_method') <span class="text-danger">{{ $message }}</span> @enderror
        </fieldset>

    </div><!--End Row -->

    <button class="btn btn-primary" wire:click="save">
        <span wire:loading.class="d-none">Guardar</span>
        <span wire:loading class="spinner-border spinner-border-sm" width="200"></span>
    </button>
</div>
