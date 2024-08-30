@extends('layouts.bt4.app')

@section('content')

@include('suitability.nav')
<h3 class="mb-3">Listado de Resultados</h3>

<form method="GET" class="form-horizontal" action="{{ route('suitability.results.index') }}">

    <div class="form-row">
        <fieldset class="form-group col-6 col-md-6">
            <label for="for_year">Colegios</label>
            <select name="colegio" class="form-control selectpicker" data-live-search="true">
                <option value="">Todos Los Colegios</option>
                @foreach($schools as $school)
                <option value="{{$school->id}}" @if($school_id==$school->id) selected @endif >{{$school->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-2 col-md-2">
            <label for="for_year">Estados</label>
            <select name="estado" class="form-control selectpicker">
                <option value="">Todos los estados</option>
                @php($states = array('Aprobado', 'Rechazado', 'Test Finalizado'))
                @foreach($states as $state)
                <option value="{{$state}}" @if(isset($estado) && $estado==$state) selected @endif>{{$state}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-1">
            <label for="search">Año</label>
                    <select class="form-control" id="for_yearFilter" name="yearFilter">
                        <option value="todos">Todos</option>
                        @foreach(range(2022, now()->year) as $year)
                            <option value="{{ $year }}" @if($selectedYear == $year) selected @endif>{{ $year }}</option>
                        @endforeach
                	</select>
        </fieldset>

        <fieldset class="form-group col-2 col-md-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>
    </div>
</form>

    <table class="table">
        <thead>
            <tr>
                <!-- <th>Contador</th> -->
                <!-- <th>ID</th> -->
                <th>ID Solicitud</th>
                <th>Fecha y Hora de Solicitud</th>
                <th>Colegio</th>
                <!-- <th>Solicitud N°</th> -->                
                <th>Nombre</th>
                <th>Rut</th>
                <th>Cargo</th>
                <th>Total de Puntos</th>
                <th>Hora de Termino de Test</th>
                <th>Estado <a tabindex="0" role="button" data-toggle="popover" data-trigger="hover" data-html="true" title="" data-content="Aprobados:  {{$count['Aprobado'] ?? 0}} <br> Esperando Test: {{$count['Esperando Test'] ?? 0}} <br> Test Finalizados: {{$count['Test Finalizado'] ?? 0}}">
                        <i class="fas fa-info-circle" aria-hidden="true"></i></a></th>
                <th>Ver Test</th>
                <th>Eliminar Resultado y Solicitud</th>
                <th>Eliminar Resultado Solamente</th>
                <th>Eliminar Resultado y Dejar "Esperando Test"</th>
                <!-- <th>Ver Certificado (Aprobados)</th> -->
                <!-- <th>Enviar a Firmar</th> -->
                <!-- <th>Descargar PDF (Aprobados)</th> -->
                <!-- <th>Enviar por Mail </th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($results as $key => $result)
            <tr>
                <!-- <td>{{ $key+1 }}</td> -->
                <!-- <td>{{ $result->id ?? '' }}</td> -->
                <td>{{ $result->request_id ?? '' }}</td>
                <td>{{ $result->psirequest?->created_at}}</td>
                <td>{{ $result->psirequest->school->name ?? ''  }}</td>                
                <td>{{ $result->user->fullName ?? ''  }}</td>
                <td nowrap>{{ $result->user->runFormat ?? ''  }}</td>
                <td>{{ $result->psirequest->job ?? ''  }}</td>
                <td>{{ $result->total_points ?? '' }}</td>
                <td>{{ $result->updated_at ?? '' }}</td>
                <td>{{ $result->psirequest->status ?? '' }}</td>
                <td>
                    <a href="{{ route('suitability.results.show', $result->id) }}" class="btn btn-outline-primary">
                        <span class="fas fa-edit" aria-hidden="true"></span></a>
                </td>
                <td>
                    <form method="POST" action="{{ route('suitability.results.destroy', $result->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este resultado, recuerde que solo debe de eliminar si el resultado se encuentra duplicado o funcionario desvinculado. Se procederá a eliminar igual la solicitud?')">
                            <span class="fas fa-trash-alt" aria-hidden="true"></span>
                        </button>
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{ route('suitability.results.destroyResult', $result->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este resultado, recuerde que solo debe de eliminar si el resultado se encuentra duplicado, a diferencia del otro borrado este no elimina la solicitud')">
                            <span class="fas fa-exclamation-triangle" aria-hidden="true"></span>
                        </button>
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{ route('suitability.results.destroyAndSetStatus', $result->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este resultado y dejarlo como Esperando Test?')">
                            <span class="fas fa-hourglass" aria-hidden="true"></span>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    {{ $results->links() }}
    @endsection

    @section('custom_js')
    <script>
        $(function() {
            $('[data-toggle="popover"]').popover()
        })
    </script>

    @endsection