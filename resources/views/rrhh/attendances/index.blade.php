@extends('layouts.bt5.app')

@section('title', 'Registros de asistencia')

@section('content')

@include('rrhh.partials.nav')

<h3 class="mb-3">Registros de asistencia de {{ auth()->user()->short_name }} </h3>

<ul>
    @foreach($periods as $period)
        <li>
            <a href="{{ route('rrhh.attendance.show',[auth()->id(),$period['period']]) }}-01" target="_blank">
                {{ $period['period'] }}
            </a>
        </li>
    @endforeach
</ul>

@endsection

@section('custom_js')

@endsection