@extends('layouts.bt5.app')

@section('title', 'Editar DNC')

@section('content')

@include('identify_needs.partials.nav')

<h4 class="mt-3"><i class="far fa-newspaper"></i> Proceso de Detección de Necesidades</h4>

<div class="row mt-4">
    <div class="col">
        @livewire('identify-needs.create-identify-need', [
            'identifyNeedToEdit'    => $identifyNeed,
            'form'                  => 'edit'
        ])
    </div>
</div>

@endsection

@section('custom_js')

@endsection