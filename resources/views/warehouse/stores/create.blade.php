@extends('layouts.bt4.app')

@section('title', 'Crear Bodega')

@section('content')

@include('warehouse.nav')

@livewire('warehouse.stores.store-create')

@endsection
