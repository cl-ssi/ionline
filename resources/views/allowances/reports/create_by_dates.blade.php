@extends('layouts.app')

@section('title', 'Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-file"></i> Reportes: Viáticos por fechas</h5>

<br />

@livewire('allowances.reports.create-by-dates')

@endsection

@section('custom_js')

@endsection