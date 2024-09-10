<div>
    @section('title', 'Asignar roles a Usuario')

    @include('rrhh.submenu')

    <h3 class="mb-3">Roles</h3>

    <div class="alert alert-info" role="alert">
        <li>Los roles agrupan un conjunto de permisos. </li>
        <li>Si asignas un rol a un usuario, este obtendrá todos los permisos asociados a ese rol.</li>
        <li>Si quitas el rol de un usuario, esto no desactivará los permisos que tenga asociado indivudualmente.</li>
    </div>

    @can('be god')
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" role="switch" id="role-god" wire:click="toggleRole('god')"
                {{ in_array('god', $userRoles) ? 'checked' : '' }}>
            <label class="form-check-label text-danger" for="role-god">
                god - God Mode !
            </label>
        </div>
    @endcan

    @php $anterior = null; @endphp
    @foreach ($roles as $rol)
        {{-- 
        @if (current(explode(':', $rol->name)) != current(explode(':', $anterior)))
            <hr>
        @endif
        @php $anterior = $rol->name; @endphp 
        --}}

        <div class="form-check form-switch">
            <!-- Botón para mostrar/ocultar los permisos -->
            <button wire:click="togglePermissions('{{ $rol->id }}')" class="btn btn-sm link-primary">
                <i class="bi bi-eye"></i>
            </button>
            <input class="form-check-input" type="checkbox" role="switch" id="role-{{ $rol->id }}"
                wire:click="toggleRole('{{ $rol->name }}')" {{ in_array($rol->name, $userRoles) ? 'checked' : '' }}>
            <label class="form-check-label" for="role-{{ $rol->id }}">
                {{ $rol->name }}
                <small class="form-text">{{ $rol->description }}</small>
            </label>

        </div>

        <!-- Lista de permisos -->
        <ul id="permissions-{{ $rol->id }}" class="{{ $openPermissions[$rol->id] ? '' : 'hidden' }}">
            @foreach ($rol->permissions as $permission)
                <li class="small">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            id="permission-{{ $permission->id }}"
                            wire:click="togglePermission('{{ $permission->name }}')"
                            {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->name }}
                            <small class="form-text">{{ $permission->description }}</small></label>
                    </div>
                </li>
            @endforeach
        </ul>
    @endforeach

    @section('custom_css')
        <style>
            .hidden {
                display: none;
            }
        </style>
    @endsection

    @section('custom_js')

    @endsection

</div>
