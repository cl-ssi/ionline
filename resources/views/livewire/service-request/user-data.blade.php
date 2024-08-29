<div>
    <!-- Datos Personales -->
    <div class="card mb-3">
        <div class="card-body">
            <h4 class="card-title">Datos Personales</h4>
            <div class="form-row mb-3">
                <div class="col-md-2">
                    <label for="for-run">RUN</label>
                    <input type="text" class="form-control" id="for-run" disabled value="{{ $user->runFormat() }}">
                </div>
                <div class="col-md-3">
                    <label for="for-name">Nombres</label>
                    <input type="text" class="form-control" id="for-name" wire:model="user.name">
                </div>
                <div class="col-md-2">
                    <label for="for-fathers_family">Apellido P.</label>
                    <input type="text" class="form-control" id="for-fathers_family" wire:model="user.fathers_family">
                </div>
                <div class="col-md-2">
                    <label for="for-mothers_family">Apellido M.</label>
                    <input type="text" class="form-control" id="for-mothers_family" wire:model="user.mothers_family">
                </div>
                <div class="col-md-2">
                    <label for="for-commune_id">Nacionalidad</label>
                    <select wire:model="user.country_id" class="form-control">
                        <option value=""></option>
                        @foreach($countries->sort() as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-1">
                    <label for=""><br></label>
                    <button type="button" class="btn btn-primary form-control" wire:click="save">
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-4">
                    <label for="for-address">Dirección </label>
                    <input type="text" class="form-control" id="for-address" wire:model="user.address">
                </div>
                <div class="col-md-2">
                    <label for="for-commune_id">Comuna</label>
                    <select wire:model="user.commune_id" class="form-control">
                        <option value=""></option>
                        @foreach($communes->sort() as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="for-phone_number">Telefono</label>
                    <input type="text" class="form-control" id="for-phone_number" wire:model="user.phone_number">
                </div>
                @livewire('rrhh.personal-email-input',['user' => $user])
            </div>

            @include('layouts.bt4.partials.errors')
            @include('layouts.bt4.partials.flash_message_custom',[
                'name' => 'user-data',  // debe ser único
                'type' => 'primary' // optional: 'primary' (default), 'danger', 'warning', 'success', 'info'
            ])
        </div>
    </div>
</div>