@extends('layouts.bt4.app')

@section('title', 'Transferencia de solicitudes')

@section('content')

@include('service_requests.partials.nav')

<h3>Transferencia de solicitudes (pendientes por visar)</h3><br>

@livewire('service-request.derive')

@endsection

@section('custom_js')

<script>

</script>

@endsection
