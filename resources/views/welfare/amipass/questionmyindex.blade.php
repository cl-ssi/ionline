@extends('layouts.bt4.app')

@section('title', 'Mis Preguntas/Sugerencias Amipass')

@section('content')
    <div class="form-row">
        <div class="col">
            <h3 class="mb-3">Mis Consultas/Sugerencia de Amipass</h3>
        </div>
        <div class="col-3 text-end">
            <a class="btn btn-success float-right" href="{{ route('welfare.amipass.question-create') }}">
                <i class="fas fa-plus"></i> Nueva Consulta/Sugerencia
            </a>
        </div>
    </div>


    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha Consulta/Sugerencia</th>
                <th>Motivo</th>
                <th>Consulta o Sugerencia</th>
                <th>Fecha Respuesta</th>
                <th>Respuesta</th>
                <th>Ver Solicitud con Respuesta</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($doubts as $doubt)
                <tr>
                    <td>{{ $doubt->id }}</td>
                    <td>{{ $doubt->question_at }}</td>
                    <td>{{ $doubt->motivo }}</td>
                    <td>{{ $doubt->consulta }}</td>
                    <td>{{ $doubt->answer_at }}</td>
                    <td>{{ $doubt->respuesta }}</td>
                    <td>
                        @if ($doubt->respuesta)
                            <a href="{{ route('welfare.amipass.question-show', $doubt->id) }}">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>

    </table>
@endsection
