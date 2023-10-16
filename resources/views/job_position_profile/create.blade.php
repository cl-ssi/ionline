@extends('layouts.bt4.app')

@section('title', 'Nuevo Staff')

@section('content')

@include('job_position_profile.partials.nav')

<br>

<h5><i class="fas fa-id-badge"></i> Nuevo Perfil de Cargo</h5>

<br>

<div class="alert alert-info alert-sm" role="alert">
    <div class="row">
        <div class="col-sm">
            <i class="fas fa-info-circle"></i> <b>Guía instructiva 2023</b>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10">
            <br />
            El <b>Depto. Desarrollo y Gestión del Talento</b> dispone este instructivo para facilitar la creación de 
            Perfiles de cargo en iOnline.
        </div>
        <div class="col-sm-2">
            <br />
            <a class="btn btn-secondary btn-sm float-right" href="{{ route('job_position_profile.instructivo_2023') }}"
                target="blank">
                <i class="far fa-file-pdf"></i> Descargar aquí
            </a>
        </div>
    </div>
</div>

<br>

@livewire('job-position-profile.create-job-position-profiles', [
    'action'    => 'store',
])

@include('job_position_profile.modals.degrees_guide')

@endsection

@section('custom_js')

@endsection
