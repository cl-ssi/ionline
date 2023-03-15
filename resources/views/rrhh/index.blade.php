@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('custom_css')
<style>
    .tooltip-wrapper {
    display: inline-block; /* display: block works as well */
    }

    .tooltip-wrapper .btn[disabled] {
    /* don't let button block mouse events from reaching wrapper */
    pointer-events: none;
    }

    .tooltip-wrapper.disabled {
    /* OPTIONAL pointer-events setting above blocks cursor setting, so set it here */
    cursor: not-allowed;
    }
</style>
@endsection

@section('content')

<div class="row mb-3">
    <div class="col-6">
        <h3>Usuarios</h3>
    </div>
    <div class="col-6 text-right">
        @can('Users: create')
            <a href="{{ route('rrhh.users.create') }}" class="btn btn-primary">Crear</a>
        @endcan
    </div>
</div>


<form method="GET" action="{{ route('rrhh.users.index') }}">
    <div class="form-row">
        <fieldset class="col-7">
            @livewire('select-organizational-unit', [
                'establishment_id' => auth()->user()->organizationalUnit->establishment->id, 
                'required' => false,
            ])
        </fieldset>
        <fieldset class="col-2">
            <select class="form-control" name="permission">
                <option value="">Permisos</option>
                @foreach($permissions as $permission)
                    <option>{{ $permission }}</option>
                @endforeach
            </select>
        </fieldset>
        <fieldset class="col-3">
            <div class="input-group mb-3">
                <input type="text" name="name" class="form-control" placeholder="Nombres, Apellidos o RUN sin DV" autofocus autocomplete="off">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </fieldset>
    </div>
</form>


<br>

Total de registros: {{ $users->total() }}
<table class="table table-responsive-xl table-striped table-sm">
    <thead class="thead-dark">
        <tr>
            <th scope="col"></th>
            <th scope="col">RUN</th>
            <th scope="col">Nombre</th>
            <th scope="col">Unidad Organizacional</th>
            <th scope="col">Cargo/Función</th>
            <th scope="col">Accion</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <th nowrap>
                @livewire('set-single-permission', [ 'user' => $user, 'permission' => 'Nuevo iOnline', 'icon' => 'globe'])
                {!! $user->can('be god') ? '<i class="text-danger fas fa-chess-king" title="be god"></i>':'' !!}
                {!! $user->can('Drugs') ? '<i class="text-danger fas fa-cannabis" title="Drugs"></i>':'' !!}
                {!! $user->can('Users: delete') ? '<i class="fas fa-user-slash" title="Users: delete"></i>':'' !!}
                {!! $user->can('Partes: director') ? '<i class="fas fa-file-import" title="Partes: director"></i>':'' !!}
                {!! $user->can('Requirements: delete') ? '<i class="text-danger fas fa-rocket" title="Requirements: delete"></i>':'' !!}
            </th>
            <th scope="row" nowrap>{{ $user->runFormat() }}</td>
            <td nowrap>{{ $user->shortName }} {{ trashed($user) }}</td>
            <td class="small">{{ @$user->organizationalUnit->name ?: ''}}</td>
            <td class="small">{{ $user->position }}</td>
            <td nowrap>
                @unless($user->trashed())
                    @can('Users: edit')
                        <a href="{{ route('rrhh.users.edit',$user->id) }}" class="btn btn-outline-primary">
                        <span class="fas fa-edit" aria-hidden="true"></span></a>
                    @endcan

                    @role('god')
                    <a href="{{ route('rrhh.users.switch', $user->id) }}" class="btn btn-outline-warning">
                    <span class="fas fa-redo" aria-hidden="true"></span></a>
                    @endrole
                @endunless
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
{{ $users->links() }}

@endsection

@section('custom_js')
<script>
$(function() {
    $('.tooltip-wrapper').tooltip({position: "bottom"});
});
</script>
@endsection