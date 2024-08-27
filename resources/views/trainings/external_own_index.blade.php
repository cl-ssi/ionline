@extends('layouts.bt4.external')

@section('title', 'Nuevo Staff')

@section('content')

<div class="row mt-3">
    <div class="col-sm-5">
        <h4 class="mb-3">Mis Capacitaciones:</h4>
    </div>
</div>

<div class="col-sm">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @livewire('trainings.search-training', [
        'index'     => 'own',
        'bootstrap' => 'v4'
    ])
</div>

@endsection

@section('custom_js')

@endsection
