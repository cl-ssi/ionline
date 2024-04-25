@extends('layouts.bt5.app')

@section('title', 'Listado de STAFF')

@section('content')

 @include('trainings.partials.nav')

<div class="row">
    <div class="col-12 col-md-12 mt-3">
        <h4 class="mb-3">Mis Capacitaciones:</h4>
        <p>Incluye Capacitaciones de mi Unidad Organizacional: <b>{{ auth()->user()->organizationalUnit->name }}</b></p>
    </div>
</div>

<br />

</div>

<div class="col-sm">
    @livewire('trainings.search-training', [
        'index' => 'own'
    ])
</div>

@endsection

@section('custom_js')

@endsection