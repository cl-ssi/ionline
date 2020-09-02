@extends('layouts.app')

@section('title', 'IAAPS')

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
        @include('indicators.iaaps.partials.card')
</div>

@endsection

@section('custom_js')

@endsection
