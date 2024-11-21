@extends('layouts.bt5.app')

@section('title', 'Reporte')

@section('content')

    @include('drugs.nav')

    <h3 class="mb-3">Alertas</h3>

    <div class="row">
        <div class="col">
            <!-- Recepciones que no han sido enviadas al ISP -->
            <h4 class="mt-3">Recepciones que no han sido enviadas al ISP</h4>
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-bordered small">
                        <thead>
                            <tr>
                                <th>Nº Acta</th>
                                <th>Fecha</th>
                                <th>Días transcurridos</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($receptionsNotSentToIsp as $reception)
                                @foreach ($reception->items as $item)
                                    @if ($item->substance->isp && $item->substance->presumed)
                                        <tr>
                                            <td>{{ $reception->id }}</td>
                                            <td nowrap>{{ $reception->date?->format('Y-m-d') }}</td>
                                            <td class="{{ $reception->date->diffInDays(now()) > 15 ? 'text-danger' : '' }}">
                                                {{ (int) $reception->date->diffInDays(now()) }} días
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('drugs.receptions.show', $reception->id) }}"> <i
                                                        class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col">
            <!-- Recepciones que no han sido enviadas al ISP -->
            <h4 class="mt-3">Recepciones destruidas y no se ha enviado a fiscalía (> a 5 días)</h4>
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-bordered small">
                        <thead>
                            <tr>
                                <th>Nº Acta</th>
                                <th>Fecha</th>
                                <th>Días transcurridos</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($receptionsWithDestructionNotSendedToCourt as $reception)
                                @foreach ($reception->items as $item)
                                    @if ($item->substance->isp && $item->substance->presumed)
                                        <tr>
                                            <td>{{ $reception->id }}</td>
                                            <td nowrap>{{ $reception->date?->format('Y-m-d') }}</td>
                                            <td class="{{ $reception->date->diffInDays(now()) > 15 ? 'text-danger' : '' }}">
                                                {{ (int) $reception->date->diffInDays(now()) }} días
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('drugs.receptions.show', $reception->id) }}"> <i
                                                        class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col">
            <!-- Recepciones que no han sido enviadas al ISP -->
            <h4 class="mt-3">Recepciones no enviadas a fiscalia mayores a 30 días desde la recepción</h4>
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-bordered small">
                        <thead>
                            <tr>
                                <th>Nº Acta</th>
                                <th>Fecha</th>
                                <th>Días transcurridos</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($receptionsWithoutRecordToCourtOlderThan30Days as $reception)
                                @foreach ($reception->items as $item)
                                    @if ($item->substance->isp && $item->substance->presumed)
                                        <tr>
                                            <td>{{ $reception->id }}</td>
                                            <td nowrap>{{ $reception->date?->format('Y-m-d') }}</td>
                                            <td
                                                class="{{ $reception->date->diffInDays(now()) > 15 ? 'text-danger' : '' }}">
                                                {{ (int) $reception->date->diffInDays(now()) }} días
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('drugs.receptions.show', $reception->id) }}"> <i
                                                        class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col">
            <!-- Recepciones con contramuestras mayores a 2 años -->
            <h4 class="mt-3">Recepciones con contra muestras con más de 2 años</h4>
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-bordered small">
                        <thead>
                            <tr>
                                <th>Nº Acta</th>
                                <th>Fecha</th>
                                <th>Días transcurridos</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($itemsGreatherThanTwoYears as $reception)
                                <tr>
                                    <td>{{ $reception->id }}</td>
                                    <td nowrap>{{ $reception->date?->format('Y-m-d') }}</td>
                                    <td>
                                        {{ $reception->date->diffForHumans() }}
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('drugs.receptions.show', $reception->id) }}"> <i
                                                class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom_js')

@endsection
