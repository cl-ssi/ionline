@extends('layouts.app')

@section('title', 'Metas Sanitarias Ley N° '. $law)

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
    <div class="card">
        <div class="card-header">
            <strong>Metas Sanitarias Ley N° {{$law}}</strong>
        </div>

        <ul class="list-group list-group-flush">
        @foreach(range(now()->year, 2021) as $year)
            <li class="list-group-item">
                <a href="{{ route('indicators.health_goals.list', [$law, $year]) }}">{{$year}}</a>
            </li>
        @endforeach
            <li class="list-group-item">
                <a href="{{ route('indicators.'.$law.'.2020.index') }}">2020</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('indicators.'.$law.'.2019.index') }}">2019</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('indicators.'.$law.'.2018.index') }}">2018</a>
            </li>
        </ul>

    </div>
</div>

@endsection

@section('custom_js')

@endsection
