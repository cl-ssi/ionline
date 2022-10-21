@extends('layouts.app')

@section('content')

<h3 class="mb-3">Asignar Usuario a Esblecimiento REM</h3>


<form method="POST" class="form-horizontal" action="#">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_school_id">Establecimiento</label>
            <select name="establishment_id" id="for_establishment_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Establecimiento" required>
                <option value="">Seleccionar Establecimiento</option>                
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_user_id">Usuarios </label>
            <select name="user_id" id="for_user_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Usuario" required>
                <option value="">Seleccionar Usuario</option>                
            </select>
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>

</form>


@endsection

@section('custom_js')

@endsection