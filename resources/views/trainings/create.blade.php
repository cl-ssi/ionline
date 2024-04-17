@extends('layouts.bt5.app')

@section('title', 'Listado de STAFF')

@section('content')

 @include('trainings.partials.nav')

<div class="row">
    <div class="col-sm-5">
        <h4 class="mt-2 mb-3">Nueva Capacitación:</h4>
    </div>
</div>

<br />

<div class="col-sm">
    @livewire('trainings.training-create', [
        'trainingToEdit'    => null,
        'form'              => 'create',
        'bootstrap'         => null
    ])
</div>

@endsection

@section('custom_js')

@endsection