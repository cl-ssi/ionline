@extends('layouts.app')

@section('title', 'Administrar Bodegas')

@section('content')

@include('warehouse.nav-admin')

@livewire('warehouse.stores.store-index')

@endsection
