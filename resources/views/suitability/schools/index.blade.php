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
            <th>Contador</th>
            <th>RBD</th>
            <th>Establecimiento</th>
            <th>Comuna</th>
            <th>Municipal</th>
            <th>Calidad Juridica</th>
            <th>Sostenedor</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($schools as $key => $school)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $school->rbd ?? '' }}</td>
            <td>{{ $school->name ?? '' }}</td>
            <td>{{ $school->commune->name ?? '' }}</td>
            <td>{{ $school->municipality ?? '' }}</td>
            <td>{{ $school->legal ?? '' }}</td>
            <td>{{ $school->holder ?? '' }}</td>
            <td>
                <a href="{{ route('suitability.schools.edit', $school->id) }}" class="btn btn-outline-secondary btn-sm">
                    <span class="fas fa-edit" aria-hidden="true"></span>
                </a>
            </td>
            <td>
                <form method="POST" class="form-horizontal" action="{{ route('suitability.schools.destroy', $school) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger float-left" onclick="return confirm('¿Está seguro que desea eliminar el colegio {{ $school->name }}? ' )"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>


@endsection

@section('custom_js')

@endsection