@extends('layouts.bt4.app')

@section('title', 'Programación APS')

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
<div class="card">
    <div class="card-header">
        <strong>Monitoreo COMGES Programación APS</strong>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <a href="{{ route('indicators.programming_aps.show', [2023, 6]) }}">2023</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('indicators.programming_aps.show', [2022, 6]) }}">2022</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('indicators.programming_aps.show', [2021, 6]) }}">2021</a>
        </li>
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
