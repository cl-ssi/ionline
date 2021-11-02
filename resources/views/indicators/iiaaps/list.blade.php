@extends('layouts.app')

@section('title', $iiaaps->name)

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.iiaaps.index') }}">IAAPS</a></li>
        <li class="breadcrumb-item">{{$iiaaps->year}}</li>
    </ol>
</nav>

<h3 class="mb-3">{{$iiaaps->name}}.</h3>

<ol>
@foreach(array_map('trim', explode(';', $iiaaps->communes)) as $commune)
    <li><a href="{{ route('indicators.iiaaps.show', [$iiaaps->year, mb_strtolower(str_replace(" ", "_", $commune))]) }}">{{ucwords(mb_strtolower($commune))}}</a></li>
@endforeach
</ol>

@endsection

@section('custom_js')

@endsection