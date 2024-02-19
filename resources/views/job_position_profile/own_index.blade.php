@extends('layouts.bt4.app')

@section('title', 'Perfiles de Cargo')

@section('content')

@include('job_position_profile.partials.nav')

<h5><i class="fas fa-id-badge"></i> Mis Perfiles de Cargo</h5>
<p>Incluye Perfiles de Cargo de mi Unidad Organizacional: <b>{{ auth()->user()->organizationalUnit->name }}</p>

<br>

</div>

<div class="col-sm">
    @livewire('job-position-profile.search-job-position-profiles', [
        'index' => 'own'
    ])
</div>

@endsection

@section('custom_js')

@endsection