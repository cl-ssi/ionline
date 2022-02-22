@extends('layouts.app')
@php
    $months = array (1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dic');
    if(isset($indicator)){ // law 19.813
        $healthGoal = $indicator->indicatorable;
        $communes = array('ALTO HOSPICIO', 'CAMIÑA', 'COLCHANE', 'HUARA', 'IQUIQUE', 'PICA', 'POZO ALMONTE');
        $goals = array_map('trim', explode(',', $indicator->goal)); //metas ordenadas por comuna index
    }
@endphp
@section('title', 'Metas Sanitarias Ley N° ' . $healthGoal->law . ' / '. $healthGoal->year . ' : ' . (isset($indicator) ? 'Meta N° ' . $healthGoal->number . ' - Indicador N° ' . $indicator->number : $healthGoal->name))

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.health_goals.index', $healthGoal->law) }}">Ley {{number_format($healthGoal->law,0,',','.')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.health_goals.list', [$healthGoal->law, $healthGoal->year]) }}">{{$healthGoal->year}}</a></li>
        <li class="breadcrumb-item">{{$healthGoal->name}} @if(isset($indicator)) - Indicador N° {{$indicator->number}} @endif</li>
    </ol>
</nav>

<style>
    .glosa {
        width: 400px;
    }
</style>

@if(isset($indicator)) <!-- ley  19.813 -->
<h3 class="mb-3">{{$indicator->name}}.</h3>

<!-- Nav tabs -->
<ul class="nav nav-tabs d-print-none" id="myTab" role="tablist">
    @foreach($communes as $commune)
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
            href="#{{ str_replace(" ","_",$commune) }}">{{$commune}}
        </a>
    </li>
    @endforeach
</ul>

<!-- Tab panes -->
<div class="tab-content mt-3">
    @foreach($communes as $index => $commune)
    <div class="tab-pane" id="{{ str_replace(" ","_",$commune) }}" role="tabpanel" >
        <h4>{{ $commune }}</h4>
        <!-- print indicador law 19.813 -->
        <div class="table-responsive">
            <table class="table table-sm table-bordered small mb-4">
                <thead>
                    <tr class="text-center">
                        <th class="label">Indicador</th>
                        <th>Meta</th>
                        <th>% Cump.</th>
                        <th>Acum</th>
                        @foreach($months as $month)
                        <th>{{$month}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                <!-- numerador comuna -->
                    <tr class="text-center">
                        <td class="text-left glosa">{{$indicator->numerator}}. <span class="badge badge-secondary">{{ $indicator->numerator_source }}</span></td>
                        <td rowspan="2" class="text-center align-middle">{{$goals[$index] ?? ''}}</td>
                        <td rowspan="2" class="text-center align-middle">{{number_format($indicator->getCompliance2($commune, null), 2, ',', '.')}}%</td>
                        <td class="text-center">{{number_format(isset($indicator->isNumRemP) ? $indicator->getLastValueByFactor2('numerador', $commune, null) : $indicator->getValuesAcum2('numerador', $commune, null), 0, ',', '.')}}</td>
                        @foreach($months as $number => $month)
                        <td class="text-right">{{ $indicator->getValueByFactorAndMonth2('numerador', $number, $commune, null) != null ? number_format($indicator->getValueByFactorAndMonth2('numerador', $number, $commune, null), 0, ',', '.') : ''}}</td>
                        @endforeach
                    </tr>
                <!-- denominador comuna -->
                    <tr class="text-center">
                        <td class="text-left glosa">{{$indicator->denominator}}. <span class="badge badge-secondary">{{ $indicator->denominator_source }}</span></td>
                        <td class="text-center">{{number_format(isset($indicator->isDenRemP) ? $indicator->getLastValueByFactor2('denominador', $commune, null) : $indicator->getValuesAcum2('denominador', $commune, null), 0, ',', '.')}}</td>
                        @foreach($months as $number => $month)
                        <td class="text-right">{{ $indicator->getValueByFactorAndMonth2('denominador', $number, $commune, null) != null ? number_format($indicator->getValueByFactorAndMonth2('denominador', $number, $commune, null), 0, ',', '.') : ''}}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <hr class="mt-5 mb-4">
            @foreach($indicator->establishments as $establishment)
                @if($establishment->comuna == $commune)
                <strong> {{ $establishment->alias_estab }} </strong>
                <table class="table table-sm table-bordered small mb-4">
                    <thead>
                        <tr class="text-center">
                            <th class="label">Indicador</th>
                            <th>Meta</th>
                            <th>% Cump.</th>
                            <th>Acum</th>
                            @foreach($months as $month)
                            <th>{{$month}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                    <!-- numerador establecimiento -->
                        <tr class="text-center">
                            <td class="text-left glosa">{{$indicator->numerator}}. <span class="badge badge-secondary">{{ $indicator->numerator_source }}</span></td>
                            <td rowspan="2" class="text-center align-middle">{{$goals[$index] ?? ''}}</td>
                            <td rowspan="2" class="text-center align-middle">{{number_format($indicator->getCompliance2(null, $establishment->alias_estab), 2, ',', '.')}}%</td>
                            <td class="text-center">{{number_format(isset($indicator->isNumRemP) ? $indicator->getLastValueByFactor2('numerador', null, $establishment->alias_estab) : $indicator->getValuesAcum2('numerador', null, $establishment->alias_estab), 0, ',', '.')}}</td>
                            @foreach($months as $number => $month)
                            <td class="text-right">{{ $indicator->getValueByFactorAndMonth2('numerador', $number, null, $establishment->alias_estab) != null ? number_format($indicator->getValueByFactorAndMonth2('numerador', $number, null, $establishment->alias_estab), 0, ',', '.') : ''}}</td>
                            @endforeach
                        </tr>
                    <!-- denominador establecimiento -->
                        <tr class="text-center">
                            <td class="text-left glosa">{{$indicator->denominator}}. <span class="badge badge-secondary">{{ $indicator->denominator_source }}</span></td>
                            <td class="text-center">{{number_format(isset($indicator->isDenRemP) ? $indicator->getLastValueByFactor2('denominador', null, $establishment->alias_estab) : $indicator->getValuesAcum2('denominador', null, $establishment->alias_estab), 0, ',', '.')}}</td>
                            @foreach($months as $number => $month)
                            <td class="text-right">{{ $indicator->getValueByFactorAndMonth2('denominador', $number, null, $establishment->alias_estab) != null ? number_format($indicator->getValueByFactorAndMonth2('denominador', $number, null, $establishment->alias_estab), 0, ',', '.') : ''}}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
                @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>
<!-- fin print indicador -->
@else <!-- ley 18.834 o ley 19.664 -->
    <h3 class="mb-3">{{$healthGoal->name}}. <small>- Cumplimiento : {{number_format($healthGoal->getCompliance(), 2, ',', '.')}}%</small></h3>
    <h6 class="mb-3">Metas Sanitarias Ley N° {{number_format($healthGoal->law,0,',','.')}}</h6>
    <hr>
    @if($healthGoal->indicators->isEmpty())
        <p>No existen indicadores o no se han definido aún para la meta sanitaria actual.</p>
    @else
        @foreach($healthGoal->indicators as $indicator)
            <h5 class="mb-3">{{$indicator->number}}. {{$indicator->name}}. @can('Indicators: manager')<small><a href="{{route('indicators.health_goals.ind.edit', [$healthGoal->law, $healthGoal->year, $healthGoal->number, $indicator])}}"><span class="fa fa-edit"></span></a></small> @endcan</h5>
            <!-- print indicador -->
                <div class="table-responsive">
                    <table class="table table-sm table-bordered small mb-4">
                        <thead>
                            <tr class="text-center">
                                <th class="label">Indicador</th>
                                <th>Meta</th>
                                <th>Pond.</th>
                                <th>% Cump.</th>
                                @if(isset($indicator->numerator_acum_last_year))
                                <th>Dic {{$healthGoal->year - 1}}</th>
                                @endif
                                <th>Acum</th>
                                @foreach($months as $month)
                                <th>{{$month}}</th>
                                @endforeach
                            </tr>
                        </thead>
                            <tbody>
                            <!-- numerador -->
                            <tr class="text-center">
                                <td class="text-left glosa">{{$indicator->numerator}}. <span class="badge badge-secondary">{{$indicator->numerator_source}}</span></td>
                                <td rowspan="2" class="text-center align-middle">{{$indicator->goal}}</td>
                                <td rowspan="2" class="text-center align-middle">{{$indicator->weighting}}%</td>
                                <td rowspan="2" class="text-center align-middle">{{number_format($indicator->getCompliance(), 2, ',', '.')}}% <br> <small>Aporte: {{number_format($indicator->getContribution(), 2, ',', '.')}}%</small></td>
                                @if(isset($indicator->numerator_acum_last_year))
                                <td class="text-right">{{number_format($indicator->numerator_acum_last_year, 0, ',', '.')}}</td>
                                @endif
                                <td class="text-center">{{number_format(isset($indicator->numerator_acum_last_year) ? $indicator->getLastValueByFactor('numerador') : $indicator->getValuesAcum('numerador'), 0, ',', '.')}}</td>
                                @if(in_array($indicator->numerator_source, ['Programación anual','Reporte RRHH']))
                                    <td colspan="12" class="text-center">{{ $indicator->getLastValueByFactor('numerador') != null ? number_format($indicator->getLastValueByFactor('numerador'), 0, ',', '.') : '' }}</td>
                                @else
                                    @foreach($months as $number => $month)
                                    <td class="text-right">{{ $indicator->getValueByFactorAndMonth('numerador', $number) != null ? number_format($indicator->getValueByFactorAndMonth('numerador', $number), 0, ',', '.') : ''}}</td>
                                    @endforeach
                                @endif
                            </tr>
                            <!-- denominador -->
                            <tr class="text-center">
                                <td class="text-left glosa">{{$indicator->denominator}}. <span class="badge badge-secondary">{{$indicator->denominator_source}}</span></td>
                                @if(isset($indicator->denominator_acum_last_year))
                                <td class="text-right">{{number_format($indicator->denominator_acum_last_year, 0, ',', '.')}}</td>
                                @endif
                                <td class="text-center">{{number_format(isset($indicator->denominator_acum_last_year) ? $indicator->getLastValueByFactor('denominador') : $indicator->getValuesAcum('denominador'), 0, ',', '.')}}</td>
                                @if(in_array($indicator->denominator_source, ['Programación anual','Reporte RRHH']))
                                    <td colspan="12" class="text-center">{{ $indicator->getLastValueByFactor('denominador') != null ? number_format($indicator->getLastValueByFactor('denominador'), 0, ',', '.') : '' }}</td>
                                @else
                                    @foreach($months as $number => $month)
                                    <td class="text-right">{{ $indicator->getValueByFactorAndMonth('denominador', $number) != null ? number_format($indicator->getValueByFactorAndMonth('denominador', $number), 0, ',', '.') : ''}}</td>
                                    @endforeach
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            <!-- fin print indicador -->
        @endforeach
    @endif
@endif
@endsection

@section('custom_js')
<script type="text/javascript">
    $('#myTab a[href="#IQUIQUE"]').tab('show') // Select tab by name
</script>
@endsection
