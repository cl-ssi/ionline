@extends('layouts.bt4.external')

@section('title', 'Nuevo Staff')

@section('content')

<div class="row mt-3">
    <div class="col-sm-5">
        <h4 class="mb-3">Mis Capacitaciones:</h4>
    </div>
</div>

<div class="col-sm">
    @livewire('trainings.search-training', [
        'index' => 'own'
    ])
</div>

@endsection

@section('custom_js')

@endsection
