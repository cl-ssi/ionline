@extends('layouts.app')

@section('title', 'Listado de parametros')

@section('content')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>

<h3 class="mb-3">Listado de parametros</h3>

<form method="GET" class="form-horizontal" action="{{ route('indicators.single_parameter.index') }}">

    <div class="row">
        <fieldset class="form-group col-2">
            <label for="for_law">Ley</label>
            <input type="text" class="form-control" id="for_law" name="law">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_year">Año</label>
            <select name="year" id="for_year" class="form-control">
                <option>2020</option>
                <option selected>2019</option>
                <option>2018</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_indicator">Indicador</label>
            <input type="text" class="form-control" id="for_indicator" name="indicator">
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_establishment">Establecimiento</label>
            <select name="establishment_id" id="for_establishment" class="form-control">
                <option></option>
                <option value="1">Ernesto Torres Galdames</option>
                <option value="2">Cirujano Aguirre</option>
                <option value="3">Cirujano Videla</option>
                <option value="4">Cirujano Guzmán</option>
                <option value="5">Sur de Iquique</option>
                <option value="6">Cerro Esmeralda</option>
                <option value="7">Chanavayita</option>
                <option value="8">San Marcos</option>
                <option value="9">Iquique</option>
                <option value="10">Pedro Pulgar</option>
                <option value="11">Pedro Pulgar</option>
                <option value="12">Dr. Héctor Reyno G.</option>
                <option value="13">El Boro</option>
                <option value="14">La Tortuga</option>
                <option value="15">Camiña</option>
                <option value="16">Moquella</option>
                <option value="17">Colchane</option>
                <option value="18">Enquelga</option>
                <option value="19">Cariquima</option>
                <option value="20">Huara</option>
                <option value="21">Pisagua</option>
                <option value="22">Tarapacá</option>
                <option value="23">Pachica</option>
                <option value="24">Chiapa</option>
                <option value="25">Sibaya</option>
                <option value="26">Pica</option>
                <option value="27">Cancosa</option>
                <option value="28">Matilla</option>
                <option value="29">Pozo Almonte</option>
                <option value="30">Mamiña</option>
                <option value="31">La Tirana</option>
                <option value="32">La Huayca</option>
                <option value="33">Pozo Almonte</option>
                <option value="34">Jorge Seguel C.</option>
                <option value="35">Salvador Allende</option>
                <option value="36">Dr. Enrique Paris</option>
            </select>
        </fieldset>

        <button type="submit" class="btn btn-primary mt-4 mb-3"><i class="fas fa-search"></i></button>

    </div>



</form>



<a href="{{ route('indicators.single_parameter.create') }}">Nuevo parametro</a>
<table class="table table-sm" id="parameters">
    <thead>
        <th>Ley</th>
        <th>Año</th>
        <th>Indicador</th>
        <th>Establecimiento</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Mes</th>
        <th>Posición</th>
        <th>Valor</th>
        <th></th>
    </thead>
    <tbody>
        @foreach($parameters as $param)
        <tr class="small">
            <td>{{ $param->law }}</td>
            <td>{{ $param->year }}</td>
            <td>{{ $param->indicator }}</td>
            <td>{{ $param->establishment->name }}</td>
            <td class="text-capitalize">{{ $param->type }}</td>
            <td>{{ $param->description }}</td>
            <td>{{ $param->month }}</td>
            <td class="text-capitalize">{{ $param->position }}</td>
            <td>{{ $param->value }}</td>
            <td><a href="{{ route('indicators.single_parameter.edit', $param) }}"><i class="fas fa-edit"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('custom_js')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#parameters').DataTable({
        "paging": false,
        "language":{
             "decimal":        "",
             "emptyTable":     "No hay datos para mostrar en la tabla",
             "info":           "Mostrando _START_ de _END_ de un total de _TOTAL_",
             "infoEmpty":      "Showing 0 to 0 of 0 entries",
             "infoFiltered":   "(filtered from _MAX_ total entries)",
             "infoPostFix":    "",
             "thousands":      ",",
             "lengthMenu":     "Mostrar _MENU_ filas",
             "loadingRecords": "Cargando...",
             "processing":     "Procesando...",
             "search":         "Buscar:",
             "zeroRecords":    "No se encontró nada con ese criterio",
             "paginate": {
                 "first":      "Primera",
                 "last":       "Última",
                 "next":       "Siguiente",
                 "previous":   "Anterior"
             },
             "aria": {
                 "sortAscending":  ": activate to sort column ascending",
                 "sortDescending": ": activate to sort column descending"
             }
         }

    } );
} );
</script>

@endsection
