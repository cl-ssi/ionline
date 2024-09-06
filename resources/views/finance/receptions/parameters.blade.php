@extends('layouts.bt5.app')

@section('title', 'Estados de pago')

@section('content')

@include('finance.receptions.partials.nav')


<h3 class="mb-3">Parametros de actas de recepción</h3>

@livewire('parameters.parameter.single-manager',[
    'module' => 'Receptions',
    'parameter' => 'emails_notification',
    'type' => 'text',
    'description' => 'Correos electrónicos de notificación de cada recepción firmada, separados por coma',
], key('email_notification'))


@endsection
