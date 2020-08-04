@extends('layouts.app')

@section('title', 'Ley 19664')

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
    <li class="list-group-item"><a href="{{ route('indicators.19664.2020.index') }}">2020</a> <span class="badge badge-warning">En Revisión</span></li>
    <li class="list-group-item"><a href="{{ route('indicators.19664.2019.index') }}">2019</a></li>
    <li class="list-group-item"><a href="{{ route('indicators.19664.2018.index') }}">2018</a></li>
</div>

@endsection

@section('custom_js')

@endsection
