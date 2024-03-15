@extends('layouts.bt4.app')

@section('title', 'Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-file"></i> Nueva solicitud de Viático</h5>

<br>

@livewire('allowances.allowances-create', [
    'allowanceToEdit'       => null,
    'form'                  => 'create_to_replicate',
    'allowanceToReplicate'  => $allowance
])

@endsection

@section('custom_js')

@endsection