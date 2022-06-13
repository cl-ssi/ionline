@extends('layouts.app')

@section('title', 'Bodegas')

@section('content')

@include('warehouse.nav')

@livewire('warehouse.stores.store-index')

@endsection
