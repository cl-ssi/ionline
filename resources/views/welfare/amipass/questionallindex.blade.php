@extends('layouts.bt4.app')

@section('title', 'Mis Preguntas/Sugerencias Amipass')

@section('content')

@include('welfare.nav')
    <div class="form-row">
        <div class="col">
            <h3 class="mb-3">Consultas/Sugerencia</h3>
        </div>
    </div>


    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha Consulta/Sugerencia</th>
                <th>Funcionario</th>
                <th>Motivo</th>
                <th>Consulta o Sugerencia</th>
                <th>Fecha Respuesta</th>
                <th>Respuesta</th>
                <th>Responder</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($doubts as $doubt)
                <tr>
                    <td>{{ $doubt->id }}</td>
                    <td>{{ $doubt->question_at }}</td>
                    <td>{{ $doubt->nombre_completo }}</td>
                    <td>{{ $doubt->motivo }}</td>
                    <td>{{ $doubt->consulta }}</td>
                    <td>{{ $doubt->answer_at }}</td>
                    <td>{{ $doubt->respuesta }}</td>
                    <td>
                        <a href="{{ route('welfare.amipass.question-edit', $doubt->id) }}">
                            <i class="fas fa-reply"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
