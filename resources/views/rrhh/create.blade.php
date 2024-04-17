@extends('layouts.bt5.app')

@section('title', 'Crear Usuario')

@section('content')

<h3>Nuevo usuario</h3>

@can('Users: create')
<form method="POST" action="{{ route('rrhh.users.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row gx-2 mb-3">
        <fieldset class="form-group col-2">
            <label for="formGroupIDInput">ID*</label>
            <input type="number" class="form-control" id="formGroupIDInput" name="id" required="required" min="6" max="99999999" step="" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="formGroupDVInput">DV*</label>
            <input type="text" class="form-control" id="formGroupDVInput" name="dv" required="required" title="Digito verificador" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="formGroupNameInput">Nombre*</label>
            <input type="text" class="form-control" id="formGroupNameInput" placeholder="Nombre" name="name" required="required">
        </fieldset>

        <div class="form-group col-md-2">
            <label for="name">Apellido Paterno*</label>
            <input type="text" class="form-control" name="fathers_family" required="required">
        </div>

        <div class="form-group col-md-2">
            <label for="name">Apellido Materno*</label>
            <input type="text" class="form-control" name="mothers_family" required="required">
        </div>
        
        <div class="form-group col-md-1">
            <label for="name">Sexo*</label>
            <select name="gender" class="form-select" required>
                <option value=""></option>
                <option value="male">Masculino</option>
                <option value="female">Femenino</option>
            </select>
        </div>

        <fieldset class="form-group col-md-2">
            <label for="forbirthday">Fecha Nacimiento</label>
            <input type="date" class="form-control" id="forbirthday" name="birthday">
        </fieldset>
    </div>

    <div class="row gx-2 mb-3">
        <fieldset class="form-group col-md-12">
            <label for="forOrganizationalUnit">Establecimiento / Unidad Organizacional</label>
                @livewire('select-organizational-unit', [
                    'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
                    'select_id' => 'organizationalunit'
                ])
        </fieldset>
    </div>

    <div class="row gx-2">
        <fieldset class="form-group col-12 col-md-6">
            <label for="forPosition">Función que desempeña</label>
            <input type="text" class="form-control" id="forPosition" placeholder="Subdirector(S), Enfermera, Referente..., Jefe." name="position">
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="formGroupEmailInput">Email institucional</label>
            <input type="email" class="form-control" id="formGroupEmailInput" placeholder="Email" name="email">
        </fieldset>
    </div>


    <!--
    <fieldset class="form-group">
        <label for="forPhoto">Foto</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="photo" lang="es">
            <label class="custom-file-label" for="customFile">Seleccionar Foto</label>
        </div>
    </fieldset>
        
    -->

    <h5 class="mt-3">Roles iniciales</h5>

    <!-- <div class="form-check">
        <input class="form-check-input" type="checkbox" name="permissions[]" value="Authorities: view" checked>
        <label class="form-check-label" for="defaultCheck2">
            Authorities: view
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="permissions[]" value="Calendar: view" checked>
        <label class="form-check-label" for="defaultCheck2">
            Calendar: view
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="permissions[]" value="Requirements: create" checked>
        <label class="form-check-label" for="defaultCheck2">
            Requirements: create
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="permissions[]" value="Documents: create">
        <label class="form-check-label" for="defaultCheck2">
            Documents: create
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="permissions[]" value="Documents: edit">
        <label class="form-check-label" for="defaultCheck2">
            Documents: edit
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="permissions[]" value="Documents: signatures and distribution" >
        <label class="form-check-label" for="defaultCheck2">
            Documents: signatures and distribution
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="permissions[]" value="Users: must change password" checked>
        <label class="form-check-label" for="defaultCheck1">
            Users: must change password
        </label>
    </div> -->
    
    @foreach($roles as $role)
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}">
        <label class="form-check-label" for="for-rol-{{$role->id}}">
            {{ $role->name }}: <small class="text-muted"> {{ $role->description }} </small>
        </label>
    </div>
    @endforeach

    <button type="submit" class="btn btn-primary mt-3">Crear</button>



</form>
@endcan

@endsection

@section('custom_js')
<script>
        // Función para calcular el dígito verificador (DV)
        function calcularDV() {
            var id = document.getElementById("formGroupIDInput").value; // Obtener el valor del ID

            var suma = 0;
            var multiplicador = 2; // Multiplicador inicial

            // Calcular la suma ponderada de los dígitos
            for (var i = id.length - 1; i >= 0; i--) {
                suma += parseInt(id.charAt(i)) * multiplicador;

                // Actualizar el multiplicador para el siguiente dígito
                multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
            }

            // Calcular el dígito verificador (DV)
            var residuo = suma % 11;
            var dv = residuo === 0 ? 0 : 11 - residuo;

            // Asignar "K" si el DV es 10
            if (dv === 10) {
                dv = "K";
            }

            // Actualizar el campo del dígito verificador con el resultado
            document.getElementById("formGroupDVInput").value = dv;
        }

        // Asociar la función calcularDV al evento input del campo de ID
        document.getElementById("formGroupIDInput").addEventListener("input", calcularDV);
    </script>
@endsection
