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
<div>
    <div class="float-left">
        <h3>Usuarios
            @can('Users: create')
                <a href="{{ route('rrhh.users.create') }}" class="btn btn-primary">Crear</a>
            @endcan
        </h3><br>
    </div>

    <div>
        <form class="form-inline float-right" method="GET" action="{{ route('rrhh.users.index') }}">
            <div class="input-group mb-3">
                <input type="text" name="name" class="form-control" placeholder="Nombres, Apellidos o RUN sin DV" autofocus autocomplete="off">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<br>

<table class="table table-responsive-xl table-striped table-sm">
    <thead class="thead-dark">
        <tr>
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
            <th scope="row" nowrap>{{ $user->runFormat() }}</td>
            <td nowrap>{{ $user->fullName }} {{ trashed($user) }}</td>
            <td class="small">{{ @$user->organizationalUnit->name ?: ''}}</td>
            <td class="small">{{ $user->position }}</td>
            <td nowrap>
                @unless($user->trashed())
                @can('Users: edit')
                    <a href="{{ route('rrhh.users.edit',$user->id) }}" class="btn btn-outline-primary">
                    <span class="fas fa-edit" aria-hidden="true"></span></a>
                    @if(!$user->hasVerifiedEmail())
                        @if($user->email_personal)
                        <form class="d-inline" method="POST" action="{{ route('verification.resend', $user->id) }}">
                            @csrf
                            <div class="tooltip-wrapper" data-title="Verificar correo electrónico personal">
                            <button class="btn btn-outline-primary"><span class="fas fa-user-check" aria-hidden="true"></span></button>
                            </div>
                        </form>
                        @else
                        <div class="tooltip-wrapper disabled" data-title="No existe registro de correo electrónico personal para ser verificada">
                            <button class="btn btn-outline-primary" disabled><span class="fas fa-user-check" aria-hidden="true"></span></button>
                        </div>
                        @endif
                    @else
                        <div class="tooltip-wrapper disabled" data-title="Correo electrónico personal verificada">
                            <button class="btn btn-outline-success" disabled><span class="fas fa-user-check" aria-hidden="true"></span></button>
                        </div>
                    @endif
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