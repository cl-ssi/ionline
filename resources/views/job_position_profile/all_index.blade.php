@extends('layouts.bt4.app')

@section('title', 'Perfiles de Cargo')

@section('content')

@include('job_position_profile.partials.nav')

<h5><i class="fas fa-id-badge"></i> Todos los Perfiles de Cargo</h5>

<br>

</div>

<div class="col-sm">
    @livewire('job-position-profile.search-job-position-profiles', [
        'index' => 'all'
    ])
</div>

@endsection

@section('custom_js')

<script>
    $('[data-toggle="tooltip"]').tooltip()
</script>


@endsection