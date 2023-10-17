@extends('layouts.bt4.app')

@section('title', 'Usuarios de Bodega')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.stores.manage-store-users', [
    'store' => $store
])

@endsection
