@extends('layouts.app')

@section('content')

@include('suitability.nav')
<h3 class="mb-3">Listado de Preguntas</h3>


<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Categoría</th>
            <th>Texto de Pregunta</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
    @foreach($questions as $question)
        <tr>
            <td>{{ $question->id ?? '' }}</td>
            <td>{{ $question->category->name ?? '' }}</td>
            <td>{{ $question->question_text ?? '' }}</td>
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