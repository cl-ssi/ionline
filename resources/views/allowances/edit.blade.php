@extends('layouts.bt4.app')

@section('title', 'Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-file"></i> Editar solicitud de Viático ID:{{ $allowance->id }}</h5>

<br>

@livewire('allowances.allowances-create', [
    'allowanceToEdit'       => $allowance,
    'form'                  => 'edit',
    'allowanceToReplicate'  => null
])

<hr/>
<div style="height: 300px; overflow-y: scroll;">
    @include('partials.audit', ['audits' => $allowance->audits()] )
</div>

@endsection

@section('custom_js')

@endsection