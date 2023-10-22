@extends('layouts.bt5.app')

@section('title', 'Autoridades')

@section('content')
    <h1 class="mb-3">Calendario de Autoridades de Unidades Organizacionales</h1>
    @if($ouTopLevels && count($ouTopLevels) > 0)
        <div class="table-responsive">
            @foreach($ouTopLevels as $ouTopLevel)
                @if($ouTopLevel->establishment && $ouTopLevel->establishment->name)
                    <h2 class="mb-3">{{ $ouTopLevel->establishment->name }}</h2>
                    <table class="table table-striped table-sm">
                        <thead class="table-secondary">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Calendario de Autoridades de la U.O.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($ouTopLevel->establishment->ouTree && count($ouTopLevel->establishment->ouTree) > 0)
                                @foreach($ouTopLevel->establishment->ouTree as $id => $ou)
                                    <tr style="font-family:monospace;">
                                        <td>{{ $ou }}</td>
                                        <td>
                                            <a href="{{ route('rrhh.new-authorities.calendar', $id) }}"
                                                class="btn btn-outline-secondary btn-sm"
                                                role="button"
                                                aria-label="Ver calendario de la Unidad ">
                                                <span class="fas fa-calendar-alt" aria-hidden="true"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2">No hay datos disponibles</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endif
            @endforeach
        </div>
    @endif
@endsection
