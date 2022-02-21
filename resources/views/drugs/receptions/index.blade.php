@extends('layouts.app')

@section('title', 'Actas de recepción')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Actas de recepción</h3>

@can('Drugs: view receptions')

<form class="form d-print-none mb-3" method="GET" action="{{ route('drugs.receptions.index') }}">
<div class="input-group">

    @can('Drugs: create receptions')
    <div class="input-group-prepend">
        <a class="btn btn-primary" href="{{ route('drugs.receptions.create') }}"><i class="fas fa-plus"></i> Agregar nueva</a>
    </div>
    @endcan

    <input type="text" name="id" class="form-control" id="forsearch" onkeyup="filter(0)"
        placeholder="Escriba el número de acta para filtrar en las últimas dos semanas, si desea buscar en el histórico presione la lupa.">

    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">
            <i class="fas fa-search" aria-hidden="true"></i></button>
    </div>

</div>
</form>

<table class="table table-sm table-hover table-bordered small" id="TableFilter">
    <thead>
        <tr>
            <th>N.Acta</th>
            <th>Fecha Acta</th>
            <th>N° Doc</th>
            <th>Origen Oficio</th>
            <th>Origen Parte</th>
            <th>Recep</th>
            <th>Destr</th>
            <th class="d-print-none"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($receptions as $reception)
        <tr>
            <td class="text-center">{{ $reception->id }}</td>
            <td class="text-center" nowrap>{{ $reception->created_at->format('d-m-Y') }}</td>
            <td class="text-center">{{ $reception->document_number }}</td>
            <td>{{ $reception->documentPoliceUnit->name }}</td>
            <td>{{ $reception->partePoliceUnit->name }}</td>
            <td>
                @if( $reception->haveItems() )
                <a href="{{ route('drugs.receptions.record', $reception->id) }}" class="btn btn-outline-success btn-sm" target="_blank"><i class="fas fa-fw fa-file-pdf"></i></a>
                @endif
            </td>

            <td style="text-align: center;">
                @if($reception->haveItemsForDestruction() )
                    @if($reception->wasDestructed())
                    <a href="{{ route('drugs.destructions.show', $reception->destruction->id) }}" 
                        class="btn btn-outline-danger btn-sm" target="_blank"><i class="fas fa-fw fa-file-pdf"></i></a>
                    @else
                        <span class="badge badge-secondary" title="Dias restantes para su destrucción">
                            {{ $reception->created_at->diffInDays(Carbon\Carbon::now()) -15 }}
                        </span>
                    @endif
                @else
                    <i class="fas fa-ban" title="Sin items para destruir"></i>
                @endif
            </td>
            <td class="d-print-none">
                <a href="{{ route('drugs.receptions.show', $reception->id) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-fw fa-edit"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endcan

@endsection

@section('custom_js')

@endsection
