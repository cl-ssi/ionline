@extends('layouts.app')

@section('content')

@forelse ($usersRem as $user)
<h3 class="mb-3">REM cargados para {{$user->establishment->name}}</h3>

<table class="table table-bordered table-sm" id="table_id">
    <thead>
        <tr class="text-center">
            <th>#</th>
            @foreach ($dates as $date)
            <th scope="col">{{$date['month']}} - {{$date['year']}}</th>
            @endforeach
        </tr>

        <tr>
        <td class="text-center font-weight-bold" >
        {{$user->establishment->name}}
        </td>
        </tr>
    </thead>
</table>


@empty
<h3 class="mb-3">No Tiene Asignado Establecimientos</h3>
<p>No Tiene Asignado Establecimientos para subir REM, contactarse con su encargado de estadistica para que le asigne alguno en caso de ser necesario</p>

@endforelse

@endsection

@section('custom_js')

@endsection