@extends('layouts.app')

@section('title', 'Programación APS')

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
<div class="card">
    <div class="card-header">
        <strong>Monitoreo COMGES Programación APS</strong>
    </div>
    <ul class="list-group list-group-flush">
        @foreach(range(now()->year, 2021) as $year)
            <li class="list-group-item">
                <a href="{{ route('indicators.programming_aps.show', [$year, 6]) }}">{{$year}}</a> <span class="badge badge-warning">En desarrollo</span>
            </li>
        @endforeach
        <li class="list-group-item">
            <a href="{{ route('indicators.program_aps.2020.index', 6) }}">2020</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('indicators.program_aps.2019.index') }}">2019</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('indicators.program_aps.2018.index') }}">2018</a>
        </li>
    </ul>
</div>
</div>

@endsection

@section('custom_js')

@endsection
