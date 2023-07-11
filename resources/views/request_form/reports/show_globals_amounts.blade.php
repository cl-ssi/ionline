@extends('layouts.app')

@section('title', 'Reportes')

@section('content')

    @include('request_form.partials.nav')

    <div class="row">
        <div class="col-sm">
            <h5 class="mb-3">Reporte:</h5>
            <h6 class="mb-3"><i class="fas fa-fw fa-list-ol"></i>Formularios - Globales</h6>
        </div>
    </div>

    @livewire('request-form.report-global-budget')
@endsection