@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')
<h3 class="mb-3">Listado de STAFF</h3>


<table class="table table-sm table-bordered small text-uppercase" style="width:50%;">
    <tbody>
        <tr>
            <td>Filtro Profesiones:</td>
            <td>
              <form method="GET" id="form" class="form-horizontal" action="#">
                <select name="filter" onchange="this.form.submit()">
                  <option value="0">Todos</option>
                  <option value="1">Enfermera</option>
                  <option value="2">Informático</option>
                </select>
              </form>
            </td>
        </tr>
        <tr>
            <td>Filtro Estado:</td>
            <td>
              <form method="GET" id="form" class="form-horizontal" action="#">
                <select name="filter" onchange="this.form.submit()">
                  <option value="0" >Todos</option>
                  <option value="1" >Disponible</option>                  
                </select>
              </form>
            </td>
        </tr>
    </tbody>
</table>


<table class="table">
    <thead>
        <tr>
            <th>Nombre Completo</th>
            <th>Run</th>
            <th>Título</th>
            <th>Número contacto</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nombre ApellidoP ApellidM</td>
            <td>12346578-9</td>
            <td>Enfermera</td>
            <td>Teléfono</td>
            <td>Disponible</td>
            <td>
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>Nombre ApellidoP ApellidM</td>
            <td>12346578-9</td>
            <td>Informático</td>
            <td>Teléfono</td>
            <td>Trabajando</td>
            <td>
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
    </tbody>

</table>


    paginar ->
@endsection

@section('custom_js')

@endsection
