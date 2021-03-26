@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('service_requests.partials.nav')

<a class="btn btn-outline-success mb-3"
    href="{{ route('rrhh.service-request.report.export-sirh-txt') }}">
    <i class="far fa-file"></i> Descargar Formato SIRH
</a>

@livewire('service-request.mass-update-sirh-status')

@endsection

@section('custom_js')

@endsection
