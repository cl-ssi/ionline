@extends('layouts.app')

@section('content')

@include('suitability.nav')
<h3 class="mb-3">Resultado Test de  N° {{ $result->id }}</h3>
<h3 class="mb-3">Realizado por {{ $result->user->fullName }} </h3>


<p class="mt-5">Total de Puntos: {{ $result->total_points }} Puntos</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Preguntas</th>
                    <th>Respuesta</th>
                    <th>Puntos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result->questions as $question)
                    <tr>
                        <td>{{ $question->question_text }}</td>
                        <td>{{ $question->questionOptions->find($question->pivot->option_id)->option_text }}</td>
                        <td>{{ $question->pivot->points }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>



@endsection

@section('custom_js')


@endsection