@extends('layouts.app')

@section('title', 'Farmacia')

@section('content')

@include('pharmacies.nav')

@canany(['Pharmacy: SSI (id:1)', 'Pharmacy: REYNO (id:2)'])
    <h3 class="mb-3">Bienvenido al módulo de bodega de medicamentos</h3>
@endcan

@can('Pharmacy: APS (id:3)')
    <h3 class="mb-3">Bienvenido al módulo de bodega APS</h3>
@endcan

@can('Pharmacy: Servicios generales (id:4)')
    <h3 class="mb-3">Bienvenido al módulo de bodega Servicios Generales</h3>
@endcan



@can('Pharmacy: SSI (id:1)')
    <h4>Bodega selecionada: SSI</h4>
@endcan

@can('Pharmacy: REYNO (id:2)')
    <h4>Bodega selecionada: Hector Reyno</h4>
@endcan

@can('Pharmacy: APS (id:3)')
    <h4>Bodega selecionada: APS</h4>
@endcan

@can('Pharmacy: Servicios generales (id:4)')
    <h4>Bodega selecionada: Servicios Generales</h4>
@endcan

@endsection

@section('custom_js')

@endsection
