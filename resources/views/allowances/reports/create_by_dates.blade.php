@extends('layouts.bt4.app')

@section('title', 'Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-file"></i> Reportes: Viáticos por fechas</h5>

<br />

</div>

<div class="container-fluid">
    @livewire('allowances.reports.create-by-dates')
</div>

@endsection

@section('custom_js')

@endsection