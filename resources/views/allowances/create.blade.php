@extends('layouts.bt4.app')

@section('title', 'Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-file"></i> Nueva solicitud de Viático</h5>

<br>

@livewire('allowances.allowances-create', [
    'allowanceToEdit'   => '',
    'form'              => 'create'
])

@endsection

@section('custom_js')

@endsection