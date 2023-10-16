@extends('layouts.bt4.app')

@section('title', 'Bodegas')

@section('content')

@include('warehouse.nav')

<h4>
    Bodega Seleccionada:
    @if(Auth::user()->active_store)
        {{ optional(Auth::user()->active_store)->name }}
        <p>
            <small>
                {{ Auth::user()->active_store->address }}@if(Auth::user()->active_store->commune), {{ Auth::user()->active_store->commune->name }}@endif
            </small>
        </p>
    @else
        Ninguna bodega seleccionada
    @endif
</h4>


@endsection
