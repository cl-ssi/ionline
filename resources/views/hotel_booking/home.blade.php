@extends('layouts.app')

@section('title', 'Contratación Honorarios')

@section('content')

@include('hotel_booking.partials.nav')

<div class="jumbotron mt-3">
    <h1 class="display-6">Módulo de Reserva de Cabañas </h1>
    <p class="lead">kdsfhj</p>
</div>

@endsection

@section('custom_js')
<script>
$('a[data-toggle="tooltip"]').tooltip({
    animated: 'fade',
    placement: 'top',
    html: true
});
</script>
@endsection
