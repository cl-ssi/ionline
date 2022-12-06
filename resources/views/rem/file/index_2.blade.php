@extends('layouts.app')

@section('content')

<h3 class="mb-3">Carga de REMs</h3>

@canany(['be god','Rem: admin'])
<a class="btn btn-primary" href="{{ route('rem.users.index') }}">
    <i class="fas fa-users fa-fw"></i> Usuarios REM
</a>
<br>
<br>
@endcan
<table class="table table-bordered table-sm small">
    <thead>
        <tr class="text-center">
            <th>Establecimiento/Período</th>
            @foreach($periods as $period)
            <th>{{ $period->year??'' }}-{{$period->month??''}}</th>
            @endforeach
        </tr>
        @foreach(auth()->user()->remEstablishments as $remEstablishment)
        <td class="text-center font-weight-bold">
            {{$remEstablishment->establishment->name}}
        </td>

        @foreach($periods as $period)
        <td>
            @foreach($period->series as $serie)
            <ul>
                {{$serie->serie->name??''}}
            </ul>
            @endforeach
        </td>
        @endforeach

        @endforeach

    </thead>
</table>

@endsection