@extends('layouts.bt4.app')

@section('title', 'Perfiles de Cargo')

@section('content')

@include('job_position_profile.partials.nav')

<h5><i class="fas fa-id-badge"></i> Perfiles de Cargo</h5>

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
