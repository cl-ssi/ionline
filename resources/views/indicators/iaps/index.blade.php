@extends('layouts.app')

@section('title', 'Indicadores APS')

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
    <div class="card">
        <div class="card-header">
            <strong>Indicadores APS.</strong>
        </div>

        <ul class="list-group list-group-flush">
        @foreach(range(now()->year, 2021) as $year)
            <li class="list-group-item">
                <a href="{{ route('indicators.iaps.list', $year) }}">{{$year}}</a>
            </li>
        @endforeach
            <li class="list-group-item">
                <a href="{{ route('indicators.aps.2020.index') }}">2020</a>
            </li>
        </ul>

    </div>
</div>

@endsection

@section('custom_js')

@endsection