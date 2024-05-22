@extends('layouts.bt5.app')

@section('title', 'Lista de Usuarios')

@section('custom_css')
    <style>
        .tooltip-wrapper {
            display: inline-block;
            /* display: block works as well */
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
        <div class="col-12 col-md-6">
            <h3>Usuarios</h3>
        </div>
        <div class="col-6 text-end">
            @can('Users: create')
                <a href="{{ route('rrhh.users.create') }}" class="btn btn-primary">Crear</a>
            @endcan
        </div>
    </div>


    <form method="GET" action="{{ route('rrhh.users.index') }}">
        <div class="row gx-2">
            <fieldset class="col-12 col-md-9">
                @livewire('select-organizational-unit', [
                    'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
                    'required' => false,
                ])
            </fieldset>
            <fieldset class="col-12 col-md-3">
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Nombres, Apellidos o RUN sin DV"
                    value="{{ old('name') }}"  autofocus autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="row g-2">
            @if ($can['be god'])
                <fieldset class="col-5">
                    <select class="form-control form-select" name="roles">
                        <option value="">Roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" {{ old('roles') == $role ? 'selected' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
                </fieldset>

                <fieldset class="col-4">
                    <select class="form-control form-select" name="permission">
                        <option value="">Permisos</option>
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission }}" {{ old('permission') == $permission ? 'selected' : '' }}>{{ $permission }}</option>
                        @endforeach
                    </select>
                </fieldset>

            @endif
        </div>
    </form>


    <br>

    Total de registros: {{ $users->total() }}

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead class="table-dark">
            <tr>
                @if ($can['be god'])
                    <th scope="col"></th>
                @endif
                <th scope="col">RUN</th>
                <th scope="col">Nombre</th>
                <th scope="col">Unidad Organizacional (Establecimiento)</th>
                <th scope="col">Cargo/Función</th>
                <th scope="col">Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    @if ($can['be god'])
                        <th nowrap>
                            {!! $user->can('be god') ? '<i class="text-danger fas fa-chess-king" title="be god"></i>' : '' !!}
                            {!! $user->can('Drugs') ? '<i class="text-danger fas fa-cannabis" title="Drugs"></i>' : '' !!}
                            {!! $user->can('Users: delete') ? '<i class="fas fa-user-slash" title="Users: delete"></i>' : '' !!}
                            {!! $user->can('Partes: director') ? '<i class="fas fa-file-import" title="Partes: director"></i>' : '' !!}
                            {!! $user->can('Requirements: delete')
                                ? '<i class="text-danger bi bi-rocket-fill" title="Requirements: delete"></i>'
                                : '' !!}
                        </th>
                    @endif
                    <th scope="row" nowrap>{{ $user->runFormat() }}</td>
                    <td nowrap @class([
                            'text-decoration-line-through' => $user->trashed()
                        ])>
                        {{ $user->shortName }}
                    </td>
                    <td class="small">{{ @$user->organizationalUnit->name ?: '' }}
                        ({{ $user->organizationalUnit->establishment->alias ?? '' }})</td>
                    <td class="small">{{ $user->position }}</td>
                    <td nowrap>
                        @unless ($user->trashed())
                            @if ($can['Users: edit'])
                                <a href="{{ route('rrhh.users.edit', $user->id) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i></a>
                            @endcan

                            @if ($can['be god'] and !auth()->user()->godMode)
                                <a href="{{ route('rrhh.users.switch', $user->id) }}" class="btn btn-outline-warning" @disabled(auth()->user()->godMode)>
                                    <i class="bi bi-arrow-clockwise"></i></a>
                            @endif
                        @else
                            @livewire('rrhh.undo-user-deletion', ['user' => $user], key($user->id))
                        @endunless
                    </td>
                </tr>
             @endforeach
        </tbody>

    </table>
</div>
{{ $users->links() }}

@endsection

@section('custom_js')
<script>
    $(function() {
        $('.tooltip-wrapper').tooltip({
            position: "bottom"
        });
    });
</script>
@endsection
