@extends('layouts.app')

@section('content')

@include('suitability.nav')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="#">
                Agregar Opción a Pregunta
            </a>
        </div>
    </div>

<h3 class="mb-3">Listado de Opciones para las Preguntas</h3>
<table class="table">
    <thead>
        <tr>
            <th>Pregunta</th>
            <th>Texto de la Opción</th>
            <th>Punto</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
    @foreach($options as $option)
        <tr>
            <td>{{ $option->question->name ?? '' }}</td>
            <td>{{ $option->option_text ?? '' }}</td>
            <td>{{ $option->points ?? '' }}</td>
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