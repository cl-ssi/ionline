@extends('layouts.bt5.app')

@section('title', 'Solicitud Permiso Capacitación')

@section('content')

 @include('trainings.partials.nav')

<div class="row">
    <div class="col-sm-5">
        <h5 class="mt-2 mb-3">Mi Capacitación ID: {{ $training->id }}
            @switch($training->StatusValue)
                @case('Guardado')
                    <span class="badge text-bg-primary">{{ $training->StatusValue }}</span>
                    @break
                                
                @case('Enviado')
                    <span class="badge text-bg-warning">{{ $training->StatusValue }}</span>
                    @break

                @case('Pendiente')
                    <span class="badge text-bg-warning">{{ $training->StatusValue }}</span>
                    @break
            @endswitch
        </h5>
    </div>
</div>

<br />

<div class="col-sm">
    @livewire('trainings.training-create', [
        'trainingToEdit'    => $training,
        'form'              => 'edit',
        'bootstrap'         => null
    ])
</div>

@endsection

@section('custom_js')

@endsection