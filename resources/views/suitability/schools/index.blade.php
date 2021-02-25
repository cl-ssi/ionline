@extends('layouts.app')

@section('content')

@include('suitability.nav')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('suitability.schools.create') }}">
            Agregar Colegio
        </a>
    </div>
</div>

<h3 class="mb-3">Listado de Colegios</h3>
<table class="table">
    <thead>
        <tr>
            <th>RBD</th>
            <th>Establecimiento</th>
            <th>Comuna</th>
            <th>Municipal</th>
            <th>Calidad Juridica</th>
            <th>Sostenedor</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
    @foreach($schools as $school)
        <tr>
            <td>{{ $school->rbd ?? '' }}</td>
            <td>{{ $school->name ?? '' }}</td>
            <td>{{ $school->commune->name ?? '' }}</td>
            <td>{{ $school->municipality ?? '' }}</td>
            <td>{{ $school->legal ?? '' }}</td>
            <td>{{ $school->holder ?? '' }}</td>            
            <td>
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>

</table>


@endsection

@section('custom_js')

@endsection