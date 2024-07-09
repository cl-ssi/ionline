@extends('layouts.bt4.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-12">
        <h5 class="mb-3"><i class="far fa-file-alt"></i> Reporte: Estado de Aprobaciones.</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm">
        @livewire('replacement-staff.approvals-status')
    </div>
</div>

@endsection

@section('custom_js')

@endsection