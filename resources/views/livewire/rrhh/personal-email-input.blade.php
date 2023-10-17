<div class="form-group col col-md">
    <label for="for-email">Email Personal</label>
    
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="email_personal" placeholder="Email personal" wire:model.defer="user.email_personal" @disabled($user->hasVerifiedEmail())>
        @can('Users: send mail verification')
            <div class="input-group-append">
                @if(!$user->hasVerifiedEmail())
                    @if($user->email_personal)
                        <button class="btn btn-warning" title="Verificar email" type="button" wire:click="sendEmailVerification">
                            <i class="fas fa-envelope"></i>
                        </button>
                    @else
                        <button class="btn btn-sm btn-secondary" disabled>
                            <i class="fas fa-envelope" title="No tiene agregado correo electrónico personal"></i>
                        </button>
                    @endif
                @else
                    <button class="btn btn-sm btn-outline-success" disabled>
                        <i class="fas fa-envelope" title="Correo electrónico personal verificado"></i>
                    </button>

                    @livewire('rrhh.unverify-personal-email', ['user' => $user], key($user->id))
                @endif
            </div>
        @endcan
    </div>

    @include('layouts.bt4.partials.errors')
    @include('layouts.bt4.partials.flash_message_custom',[
        'name' => 'personal-email-input',  // debe ser único
        'type' => 'primary' // optional: 'primary' (default), 'danger', 'warning', 'success', 'info'
    ])
</div>
