@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')

@include('rrhh.submenu')

@can('Users: edit')
<form method="POST" class="form-horizontal" action="{{ route('rrhh.users.update',$user->id) }}">
    @csrf
    @method('PUT')

    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="run">RUN</label>
            <input type="text" readonly class="form-control-plaintext" id="staticRUN" value="{{$user->runFormat()}}">
        </div>
        <div class="form-group col-md-3">
            <label for="name">Nombres*</label>
            <input type="text" class="form-control" name="name" value="{{$user->name}}" required>
        </div>
        <div class="form-group col-md-2">
            <label for="name">Apellido Paterno*</label>
            <input type="text" class="form-control" name="fathers_family" value="{{ $user->fathers_family }}" required>
        </div>
        <div class="form-group col-md-2">
            <label for="name">Apellido Materno*</label>
            <input type="text" class="form-control" name="mothers_family" value="{{ $user->mothers_family }}" required>
        </div>

        <fieldset class="form-group col-md-2">
            <label for="forbirthday">Fecha Nacimiento</label>
            <input type="date" class="form-control" id="forbirthday"
                name="birthday" value="{{ $user->birthday ? $user->birthday->format('Y-m-d'):'' }}">
        </fieldset>

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

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <label for="forPosition">Función que desempeña</label>
            <input type="text" class="form-control" id="forPosition" placeholder="Subdirector(S), Enfermera, Referente..., Jefe." 
                name="position"	value="{{ $user->position }}">
        </fieldset>

        <div class="form-group col-12 col-md-4">
            <label for="email">Email Institucional</label>
            <input type="email" class="form-control" name="email" value="{{$user->email}}">
        </div>
    </div>


    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <label for="form-vc-link">Link VC</label>
            <input type="link" class="form-control" name="vc_link" value="{{ $user->vc_link }}">
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="form-vc-alias">Alias VC</label>
            <input type="text" class="form-control" name="vc_alias" value="{{ $user->vc_alias }}">
            <small>{{ env('APP_URL')}}/vc/<strong>alias</strong></small>
        </fieldset>
    </div>

    <hr>
    <h5>Datos de contacto</h5>
    <div class="form-row">
        <div class="form-group col-11 col-md-4">
            <label for="for-address">Dirección</label>
            <input type="text" class="form-control" name="address" value="{{ $user->address }}">
        </div>
        <div class="form-group col-11 col-md-2">
            <label for="for-commune_id">Comuna</label>
            <select name="commune_id" class="form-control">
                <option value=""></option>
                @foreach($communes->sort() as $key => $name)
                    <option value="{{ $key }}" @selected($user->commune_id == $key)>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-11 col-md-2">
            <label for="for-phone_number">Número de teléfono</label>
            <input type="text" class="form-control" name="phone_number" value="{{ $user->phone_number }}">
        </div>
        <div class="form-group col-11 col-md-4">
            <label for="for-email">Email Personal</label>
            <input type="email" class="form-control" name="email_personal" value="{{ $user->email_personal }}">
        </div>
    </div>



    <div class="form-group d-inline">
        <button type="submit" class="btn btn-sm btn-primary">
        <span class="fas fa-save" aria-hidden="true"></span> Actualizar</button>

        </form>

        @can('Users: reset password option')
        <form method="POST" action="{{ route('rrhh.users.password.reset', $user->id) }}" class="d-inline">
            {{ method_field('PUT') }} {{ csrf_field() }}
            <button class="btn btn-sm btn-outline-secondary"><span class="fas fa-redo" aria-hidden="true"></span> Restaurar clave</button>
        </form>
        @endcan

        @can('Users: delete')
        <form method="POST" action="{{ route('rrhh.users.destroy', $user->id) }}" class="d-inline">
            {{ method_field('DELETE') }} {{ csrf_field() }}
            <button class="btn btn-sm btn-danger"><span class="fas fa-trash" aria-hidden="true"></span> Eliminar</button>
        </form>
        @endcan

        @can('be god')
        <!--TODO: Revisar un código decente para utilizar este método, quizá sólo un link en vez de un formulario, chequear en el controller que tenga el rol god() -->
        <form method="GET" action="{{ route('rrhh.users.switch', $user->id) }}" class="d-inline float-right">
            {{ csrf_field() }}
            <button class="btn btn-sm btn-outline-warning"><span class="fas fa-redo" aria-hidden="true"></span> Switch</button>
        </form>
        @endcan

        @can('Users: send mail verification')
            @if(!$user->hasVerifiedEmail())
                @if($user->email_personal)
                    <form class="d-inline" method="POST" action="{{ route('verification.resend', $user->id) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-envelope" title="Verificar correo electrónico personal"></i>
                        </button>
                    </form>
                @else
                    <button class="btn btn-sm btn-secondary" disabled>
                        <i class="fas fa-envelope" title="No tiene agregado correo electrónico personal"></i>
                    </button>
                @endif
            @else
                <button class="btn btn-sm btn-outline-success" disabled>
                    <i class="fas fa-envelope" title="Correo electrónico personal verificada"></i>
                </button>
            @endif
        @endcan

    </div>

    <hr />
    @include('partials.audit', ['audits' => $user->audits()] )

@endcan

@endsection
