<div>
    @section('title', 'Asignar permisos al Usuario')

    @include('rrhh.submenu')

    <h3 class="mb-3">Permisos</h3>

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
                for="permission-{{ $permission->id }}">{{ $permission->name }} <small class="form-text">{{ $permission->description }}</small></label>
        </div>


    @endforeach

</div>