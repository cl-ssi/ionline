@extends('layouts.app')

@section('title', 'Transferencia de solicitudes')

@section('content')

@include('service_requests.partials.nav')

<h3>Transferencia de solicitudes</h3><br>

@livewire('service-request.derive')

@endsection

@section('custom_js')

<script>

</script>

@endsection
