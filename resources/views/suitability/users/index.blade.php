@extends('layouts.bt4.app')

@section('content')

@include('suitability.nav')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('suitability.users.create') }}">
            Agregar Usuario Externo
        </a>
    </div>
</div>


<h3 class="mb-3">Asignar Usuario Administrador a Colegio</h3>


<form method="POST" class="form-horizontal" action="{{ route('suitability.users.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_school_id">Colegios</label>
            <select name="school_id" id="for_school_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Colegio" required>
                <option value="">Seleccionar Colegio</option>
                @foreach($schools as $school)
                <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_user_id">Usuarios Externos</label>
            <select name="user_external_id" id="for_user_external_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Usuario" required>
                <option value="">Seleccionar Usuario</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                @endforeach
            </select>
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

<hr>
<hr>

<form method="GET" class="form-horizontal" action="{{ route('suitability.users.indexAdmin') }}">    
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_school_id">Colegios</label>
            <!-- Agrega el campo de selección de colegios -->
            <select name="school_id" id="for_school_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Colegio">
                <option value="">Todos los Colegios</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_user_external_id">Usuarios Administradores</label>
            <select name="user_external_id" id="for_user_external_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Usuario">
                <option value="">Seleccionar Administrador</option>
                @foreach($users as $schoolUser)
                    <option value="{{ $schoolUser->user->id }}" {{ request('user_external_id') == $schoolUser->user->id ? 'selected' : '' }}>{{ $schoolUser->user->fullname }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_commune_id">Comunas</label>
            <!-- Agrega el campo de selección de comunas -->
            <select name="commune_id" id="for_commune_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Comuna">
                <option value="">Todas las Comunas</option>
                @foreach($communes as $commune)
                    <option value="{{ $commune->id }}" {{ request('commune_id') == $commune->id ? 'selected' : '' }}>{{ $commune->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <div class="form-group col">
            <button type="submit" class="btn btn-primary mt-4">Filtrar</button>
        </div>
    </div>
</form>



<h3 class="mb-3">Listado de Usuarios Administradores de Colegio</h3>
    @if($adminUsers->count() > 0)
        <div>
            <a class="btn btn-primary" id="downloadLink" onclick="exportF(this)">
                <i class="fas fa-file-excel"></i> Descargar en Excel Administradores
            </a>
        </div>
    @endif
<table class="table table-sm table-bordered" id="tabla_de_usuarios_administradores_colegios">
    <thead>
        <tr>
            <th>Contador</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Colegio</th>
            <th>Comuna del Colegio</th>
            <th>Editar</th>            
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>

    @foreach($adminUsers as $key => $adminUser)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $adminUser->user->fullname ?? '' }}</td>
            <td>{{ $adminUser->user->email ?? '' }}</td>
            <td>{{ $adminUser->user->phone_number ?? '' }}</td>
            <td>{{ $adminUser->school->name ?? '' }}</td>
            <td>{{ $adminUser->school->commune->name ?? '' }}</td>
            <td>
                <a class="btn btn-info" href="{{ route('suitability.users.editUserAdmin', $adminUser->user_external_id) }}">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
            <td>
                <form method="POST" class="form-horizontal" action="{{ route('suitability.users.destroy', $adminUser->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro que desea eliminar a {{ $adminUser->user->fullname }} como administrador de idoneidad del colegio {{ $adminUser->school->name }}? ' )">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </td>
        </tr>
    @endforeach


    </tbody>
</table>



@endsection

@section('custom_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    let date = new Date()
    let day = date.getDate()
    let month = date.getMonth() + 1
    let year = date.getFullYear()
    let hour = date.getHours()
    let minute = date.getMinutes()

    function exportF(elem) {
        var table = document.getElementById("tabla_de_usuarios_administradores_colegios");
        var html = table.outerHTML;
        var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
        var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "tabla_de_usuarios_administradores_colegios_generado_el_" + day + "_" + month + "_" + year + "_" + hour + "_" + minute + ".xls"); // Choose the file name
        return false;
    }
</script>

@endsection