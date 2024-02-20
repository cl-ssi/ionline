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
            <input 
                class="form-check-input" 
                type="checkbox" 
                role="switch" 
                id="role-god"
                wire:click="toggleRole('god')"
                {{ in_array('god', $userRoles) ? 'checked' : '' }}>
            <label class="form-check-label text-danger" for="role-god">
                god - God Mode !
            </label>
        </div>
    @endcan


    @foreach($roles as $rol)
        <div class="form-check form-switch">
            <input 
                class="form-check-input" 
                type="checkbox" 
                role="switch" 
                id="role-{{ $rol->id }}"
                wire:click="toggleRole('{{ $rol->name }}')"
                {{ in_array($rol->name, $userRoles) ? 'checked' : ''}}>
            <label class="form-check-label" for="role-{{ $rol->id }}">
                {{ $rol->name }}
                <small class="form-text">{{ $rol->description }}</small>
            </label>
        </div>

        <ul>
            @foreach($rol->permissions as $permission)
                <li class="small">
                    <div class="form-check form-switch">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            role="switch" 
                            id="permission-{{ $permission->id }}"
                            wire:click="togglePermission('{{ $permission->name }}')"
                            {{ in_array($permission->name, $userPermissions) ? 'checked' : ''}}>
                        <label class="form-check-label" 
                            for="permission-{{ $permission->id }}">{{ $permission->name }} <small class="form-text">{{ $permission->description }}</small></label>
                    </div>
                </li>
            @endforeach
        </ul>
    @endforeach

</div>