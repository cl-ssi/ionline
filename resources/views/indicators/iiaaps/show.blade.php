@extends('layouts.app')
@php
    $months = array (1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dic');
@endphp
@section('title', $iiaaps->name)

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.iiaaps.index') }}">IAAPS</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.iiaaps.list', $iiaaps->year) }}">{{$iiaaps->year}}</a></li>
        <li class="breadcrumb-item">{{ucwords(mb_strtolower($iiaaps->commune))}}</li>
    </ol>
</nav>

<style>
    .glosa {
        width: 400px;
    }
</style>

<h3 class="mb-3">Componentes según REM de {{$iiaaps->name}}.</h3>
<p><strong class="text-center">DE ESTRATEGIA DE REDES INTEGRADAS DE SERVICIOS DE SALUD (RISS)</strong></p>

<!-- Nav tabs -->
<ul class="nav nav-tabs d-print-none">
    @foreach($iiaaps->communes as $commune)
    <li class="nav-item">
        <a class="nav-link @if($commune == $iiaaps->commune) active @endif"
            href="{{ route('indicators.iiaaps.show', [$iiaaps->year, mb_strtolower(str_replace(' ', '_', $commune))]) }}">{{$commune}}
        </a>
    </li>
    @endforeach
</ul>

<!-- Tab panes -->
<div class="tab-content mt-3">
    <div class="table-responsive targetDiv" id="{{ str_replace(' ', '_', $commune) }}">
        <h4>Comuna de {{ucwords(mb_strtolower($iiaaps->commune))}}</h4>
        <!-- print indicadores APS -->
        @if($iiaaps->indicators->isEmpty())
            <p>No existen indicadores o no se han definido aún para el indicador IAAPS actual.</p>
        @else
        <div class="table-responsive">
            <table class="table table-sm table-bordered small mb-4">
                <thead>
                    <tr class="text-center">
                        <th>N°</th>
                        <th class="label">Indicador</th>
                        <th>Numerador / Denominador</th>
                        <th>Meta</th>
                        <th>% Cump.</th>
                        <th>Acum</th>
                        @foreach($months as $month)
                        <th>{{$month}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @foreach($iiaaps->indicators as $indicator)
                <!-- numerador comuna -->
                    <tr class="text-center">
                        <td rowspan="2" class="align-middle">{{$indicator->number}}</td>
                        <td rowspan="2" class="text-left align-middle glosa">{{$indicator->name}}.</td>
                        <td class="text-left glosa">{{$indicator->numerator}}. <span class="badge badge-secondary">{{$indicator->numerator_source}}</span></span></td>
                        <td rowspan="2" class="text-center align-middle">{{$indicator->goal}}</td>
                        <td rowspan="2" class="text-center align-middle">{{str_contains($indicator->goal ?? '%', '%') ? number_format($indicator->getCompliance2($iiaaps->commune, null), 2, ',', '.').'%' : number_format($indicator->getCompliance2($iiaaps->commune, null)/100, 2, '.', ',')}}</td>
                        <td class="text-center">{{$indicator->getValuesAcum2('numerador', $iiaaps->commune, null) != null ? number_format($indicator->getValuesAcum2('numerador', $iiaaps->commune, null), 0, ',', '.') : ''}}</td>
                        @if(Str::contains($indicator->numerator_source, ['FONASA', 'REM P']))
                            <td colspan="12" class="text-center">{{ $indicator->getValuesAcum2('numerador', $iiaaps->commune, null) != null ? number_format($indicator->getValuesAcum2('numerador', $iiaaps->commune, null), 0, ',', '.') : ''}}</td>
                        @else
                            @foreach($months as $number => $month)
                            <td class="text-right">{{ $indicator->getValueByFactorAndMonth2('numerador', $number, $iiaaps->commune, null) != null ? number_format($indicator->getValueByFactorAndMonth2('numerador', $number, $iiaaps->commune, null), 0, ',', '.') : ''}}</td>
                            @endforeach
                        @endif
                    </tr>
                <!-- denominador comuna -->
                    <tr class="text-center">
                        <td class="text-left glosa">{{$indicator->denominator}}. <span class="badge badge-secondary">{{$indicator->denominator_source}}</span></td>
                        <td class="text-center">{{$indicator->getValuesAcum2('denominador', $iiaaps->commune, null) != null ? number_format($indicator->getValuesAcum2('denominador', $iiaaps->commune, null), 0, ',', '.'): ''}}</td>
                        @if(Str::contains($indicator->denominator_source, ['FONASA', 'REM P']))
                            <td colspan="12" class="text-center">{{ $indicator->getValuesAcum2('denominador', $iiaaps->commune, null) != null ? number_format($indicator->getValuesAcum2('denominador', $iiaaps->commune, null), 0, ',', '.') : ''}}</td>
                        @else
                            @foreach($months as $number => $month)
                            <td class="text-right">{{ $indicator->getValueByFactorAndMonth2('denominador', $number, $iiaaps->commune, null) != null ? number_format($indicator->getValueByFactorAndMonth2('denominador', $number, $iiaaps->commune, null), 0, ',', '.') : ''}}</td>
                            @endforeach
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
            @foreach($iiaaps->establishments as $establishment)
            <div class="table-responsive targetDiv" id="{{ preg_replace("/[\s.,-]+/","_",$establishment) }}">
                <strong> {{ $establishment->alias_estab }} </strong>
                <table class="table table-sm table-bordered small mb-4">
                    <thead>
                        <tr class="text-center">
                            <th>N°</th>
                            <th class="label">Indicador</th>
                            <th>Numerador / Denominador</th>
                            <th>Meta</th>
                            <th>% Cump.</th>
                            <th>Acum</th>
                            @foreach($months as $month)
                            <th>{{$month}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($iiaaps->indicators as $indicator)
                    <!-- numerador establecimiento -->
                        <tr class="text-center">
                            <td rowspan="2" class="align-middle">{{$indicator->number}}</td>
                            <td rowspan="2" class="text-left align-middle glosa">{{$indicator->name}}.</td>
                            <td class="text-left glosa">{{$indicator->numerator}}.</span></td>
                            <td rowspan="2" class="text-center align-middle">{{$indicator->goal}}</td>
                            <td rowspan="2" class="text-center align-middle">{{str_contains($indicator->goal ?? '%', '%') ? number_format($indicator->getCompliance2(null, $establishment->alias_estab), 2, ',', '.').'%' : number_format($indicator->getCompliance2(null, $establishment->alias_estab)/100, 2, '.', ',')}}</td>
                            <td class="text-center">{{$indicator->getValuesAcum2('numerador', null, $establishment->alias_estab) != null ? number_format($indicator->getValuesAcum2('numerador', null, $establishment->alias_estab), 0, ',', '.') : ''}}</td>
                            @if(Str::contains($indicator->numerator_source, ['FONASA', 'REM P']))
                                <td colspan="12" class="text-center">{{ $indicator->getValuesAcum2('numerador', null, $establishment->alias_estab) != null ? number_format($indicator->getValuesAcum2('numerador', null, $establishment->alias_estab), 0, ',', '.') : ''}}</td>
                            @else
                                @foreach($months as $number => $month)
                                <td class="text-right">{{ $indicator->getValueByFactorAndMonth2('numerador', $number, null, $establishment->alias_estab) != null ? number_format($indicator->getValueByFactorAndMonth2('numerador', $number, null, $establishment->alias_estab), 0, ',', '.') : ''}}</td>
                                @endforeach
                            @endif
                        </tr>
                    <!-- denominador establecimiento -->
                        <tr class="text-center">
                            <td class="text-left glosa">{{$indicator->denominator}}.</td>
                            <td class="text-center">{{$indicator->getValuesAcum2('denominador', null, $establishment->alias_estab) != null ? number_format($indicator->getValuesAcum2('denominador', null, $establishment->alias_estab), 0, ',', '.') : ''}}</td>
                            @if(Str::contains($indicator->denominator_source, ['FONASA', 'REM P']))
                                <td colspan="12" class="text-center">{{ $indicator->getValuesAcum2('denominador', null, $establishment->alias_estab) != null ? number_format($indicator->getValuesAcum2('denominador', null, $establishment->alias_estab), 0, ',', '.') : ''}}</td>
                            @else
                                @foreach($months as $number => $month)
                                <td class="text-right">{{ $indicator->getValueByFactorAndMonth2('denominador', $number, null, $establishment->alias_estab) != null ? number_format($indicator->getValueByFactorAndMonth2('denominador', $number, null, $establishment->alias_estab), 0, ',', '.') : ''}}</td>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            @endforeach
        @endif
    </div>
</div>
<!-- fin print indicadores -->
@endsection

@section('custom_js')
@endsection