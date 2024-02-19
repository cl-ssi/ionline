@extends('layouts.bt4.app')

@section('title', 'Gestión de Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-check-circle"></i> Gestión de viaticos:
    @if(auth()->user()->can('Allowances: sirh'))
        SIRH
    @endif
</h5>

<br />
</div>

<div class="col-sm">
    @livewire('allowances.search-allowances', [
        'index' => 'sign'
    ])
</div>

@endsection

@section('custom_js')

@endsection