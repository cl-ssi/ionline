@extends('layouts.app')

@section('content')

@include('suitability.nav')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('suitability.options.create') }}">
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
            <th>Alternativa</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
    @foreach($options as $option)
        <tr>
            <td>{{$option->question->id ?? "" }}) {{ $option->question->question_text ?? '' }}</td>
            <td>{{ $option->option_text ?? '' }}</td>
            <td>{{ $option->points ?? '' }}</td>
            <td>{{ $option->alternative ?? '' }}</td>
            <td>
				<a href="{{ route('suitability.options.edit', $option) }}" class="btn btn-outline-secondary btn-sm">
				<span class="fas fa-edit" aria-hidden="true"></span></a>
			</td>
        </tr>
    @endforeach
    </tbody>

</table>

@endsection

@section('custom_js')

@endsection