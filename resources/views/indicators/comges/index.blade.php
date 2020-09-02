@extends('layouts.app')

@section('title', 'Compromiso de Gestión')

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
    <div class="card">
        <div class="card-header">
            <strong>Compromiso de Gestión - (Comges)</strong>
        </div>

        <ul class="list-group list-group-flush">
        @foreach(range(now()->year, 2019) as $year)
            <li class="list-group-item">
                <a href="{{ route('indicators.comges.list', [$year]) }}">{{$year}}</a>
            </li>
        @endforeach
        </ul>

    </div>
</div>

@endsection

@section('custom_js')

@endsection