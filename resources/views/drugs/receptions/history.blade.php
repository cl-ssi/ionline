@extends('layouts.bt5.app')

@section('title', 'Historial de Recepción')

@section('content')

    @include('drugs.nav')

    <h3 class="mb-3">Historial de registro de Acta de Recepción {{ $reception->id }} </h3>

    <ul>
        <li>{{ $reception->created_at }} - Fecha creación del acta de recepción; {{ $reception->updated_at }} - Ultima fecha de modificación del acta de recepción</li>
        @foreach ($reception->items as $item)
            <li>{{ $item->created_at }} - Fecha creación del item {{ $item->id }}; {{ $item->updated_at }} - Ultima fecha de modificación del item</li>
        @endforeach
        @if($reception->recordToCourt)
        <li>
            {{ $reception->recordToCourt->created_at }} - Fecha creación del acta de envío a fiscalía; {{ $reception->recordToCourt->updated_at }} - Ultima fecha de modificación del acta de envío a fiscalía
        </li>
        @endif
        @if($reception->destruction)
        <li>
            {{ $reception->destruction->created_at }} - Fecha creación del acta de destrucción; {{ $reception->destruction->updated_at }} - Ultima fecha de modificación del acta de destrucción
        </li>
        @endif
        @if($reception->sampleToIsp)
        <li>
            {{ $reception->sampleToIsp->created_at }} - Fecha creación del acta de envío de muestra al ISP; {{ $reception->sampleToIsp->updated_at }} - Ultima fecha de modificación del acta de envío de muestra al ISP
        </li>
        @endif
        @if($reception->deletedDestructions)
        @foreach ($reception->deletedDestructions as $deletedDestruction)
        <li>
            {{ $deletedDestruction->created_at }} - Fecha creación del acta de destrucción eliminada; {{ $deletedDestruction->updated_at }} - Ultima fecha de modificación del acta de destrucción eliminada - {{ $deletedDestruction->deleted_at }} - Fecha de eliminación del acta de destrucción eliminada
        </li>
        @endforeach
        @endif

    </ul>

    @can('be god')
        @include('partials.audit', ['audits' => $reception->audits()])
    @endcan

@endsection
