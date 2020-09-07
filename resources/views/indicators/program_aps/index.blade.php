@extends('layouts.app')

@section('title', 'Programación APS')

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
    @include('indicators.program_aps.partials.card')
</div>

@endsection

@section('custom_js')

@endsection
