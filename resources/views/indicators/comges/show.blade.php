@extends('layouts.app')
@php
    $months = array (1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
    $months_by_section = array(1 => array(1,2,3), 2 => array(4,5,6), 3 => array(7,8,9), 4 => array(10,11,12));
    $romans = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV'];
    $title2 = $comges->name.' - '.$romans[isset($corte) ? $corte->number : $section].' Corte';
@endphp
@section('title', 'Compromiso de Gestión ' . $comges->year . ' - ' . $title2)

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.comges.index') }}">Comges</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.comges.list', [$comges->year]) }}">{{$comges->year}}</a></li>
        <li class="breadcrumb-item">{{$title2}}</li>
    </ol>
</nav>
@php
    $links = session()->has('links') ? session('links') : [];
    $currentLink = request()->path(); // Getting current URI like 'category/books/'
    array_unshift($links, $currentLink); // Putting it in the beginning of links array
    session(['links' => $links]); // Saving links array to the session
@endphp
<style media="screen">
    .label {
        width: 40%;
    }
</style>

<h3 class="mb-3">{{$title2}}.
    {{--<br><small>- Cumplimiento : {{ number_format(($data1_1[1]['cumplimientoponderado']+$data1_2[1]['cumplimientoponderado']+$data1_3[1]['cumplimientoponderado'])/3, 2, ',', '.') }}%</small>--}}
</h3>
@if($indicators->isEmpty())
    <p>No existen indicadores o no se han definido aún para el actual corte.</p>
@else
    <div id="collapsebutton" class="nodisp expandcollapse btn btn-small btn-success no-print" style="margin: 10px 0px;"><i class="glyphicon glyphicon-minus"></i> Contraer Todo</div>
    <div id="expandbutton" class="disp expandcollapse btn btn-small btn-success no-print" style="margin: 10px 0px;"><i class="glyphicon glyphicon-plus"></i>Expandir Todo</div>
    <hr>
    @foreach($indicators as $indicator)
        <p><a href="" class="dropdown-toggle" data-toggle="collapse" data-target="#ind{{ $indicator->number }}">{{ $comges->number }}.{{$indicator->number}} {{$indicator->name}}</a>
        @if($comges->users->contains('id', Auth::id())) <a href="{{route('indicators.comges.action.create', [$comges->year, $comges->number, isset($corte) ? $corte->number : $section, $indicator])}}"><span class="fa fa-plus-square"></span></a>@endif</p>
        <div class="collapse" id="ind{{ $indicator->number }}">
        <!-- resumen indicador -->
        @if($indicator->actions->isEmpty())
            <p>No existen acciones o no se han definido aún para el actual corte.</p>
        @else
        <table class="table table-sm table-bordered small mb-4">
            <thead>
                <tr class="text-center">
                    <th class="label" colspan="2">Acciones y/o metas específicas</th>
                    <th nowrap>Medios de verificación</th>
                    <th>Ponderación por corte <br> % de la evaluación anual</th>
                </tr>
            </thead>
            <tbody>
            @foreach($indicator->actions as $action)
                <tr class="text-center">
                    <td class="text-justify">{{$action->number}}.</td>
                    <td class="text-justify">{!! $action->name !!}</td>
                    <td class="text-justify">{!! $action->verification_means !!}</td>
                    @if($loop->iteration == 1) <td class="align-middle text-center" rowspan="0">{{$indicator->weighting_by_section}}%<br>{{number_format($corte->weighting)}}% de la evaluación anual</td> @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- fin resumen indicador -->
        <!-- acciones -->
        @foreach($indicator->actions as $action)
            <div class="table-responsive">
                <table class="table table-sm table-bordered small mb-4">
                    <thead>
                        <tr class="text-center">
                            <th colspan="100%">ACCIÓN {{$action->number}} @if($comges->users->contains('id', Auth::id())) <a href="{{route('indicators.comges.action.edit', [$comges->year, $comges->number, isset($corte) ? $corte->number : $section, $indicator, $action])}}"><span class="fa fa-edit"></span></a>@endif</th>
                        </tr>
                        <tr class="text-center">
                            <th class="label">Indicador</th>
                            @foreach($months_by_section[$corte->number] as $index)
                                <th>{{$months[$index]}}</th>
                            @endforeach
                            <th>Acum</th>
                            <th nowrap>% Cump. Obt</th>
                            <th nowrap>% Cump. Esp</th>
                            <th nowrap>Resultado</th>
                            <th>Peso Medio Ponderado</th>
                            <th>% de Cumplimiento Ponderado</th>
                        </tr>
                        <tbody>
                        <tr class="text-center">
                            <td class="text-left glosa">{{$action->numerator}}</td>
                            @if($action->numerator_source == null)
                            @foreach($action->values as $value)
                                @if($value->factor == "numerador")
                                <td class="text-right">{{number_format($value->value, 0, ',', '.')}}</td>
                                @endif
                            @endforeach
                            @else
                            @foreach($months_by_section[1] as $month)
                                <td class="text-right">0</td>
                            @endforeach
                            @endif
                            <td class="text-right"><strong>{{number_format($action->getValuesAcum('numerador'), 0, ',', '.')}}</strong></td>
                            <td rowspan="2" class="align-middle text-center">{{number_format($action->getCompliance(), 2, ',', '.')}}%</td>
                            @php($compliance = $action->getComplianceAssigned())
                            <td rowspan="2" class="align-middle text-center">{!! $compliance != null ? $compliance->left_result_operator_inverse . ' ' . $compliance->left_result_value . ($compliance->left_result_operator != null ? '%<br>' : '') . $compliance->right_result_operator . ' ' . $compliance->right_result_value . '%' : '' !!}</td>
                            <td rowspan="2" class="align-middle text-center">{{$compliance != null ? $compliance->compliance_value . '%' : ''}}</td>
                            <td rowspan="2" class="align-middle text-center">{{number_format($action->weighting, 0, ',', '.')}}%</td>
                            <td rowspan="2" class="align-middle text-center">{{number_format($action->weighting * ($compliance != null ? $compliance->compliance_value : 0) / 100, 0, ',', '.')}}%</td>
                        </tr>
                        <tr class="text-center">
                            <td class="text-left glosa">{{$action->denominator}}</td>
                            @if($action->denominator_source == null)
                            @foreach($action->values as $value)
                                @if($value->factor == "denominador")
                                <td class="text-right">{{number_format($value->value, 0, ',', '.')}}</td>
                                @endif
                            @endforeach
                            @else
                            @foreach($months_by_section[1] as $month)
                                <td class="text-right">0</td>
                            @endforeach
                            @endif
                            <td class="text-right"><strong>{{number_format($action->getValuesAcum('denominador'), 0, ',', '.')}}</strong></td>
                        </tr>
                    </thead>
                </table>
            </div>
        @endforeach
        @endif
        <!-- fin acciones -->
        </div>
        <hr>
    @endforeach
@endif
@endsection

@section('custom_js')
<script>
    $(document).ready(function() {
        $("#collapsebutton").hide();
        $("#expandbutton").click(function() {
            $('div.collapse').addClass('in').css("height", "");
            $("#expandbutton").hide();
            $("#collapsebutton").show();
            $('.collapse').collapse('show');
        });
        $("#collapsebutton").click(function() {
            $('div.collapse').removeClass('in');
            $("#expandbutton").show();
            $("#collapsebutton").hide();
            $('.collapse').collapse('hide');
        });
    });
</script>
@endsection