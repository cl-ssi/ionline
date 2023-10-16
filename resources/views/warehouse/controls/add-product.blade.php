@extends('layouts.bt4.app')

@section('title', 'Agregar Producto')

@section('content')

@include('warehouse.' . $nav)

<div class="row">
    <div class="col">
        <h5>
            {{ $control->type_format }} {{ $control->id }}: {{ $store->name }}
        </h5>
    </div>
    <div class="col text-right">
        @if($control->requestForm)
            <a
                class="btn btn-sm btn-primary"
                href="{{ route('request_forms.show', $control->requestForm) }}"
                target="_blank"
            >
                <i class="fas fa-file-alt"></i> FR Folio #{{ $control->requestForm->folio }}
            </a>
        @else
            <a
                class="btn btn-sm btn-danger disabled"
                href="#"
                target="_blank"
            >
                <i class="fas fa-exclamation-triangle"></i> No hay FR relacionada
            </a>
        @endif
    </div>
</div>

@if($control->isReceiving())
    @include('warehouse.controls.details-receiving', [
        'control' => $control
    ])
@else
    @include('warehouse.controls.details-dispatch', [
        'control' => $control
    ])
@endif

@if($control->isOpen())
    <hr>
    <h4 class="my-2">Agregar Producto</h4>

    @if($control->isReceiving())
        @livewire('warehouse.control.control-receiving-add-product', [
            'store' => $store,
            'control' => $control,
        ])
    @else
        @livewire('warehouse.control.control-dispatch-add-product', [
            'store' => $store,
            'control' => $control
        ])
    @endif
@endif

<hr>
<h4>Productos agregados</h4>

@livewire('warehouse.control.control-product-list', [
    'control' => $control,
    'store' => $store,
    'nav' => $nav,
])

@endsection
