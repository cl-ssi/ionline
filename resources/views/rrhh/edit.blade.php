@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')

@include('rrhh.submenu')

@can('Users: edit')
<form method="POST" class="form-horizontal" action="{{ route('rrhh.users.update',$user->id) }}">
    @csrf
    @method('PUT')

    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="run">RUN</label>
            <input type="text" readonly class="form-control-plaintext" id="staticRUN" value="{{$user->runFormat()}}">
        </div>
        <div class="form-group col-md-4">
            <label for="name">Nombres</label>
            <input type="text" class="form-control" name="name" value="{{$user->name}}">
        </div>
        <div class="form-group col-md-2">
            <label for="name">Apellido Paterno</label>
            <input type="text" class="form-control" name="fathers_family" value="{{ $user->fathers_family }}">
        </div>
        <div class="form-group col-md-2">
            <label for="name">Apellido Materno</label>
            <input type="text" class="form-control" name="mothers_family" value="{{ $user->mothers_family }}">
        </div>

        <fieldset class="form-group col-md-2">
            <label for="forbirthday">Fecha Nacimiento</label>
            <input type="date" class="form-control" id="forbirthday"
                name="birthday" value="{{ $user->birthday ? $user->birthday->format('Y-m-d'):'' }}">
        </fieldset>

    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-4">
            <label for="forPosition">Función que desempeña</label>
            <input type="text" class="form-control" id="forPosition" placeholder="Subdirector(S), Enfermera, Referente..., Jefe." 
                name="position"	value="{{ $user->position }}">
        </fieldset>

        <div class="form-group col-12 col-md-4">
            <label for="email">Correo</label>
            <input type="email" class="form-control" name="email" value="{{$user->email}}">
        </div>
        <div class="form-group col-11 col-md-3">
            <label for="email">Correo Personal</label>
            <input type="email" class="form-control" name="email_personal" value="{{$user->email_personal}}">
        </div>
        <div class="form-group col-1">
            @if(!$user->hasVerifiedEmail())
                <label for="mail_verification">&nbsp;</label>
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
        </div>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-12">
            <label for="forOrganizationalUnit">Establecimiento / Unidad Organizacional</label>
                @livewire('select-organizational-unit', [
                    'establishment_id' => optional($user->organizationalUnit)->establishment_id, 
                    'organizational_unit_id' => optional($user->organizationalUnit)->id,
                    'select_id' => 'organizationalunit'
                ])
        </fieldset>
    </div>



    <div class="form-group d-inline">
        <button type="submit" class="btn btn-sm btn-primary">
        <span class="fas fa-save" aria-hidden="true"></span> Actualizar</button>

        </form>

        <form method="POST" action="{{ route('rrhh.users.password.reset', $user->id) }}" class="d-inline">
            {{ method_field('PUT') }} {{ csrf_field() }}
            <button class="btn btn-sm btn-outline-secondary"><span class="fas fa-redo" aria-hidden="true"></span> Restaurar clave</button>
        </form>

        @can('Users: delete')
        <form method="POST" action="{{ route('rrhh.users.destroy', $user->id) }}" class="d-inline">
            {{ method_field('DELETE') }} {{ csrf_field() }}
            <button class="btn btn-sm btn-danger"><span class="fas fa-trash" aria-hidden="true"></span> Eliminar</button>
        </form>
        @endcan

        @role('god')
        <!--TODO: Revisar un código decente para utilizar este método, quizá sólo un link en vez de un formulario, chequear en el controller que tenga el rol god() -->
        <form method="GET" action="{{ route('rrhh.users.switch', $user->id) }}" class="d-inline float-right">
            {{ csrf_field() }}
            <button class="btn btn-sm btn-outline-warning"><span class="fas fa-redo" aria-hidden="true"></span> Switch</button>
        </form>
        @endrole

    </div>

    <br /><hr />
    <div style="height: 300px; overflow-y: scroll;">
            @include('partials.audit', ['audits' => $user->audits()] )
    </div>

@endcan

@endsection
