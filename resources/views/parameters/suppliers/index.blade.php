@extends('layouts.bt4.app')

@section('title', 'Mecanismo de Compra')

@section('content')

<div class="row">
    <div class="col-md-4">
        <h4> Mantenedor de Proveedores</h4>
    </div>
    <div class="col-md">
        <a class="btn btn-primary btn-sm" href="{{ route('parameters.suppliers.create') }}">
            <i class="fas fa-plus"></i> Crear
        </a>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-12">    
        @livewire('parameters.supplier.search-suppliers')
    </div>
</div>

@endsection

@section('custom_js')

@endsection
