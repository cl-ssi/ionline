<div>
    @section('title', 'Asignar roles a Usuario')

    @include('rrhh.submenu')

    <h3 class="mb-3">Roles</h3>
    <!-- Show roles in three columns -->
    @foreach($roles as $rol)
        <div class="form-check form-switch">
            <input 
                class="form-check-input" 
                type="checkbox" 
                role="switch" 
                id="role-{{ $rol->id }}"
                wire:click="toggleRole('{{ $rol->name }}')"
                {{ in_array($rol->name, $userRoles) ? 'checked' : ''}}>
            <label class="form-check-label" for="role-{{ $rol->id }}">{{ $rol->name }}</label>
            <div id="role-{{ $rol->id }}-help" class="form-text">{{ $rol->description }}</div>
        </div>

        <ul>
            @foreach($rol->permissions as $permission)
                <li class="small">{{ $permission->name }} <small class="form-text">{{ $permission->description }}</small></li>
            @endforeach
        </ul>
    @endforeach

</div>