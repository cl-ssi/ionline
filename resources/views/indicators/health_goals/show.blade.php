@extends('layouts.app')
@php
    $months = array (1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
@endphp
@section('title', 'Metas Sanitarias Ley N° ' . $healthGoal->law . ' / '. $healthGoal->year . ' - ' . $healthGoal->name)

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.health_goals.index', $healthGoal->law) }}">Ley {{number_format($healthGoal->law,0,',','.')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.health_goals.list', [$healthGoal->law, $healthGoal->year]) }}">{{$healthGoal->year}}</a></li>
        <li class="breadcrumb-item">{{$healthGoal->name}}</li>
    </ol>
</nav>

<style>
    .glosa {
        width: 400px;
    }
</style>

<h3 class="mb-3">{{$healthGoal->name}}. <small>- Cumplimiento : </small>
    {{--<br><small>- Cumplimiento : {{ number_format(($data1_1[1]['cumplimientoponderado']+$data1_2[1]['cumplimientoponderado']+$data1_3[1]['cumplimientoponderado'])/3, 2, ',', '.') }}%</small>--}}
</h3>
<h6 class="mb-3">Metas Sanitarias Ley N° {{number_format($healthGoal->law,0,',','.')}}</h6>
<hr>
@if($indicators->isEmpty())
    <p>No existen indicadores o no se han definido aún para la meta sanitaria actual.</p>
@else
    @foreach($indicators as $indicator)
        <h5 class="mb-3">{{$indicator->number}} {{$indicator->name}}.
        {{--@if($comges->users->contains('id', Auth::id())) <a href="{{route('indicators.comges.action.create', [$comges->year, $comges->number, isset($corte) ? $corte->number : $section, $indicator])}}"><span class="fa fa-plus-square"></span></a>@endif--}}</h5>
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
                            @foreach($months as $number => $month)
                            <td class="text-right">{{ $indicator->getValueByFactorAndMonth('numerador', $number) != null ? number_format($indicator->getValueByFactorAndMonth('numerador', $number), 0, ',', '.') : ''}}</td>
                            @endforeach
                        </tr>
                        <!-- denominador -->
                        <tr class="text-center">
                            <td class="text-left glosa">{{$indicator->denominator}}. <span class="badge badge-secondary">{{$indicator->denominator_source}}</td>
                            @if(isset($indicator->denominator_acum_last_year))
                            <td class="text-right">{{number_format($indicator->denominator_acum_last_year, 0, ',', '.')}}</td>
                            @endif
                            <td class="text-center">{{number_format(isset($indicator->denominator_acum_last_year) ? $indicator->getLastValueByFactor('denominador') : $indicator->getValuesAcum('denominador'), 0, ',', '.')}}</td>
                            @foreach($months as $number => $month)
                            <td class="text-right">{{ $indicator->getValueByFactorAndMonth('numerador', $number) != null ? number_format($indicator->getValueByFactorAndMonth('denominador', $number), 0, ',', '.') : ''}}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        <!-- fin print indicador -->
    @endforeach
@endif
@endsection

@section('custom_js')
<!-- <script>
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
</script> -->
@endsection