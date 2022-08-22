@extends('layouts.app')

@section('title', 'Categorías')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.categories.category-create', [
    'store' => $store,
    'nav' => $nav,
])

@endsection
