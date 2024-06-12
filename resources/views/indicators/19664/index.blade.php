@extends('layouts.bt4.app')

@section('title', 'Ley 19664')

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
    <li class="list-group-item"><a href="{{ route('indicators.health_goals.list', [19664, 2024]) }}">2024</a></li>
    <li class="list-group-item"><a href="{{ route('indicators.health_goals.list', [19664, 2023]) }}">2023</a></li>
    <li class="list-group-item"><a href="{{ route('indicators.health_goals.list', [19664, 2022]) }}">2022</a></li>
    <li class="list-group-item"><a href="{{ route('indicators.health_goals.list', [19664, 2021]) }}">2021</a></li>
    <li class="list-group-item"><a href="{{ route('indicators.19664.2020.index') }}">2020</a></li>
    <li class="list-group-item"><a href="{{ route('indicators.19664.2019.index') }}">2019</a></li>
    <li class="list-group-item"><a href="{{ route('indicators.19664.2018.index') }}">2018</a></li>
</div>

@endsection

@section('custom_js')

@endsection
