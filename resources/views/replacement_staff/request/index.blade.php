@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')
<h3 class="mb-3">Listado de Solicitudes</h3>


<table class="table">
    <thead>
        <tr>
            <th>Cargo</th>
            <th>Grado</th>
            <th>Calidad Jurídica</th>
            <th>Desde</th>
            <th>Hasta</th>
            <th>Fundamento</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Informático</td>
            <td>1</td>
            <td>Contrata</td>
            <td>16-11-2020</td>
            <td>31-12-2020</td>
            <td>Reemplazo o Suplencia</td>
            <td>
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>Enfermera </td>
            <td>5</td>
            <td>Honorario</td>
            <td>16-11-2020</td>
            <td>31-12-2020</td>
            <td>Reemplazo o Suplencia</td>
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
