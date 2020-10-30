@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')
<h3 class="mb-3">Listado de STAFF</h3>


<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Run</th>
            <th>Funcion</th>
            <th>Número contacto</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nombre ApellidoP ApellidM</td>
            <td>12346578-9</td>
            <td>Enfermera</td>
            <td>Teléfono</td>
            <td>
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>Nombre ApellidoP ApellidM</td>
            <td>12346578-9</td>
            <td>Enfermera</td>
            <td>Teléfono</td>
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
