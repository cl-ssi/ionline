@extends('layouts.bt4.app')

@section('title', 'Editar Categoría')

@section('content')

@include('warehouse.' . $nav)

@livewire('warehouse.categories.category-edit', [
    'store' => $store,
    'category' => $category,
    'nav' => $nav,
])

@endsection
