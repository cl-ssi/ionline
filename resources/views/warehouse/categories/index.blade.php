@extends('layouts.bt4.app')

@section('title', 'Categorías')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.categories.category-index', [
    'store' => $store,
    'nav' => $nav,
])

@endsection
