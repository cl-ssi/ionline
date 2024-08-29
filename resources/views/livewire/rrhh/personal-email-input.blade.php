<div class="col col-md">
    <label for="for-email">Email Personal</label>
    <div class="input-group">
        <input type="text" class="form-control" name="email_personal" placeholder="Email personal" wire:model="user.email_personal" @disabled($user->hasVerifiedEmail())>
        @can('Users: send mail verification')
            @if(!$user->hasVerifiedEmail())
                @if($user->email_personal)
                    <button class="btn btn-warning" title="Verificar email" type="button" wire:click="sendEmailVerification">
                        <i class="fas fa-envelope"></i>
                    </button>
                @else
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-envelope" title="No tiene agregado correo electrónico personal"></i>
                    </button>
                @endif
            @else
                @livewire('rrhh.unverify-personal-email', ['user' => $user], key($user->id))
            @endif
        @endcan
    </div>

    @include('layouts.bt5.partials.errors')
    @include('layouts.bt4.partials.flash_message_custom',[
        'name' => 'personal-email-input',  // debe ser único
        'type' => 'primary' // optional: 'primary' (default), 'danger', 'warning', 'success', 'info'
    ])
</div>
