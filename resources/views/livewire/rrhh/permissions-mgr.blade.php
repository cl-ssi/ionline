<div>
    @section('title', 'Asignar permisos al Usuario')

    @include('rrhh.submenu')

    <div
        class="alert alert-danger"
        role="alert"
    >
        <strong>Importante:</strong> No asignar permisos directamente a los usuarios. 
        Asignar roles a los usuarios y asignar permisos a los roles.
    </div>
    

    <h3 class="mb-3">Permisos
        <small>(✅ corresponde a un permiso asignado via roles)</small>
    </h3>

    <div class="form-check form-switch">
        <input 
            class="form-check-input" 
            type="checkbox" 
            role="switch" 
            id="permission-be_god"
            wire:click="togglePermission('be god')"
            {{ in_array('be god', $userPermissions) ? 'checked' : ''}}>
        <label class="form-check-label text-danger" 
            for="permission-be_god">be god <small class="form-text">God Mode</small></label>
    </div>
    <div class="form-check form-switch">
        <input 
            class="form-check-input" 
            type="checkbox" 
            role="switch" 
            id="permission-dev"
            wire:click="togglePermission('dev')"
            {{ in_array('dev', $userPermissions) ? 'checked' : ''}}>
        <label class="form-check-label text-danger" 
            for="permission-dev">dev <small class="form-text">Developer</small></label>
    </div>

    @foreach($permissions as $permission)

        @if( current(explode(':', $permission->name)) != current(explode(':', $anterior)))
            <hr>
        @endif
        @php $anterior = $permission->name; @endphp

        <div class="form-check form-switch">
            <input 
                class="form-check-input" 
                type="checkbox" 
                role="switch" 
                id="permission-{{ $permission->id }}"
                wire:click="togglePermission('{{ $permission->name }}')"
                {{ in_array($permission->name, $userPermissions) ? 'checked' : ''}}>
            <label class="form-check-label" 
                for="permission-{{ $permission->id }}">
                {{ $user->can($permission->name) ? '✅' : '⬜' }}
                {{ $permission->name }} <small class="form-text">{{ $permission->description }}</small>
            </label>
        </div>


    @endforeach

</div>