@extends('layouts.app')

@section('title', 'Ley 18834')

@section('content')

@include('indicators.partials.nav')

<style media="screen">
    .label {
        width: 40%;
    }
</style>

<h3 class="mb-3">CGU Dr. Héctor Reyno</h3>

<hr>

<h5 class="mb-3">{{ $data111['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th class="label">Indicador</th>
            <th nowrap>Pond</th>
            <th nowrap>Meta</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr class="text-center">
            <td class="text-left">{{ $data111['label']['numerador'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data111['ponderacion'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data111['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data111['cumplimiento'] }}%</td>
            <td class="text-rigth">{{ $data111['numerador'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data111['numerador_6'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data111['numerador_12'] }}</td>
        </tr>
        <tr class="text-center">
            <td class="text-left">{{ $data111['label']['denominador'] }}</td>
            <td class="text-rigth">{{ $data111['denominador'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data111['denominador_6'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data111['denominador_12'] }}</td>
        </tr>
    </tbody>
</table>




<h5 class="mb-3">{{ $data112['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th class="label">Indicador</th>
            <th nowrap>Pond</th>
            <th nowrap>Meta</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr class="text-center">
            <td class="text-left">{{ $data112['label']['numerador'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data112['ponderacion'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data112['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data112['cumplimiento'] }}%</td>
            <td class="text-rigth">{{ $data112['numerador'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data112['numerador_6'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data112['numerador_12'] }}</td>
        </tr>
        <tr class="text-center">
            <td class="text-left">{{ $data112['label']['denominador'] }}</td>
            <td class="text-rigth">{{ $data112['denominador'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data112['denominador_6'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data112['denominador_12'] }}</td>
        </tr>
    </tbody>
</table>




<h5 class="mb-3">{{ $data113['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th class="label">Indicador</th>
            <th nowrap>Pond</th>
            <th nowrap>Meta</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr class="text-center">
            <td class="text-left">{{ $data113['label']['numerador'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data113['ponderacion'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data113['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data113['cumplimiento'] }}%</td>
            <td class="text-rigth">{{ $data113['numerador'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data113['numerador_6'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data113['numerador_12'] }}</td>
        </tr>
        <tr class="text-center">
            <td class="text-left">{{ $data113['label']['denominador'] }}</td>
            <td class="text-rigth">{{ $data113['denominador'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data113['denominador_6'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-rigth">{{ $data113['denominador_12'] }}</td>
        </tr>
    </tbody>
</table>





<h5 class="mb-3">{{ $data3a['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th class="label">Indicador</th>
            <th nowrap>Ponde</th>
            <th nowrap>Meta</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr class="text-center">
            <td class="text-left">{{ $data3a['label']['numerador'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data3a['ponderacion'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data3a['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data3a['cumplimiento'] }}%</td>
            <td class="text-rigth">{{ $data3a['numerador_acumulado'] }}</td>
            @foreach($data3a['numeradores'] as $mes)
                <td>{{ $mes }} </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">{{ $data3a['label']['denominador'] }}</td>
            <td class="text-rigth">{{ $data3a['denominador_acumulado'] }}</td>
            @foreach($data3a['denominadores'] as $mes)
                <td>{{ $mes }} </td>
            @endforeach
        </tr>
    </tbody>
</table>



@endsection

@section('custom_js')
<script type="text/javascript">
    $('#myTab a[href="#IQUIQUE"]').tab('show') // Select tab by name
</script>
@endsection
