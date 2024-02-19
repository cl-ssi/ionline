@extends('layouts.bt4.app')

@section('title', 'Bodegas')

@section('content')

@include('warehouse.nav')

<h4>
    Bodega Seleccionada:
    @if(auth()->user()->active_store)
        {{ optional(auth()->user()->active_store)->name }}
        <p>
            <small>
                {{ auth()->user()->active_store->address }}@if(auth()->user()->active_store->commune), {{ auth()->user()->active_store->commune->name }}@endif
            </small>
        </p>
    @else
        Ninguna bodega seleccionada
    @endif
</h4>


@endsection
