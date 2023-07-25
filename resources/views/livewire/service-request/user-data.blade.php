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
                    <input type="text" class="form-control" id="for-name" wire:model.defer="user.name">
                </div>
                <div class="col-md-3">
                    <label for="for-fathers_family">Apellido P.</label>
                    <input type="text" class="form-control" id="for-fathers_family" wire:model.defer="user.fathers_family">
                </div>
                <div class="col-md-3">
                    <label for="for-mothers_family">Apellido M.</label>
                    <input type="text" class="form-control" id="for-mothers_family" wire:model.defer="user.mothers_family">
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
                    <input type="text" class="form-control" id="for-address" wire:model.defer="user.address">
                </div>
                <div class="col-md-2">
                    <label for="for-commune_id">Comuna</label>
                    <select wire:model.defer="user.commune_id" class="form-control">
                        <option value=""></option>
                        @foreach($communes->sort() as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="for-phone_number">Telefono</label>
                    <input type="text" class="form-control" id="for-phone_number" wire:model.defer="user.phone_number">
                </div>
                <div class="col-md-4">
                    <label for="for-email_personal">Email Personal</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Email personal" wire:model.defer="user.email_personal" @disabled($user->email_verified_at)>
                        <div class="input-group-append">
                            @if($user->email_verified_at)
                            <button class="btn btn-success" title="Email verificado" disabled type="button">
                                <i class="fas fa-envelope"></i>
                            </button>
                            @else
                            <button class="btn btn-warning" title="Verificar email" type="button" wire:click="sendEmailVerification">
                                <i class="fas fa-envelope"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.partials.errors')
            @include('layouts.partials.flash_message')
        </div>
    </div>
</div>