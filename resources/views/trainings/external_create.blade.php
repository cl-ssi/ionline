@extends('layouts.bt4.external')

@section('title', 'Nuevo Staff')

@section('content')

<div class="row mt-3">
    <div class="col-sm-5">
        <h4 class="mt-2 mb-3">Nueva Capacitación:</h4>
    </div>
</div>

<br />

<div class="col-sm">
    @livewire('trainings.training-create', [
        'trainingToEdit'    => null,
        'form'              => 'create',
        'bootstrap'         => 'v4'
    ])
</div>

@endsection

@section('custom_js')

@endsection