@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')

@include('job_position_profile.partials.nav')

<br>

<h5><i class="fas fa-id-badge"></i> Nuevo Perfil de Cargo</h5>

<br>

@livewire('job-position-profile.create-job-position-profiles', [
    'action'    => 'store',
])

@endsection

@section('custom_js')

@endsection
