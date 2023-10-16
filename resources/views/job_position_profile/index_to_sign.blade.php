@extends('layouts.bt4.app')

@section('title', 'Perfiles de Cargo')

@section('content')

@include('job_position_profile.partials.nav')

<h5><i class="fas fa-check-circle"></i> Perfiles de Cargo para aprobación</h5>

<br>

</div>

<div class="col-sm">
    @livewire('job-position-profile.search-job-position-profiles', [
        'index' => 'to_sign'
    ])
</div>

@endsection

@section('custom_js')

@endsection
