@extends('layouts.bt4.app')

@section('title', 'Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-file"></i> Mis viaticos</h5>
@if(auth()->user()->hasPermissionTo('Allowances: create'))
    <p>Incluye Víaticos de mi Unidad Organizacional: <b>{{ auth()->user()->organizationalUnit->name }}</p>
@endif
</div>


<div class="col-sm">
    @livewire('allowances.search-allowances', [
        'index' => 'own'
    ])
</div>


@endsection

@section('custom_js')

@endsection