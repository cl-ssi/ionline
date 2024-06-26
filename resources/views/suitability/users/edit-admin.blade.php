@extends('layouts.bt4.app')

@section('title', 'Editar Usuario Administrador Externo')

@section('content')

    @include('suitability.nav')

    <h3 class="mb-3">Editar Usuario Administrador Externo</h3>

    <form method="POST" class="form-horizontal" action="{{ route('suitability.users.updateUserAdmin', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-row align-items-end">
            <fieldset class="form-group col-5 col-sm-4 col-md-4 col-lg-2">
                <label for="for_run">Run</label>
                <input type="number" class="form-control" id="for_run" name="id" autocomplete="off" max="50000000"
                    value="{{ $user->id }}" required>
            </fieldset>

            <fieldset class="form-group col-2 col-sm-2 col-md-1 col-lg-1">
                <label for="for_dv">DV</label>
                <input type="text" class="form-control" id="for_dv" name="dv" autocomplete="off"
                    value="{{ $user->dv }}" readonly>
            </fieldset>

            <fieldset class="form-group col-4">
                <label>Sexo*</label>
                <select class="form-control" name="gender" required>
                    <option value="">Seleccionar Sexo</option>
                    <option value="male" @if ($user->gender == 'male') selected @endif>Masculino</option>
                    <option value="female" @if ($user->gender == 'female') selected @endif>Femenino</option>
                </select>
            </fieldset>
        </div>

        <div class="row">
            <fieldset class="form-group col-6">
                <label for="for_name">Nombres*</label>
                <input type="text" class="form-control" id="for_name" name="name" value="{{ $user->name }}"
                    required autocomplete="off">
            </fieldset>

            <fieldset class="form-group col-6">
                <label for="for_fathers_family">Apellido Paterno*</label>
                <input type="text" class="form-control" id="for_fathers_family" name="fathers_family"
                    value="{{ $user->fathers_family }}" required autocomplete="off">
            </fieldset>

            <fieldset class="form-group col-6">
                <label for="for_mothers_family">Apellido Materno*</label>
                <input type="text" class="form-control" id="for_mothers_family" name="mothers_family"
                    value="{{ $user->mothers_family }}" required autocomplete="off">
            </fieldset>

            <fieldset class="form-group col-6">
                <label for="for_critic_stock">Correo Electrónico*</label>
                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required
                    autocomplete="off">
            </fieldset>
        </div>

        <div class="row">
            <fieldset class="form-group col-6">
                <label for="for_position">Cargo Desempeñado*</label>
                <input type="text" class="form-control" id="for_position" name="position" value="{{ $user->position }}"
                    required>
            </fieldset>

            <fieldset class="form-group col-6">
                <label for="for_phone_number">Teléfono*</label>
                <input type="text" class="form-control" id="for_phone_number" name="phone_number"
                    value="{{ $user->phone_number }}" required>
            </fieldset>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>

@endsection

@section('custom_js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ asset('js/jquery.rut.chileno.js') }}"></script>
    <script type="text/javascript">
        $('input[name=id]').keyup(function(e) {
            var str = $("#for_run").val();
            $('#for_dv').val($.rut.dv(str));
        });
    </script>

@endsection
