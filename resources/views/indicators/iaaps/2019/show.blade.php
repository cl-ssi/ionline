@extends('layouts.app')

@section('title', 'IAAPS')

@section('content')

@include('indicators.partials.nav')

<h4 class="mb-3">
    Componentes según REM de Índice de Actividad de la Atención Primaria (IAAPS) 2019
</h4>


<strong class="text-center">
    DE ESTRATEGIA DE REDES INTEGRADAS DE SERVICIOS DE SALUD (RISS)
</strong>

<hr>

<h3 class="mb-3">Comuna de {{ $nombre_comuna }}</h3>


<table  class="table table-sm table-bordered small mb-4">
    <thead>
        <tr>
            <th>N°</th>
            <th>Indicador</th>
            <th>Numerador/Denominador</th>
            <th>Meta</th>
            <th nowrap>% Avance</th>
            <th>Acum.</th>
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





        <tr>
            <td class="align-middle" rowspan="2">3</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data3']['label']['indicador'] }}</td>
            <td>{{ $comunal['data3']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data3']['meta'] }}</td>
            <td class="align-middle text-center {{ ($comunal['data3']['avance'] >= $comunal['data3']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $comunal['data3']['avance'] }}
            </td>
            <td class="text-right">@numero($comunal['data3']['numerador_acumulado'])</td>
            @foreach( $comunal['data3']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data3']['label']['denominador'] }}</td>
            <td class="text-right">@numero($comunal['data3']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($comunal['data3']['denominador_acumulado'])</td>
        </tr>





        <tr>
            <td class="align-middle" rowspan="2">4</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data4']['label']['indicador'] }}</td>
            <td>{{ $comunal['data4']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data4']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($comunal['data4']['avance'] >= $comunal['data4']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $comunal['data4']['avance'] }}%
            </td>
            <td class="text-right">@numero($comunal['data4']['numerador_acumulado'])</td>
            @foreach( $comunal['data4']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data4']['label']['denominador'] }}</td>
            <td class="text-right">@numero($comunal['data4']['denominador_acumulado'])</td>
            @foreach( $comunal['data4']['denominadores'] as $denominador)
                <td class="text-right">@numero($denominador)</td>
            @endforeach
        </tr>



        <tr>
            <td class="align-middle" rowspan="2">5</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data5']['label']['indicador'] }}</td>
            <td>{{ $comunal['data5']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data5']['meta'] }}</td>
            <td class="align-middle text-center {{ ($comunal['data5']['avance'] >= $comunal['data5']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $comunal['data5']['avance'] }}
            </td>
            <td class="text-right">@numero($comunal['data5']['numerador_acumulado'])</td>
            @foreach( $comunal['data5']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data5']['label']['denominador'] }}</td>
            <td class="text-right">@numero($comunal['data5']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($comunal['data5']['denominador_acumulado'])</td>
        </tr>



        <tr>
            <td class="align-middle" rowspan="2">6</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data6']['label']['indicador'] }}</td>
            <td>{{ $comunal['data6']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data6']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($comunal['data6']['avance'] >= $comunal['data6']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $comunal['data6']['avance'] }}%
            </td>
            <td class="text-right">@numero($comunal['data6']['numerador_acumulado'])</td>
            @foreach( $comunal['data6']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data6']['label']['denominador'] }}</td>
            <td class="text-right">@numero($comunal['data6']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($comunal['data6']['denominador_acumulado'])</td>
        </tr>




        <tr>
            <td class="align-middle" rowspan="2">6.1</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data61']['label']['indicador'] }}</td>
            <td>{{ $comunal['data61']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data61']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($comunal['data61']['avance'] >= $comunal['data61']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $comunal['data61']['avance'] }}%
            </td>
            <td class="text-right">@numero($comunal['data61']['numerador_acumulado'])</td>
            @foreach( $comunal['data61']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data61']['label']['denominador'] }}</td>
            <td class="text-right">@numero($comunal['data61']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($comunal['data61']['denominador_acumulado'])</td>
        </tr>







        <tr>
            <td class="align-middle" rowspan="2">7</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data7']['label']['indicador'] }}</td>
            <td>{{ $comunal['data7']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data7']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($comunal['data7']['avance'] >= $comunal['data7']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $comunal['data7']['avance'] }}%
            </td>
            <td class="text-right">@numero($comunal['data7']['numerador_acumulado'])</td>
            @foreach( $comunal['data7']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>
                {{ $comunal['data7']['label']['denominador'] }}
                <span class="badge badge-secondary">REM P 2019</span>
            </td>
            <td class="text-right">@numero($comunal['data7']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">
                @numero($comunal['data7']['denominador_acumulado'])
            </td>
        </tr>



        <tr>
            <td class="align-middle" rowspan="2">8</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data8']['label']['indicador'] }}</td>
            <td>{{ $comunal['data8']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data8']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($comunal['data8']['avance'] >= $comunal['data8']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $comunal['data8']['avance'] }}%
            </td>
            <td class="text-right">@numero($comunal['data8']['numerador_acumulado'])</td>
            @foreach( $comunal['data8']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data8']['label']['denominador'] }}</td>
            <td class="text-right">@numero($comunal['data8']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($comunal['data8']['denominador_acumulado'])</td>
        </tr>





        <tr>
            <td class="align-middle" rowspan="2">9</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data9']['label']['indicador'] }}</td>
            <td>{{ $comunal['data9']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data9']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($comunal['data9']['avance'] >= $comunal['data9']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $comunal['data9']['avance'] }}%
            </td>
            <td class="text-right">@numero($comunal['data9']['numerador_acumulado'])</td>
            @foreach( $comunal['data9']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data9']['label']['denominador'] }}</td>
            <td class="text-right">@numero($comunal['data9']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($comunal['data9']['denominador_acumulado'])</td>
        </tr>




        <tr>
            <td class="align-middle" rowspan="2">10</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data10']['label']['indicador'] }}</td>
            <td>{{ $comunal['data10']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data10']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($comunal['data10']['avance'] >= $comunal['data10']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $comunal['data10']['avance'] }}%
            </td>
            <td class="text-right">@numero($comunal['data10']['numerador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($comunal['data10']['numerador_acumulado'])</td>
        </tr>
        <tr>
            <td>
                {{ $comunal['data10']['label']['denominador'] }}
                <span class="badge badge-secondary">Población</span>
            </td>
            <td class="text-right">@numero($comunal['data10']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($comunal['data10']['denominador_acumulado'])</td>
        </tr>





        <tr>
            <td class="align-middle" rowspan="2">13</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data13']['label']['indicador'] }}</td>
            <td>{{ $comunal['data13']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data13']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($comunal['data13']['avance'] >= $comunal['data13']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $comunal['data13']['avance'] }}%
            </td>
            <td class="text-right">@numero($comunal['data13']['numerador_acumulado'])</td>
            @foreach( $comunal['data13']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data13']['label']['denominador'] }}</td>
            <td class="text-right">@numero($comunal['data13']['denominador_acumulado'])</td>
            @foreach( $comunal['data13']['denominadores'] as $denominador)
                <td class="text-right">@numero($denominador)</td>
            @endforeach
        </tr>




        <tr>
            <td class="align-middle" rowspan="2">14</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data14']['label']['indicador'] }}</td>
            <td>{{ $comunal['data14']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data14']['meta'] }}%</td>
            <td class="align-middle text-center" rowspan="2"></td>
            <td class="text-right"></td>
            @for( $i=1; $i < 13; $i++)
                <td class="text-right"></td>
            @endfor
        </tr>
        <tr>
            <td>
                {{ $comunal['data14']['label']['denominador'] }}
            </td>
            <td class="text-right"></td>
            <td colspan="12" class="text-center">
                <span class="badge badge-secondary">No aplica primer corte</span>
            </td>
        </tr>





        <tr>
            <td class="align-middle" rowspan="2">15</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data15']['label']['indicador'] }}</td>
            <td>{{ $comunal['data15']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data15']['meta'] }}%</td>
            <td class="align-middle text-center" rowspan="2"></td>
            <td class="text-right"></td>
            @for( $i=1; $i < 13; $i++)
                <td class="text-right"></td>
            @endfor
        </tr>
        <tr>
            <td>
                {{ $comunal['data15']['label']['denominador'] }}
            </td>
            <td class="text-right"></td>
            <td colspan="12" class="text-center">
                <span class="badge badge-secondary">No aplica primer corte</span>
            </td>
        </tr>





        <tr>
            <td class="align-middle" rowspan="2">16</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data16']['label']['indicador'] }}</td>
            <td>{{ $comunal['data16']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data16']['meta'] }}%</td>
            <td class="align-middle text-center" rowspan="2"></td>
            <td class="text-right"></td>
            @for( $i=1; $i < 13; $i++)
                <td class="text-right"></td>
            @endfor
        </tr>
        <tr>
            <td>
                {{ $comunal['data16']['label']['denominador'] }}
            </td>
            <td class="text-right"></td>
            <td colspan="12" class="text-center">
                <span class="badge badge-secondary">No aplica primer corte</span>
            </td>
        </tr>




        <tr>
            <td class="align-middle" rowspan="2">17</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data17']['label']['indicador'] }}</td>
            <td>{{ $comunal['data17']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data17']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($comunal['data17']['avance'] >= $comunal['data17']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $comunal['data17']['avance'] }}%
            </td>
            <td class="text-right">@numero($comunal['data17']['numerador_acumulado'])</td>
            @foreach( $comunal['data17']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data17']['label']['denominador'] }}</td>
            <td class="text-right">@numero($comunal['data17']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($comunal['data17']['denominador_acumulado'])</td>
        </tr>




        <tr>
            <td class="align-middle" rowspan="2">18</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data18']['label']['indicador'] }}</td>
            <td>{{ $comunal['data18']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data18']['meta'] }}</td>
            <td class="align-middle text-center" rowspan="2"></td>
            <td class="text-right"></td>
            @for( $i=1; $i < 13; $i++)
                <td class="text-right"></td>
            @endfor
        </tr>
        <tr>
            <td>
                {{ $comunal['data18']['label']['denominador'] }}
            </td>
            <td class="text-right"></td>
            <td colspan="12" class="text-center">
                <span class="badge badge-secondary">No aplica primer corte</span>
            </td>
        </tr>


    </tbody>
</table>



<hr>


@foreach($establecimientos as $establecimiento)

<h4 class="mb-3">{{ $establecimiento['nombre'] }}</h4>

<table  class="table table-sm table-bordered small mb-4">
    <thead>
        <tr>
            <th>N°</th>
            <th>Indicador</th>
            <th>Numerador/Denominador</th>
            <th>Meta</th>
            <th nowrap>% Avance</th>
            <th>Acum.</th>
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

        <tr>
            <td class="align-middle" rowspan="2">3</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data3']['label']['indicador'] }}</td>
            <td>{{ $comunal['data3']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data3']['meta'] }}</td>
            <td class="align-middle text-center {{ ($establecimiento['data3']['avance'] >= $comunal['data3']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $establecimiento['data3']['avance'] }}
            </td>
            <td class="text-right">@numero($establecimiento['data3']['numerador_acumulado'])</td>
            @foreach( $establecimiento['data3']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data3']['label']['denominador'] }}</td>
            <td class="text-right">@numero($establecimiento['data3']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($establecimiento['data3']['denominador_acumulado'])</td>
        </tr>



        <tr>
            <td class="align-middle" rowspan="2">4</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data4']['label']['indicador'] }}</td>
            <td>{{ $comunal['data4']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data4']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($establecimiento['data4']['avance'] >= $comunal['data4']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $establecimiento['data4']['avance'] }}%
            </td>
            <td class="text-right">@numero($establecimiento['data4']['numerador_acumulado'])</td>
            @foreach( $establecimiento['data4']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data4']['label']['denominador'] }}</td>
            <td class="text-right">@numero($establecimiento['data4']['denominador_acumulado'])</td>
            @foreach( $establecimiento['data4']['denominadores'] as $denominador)
                <td class="text-right">@numero($denominador)</td>
            @endforeach
        </tr>




        <tr>
            <td class="align-middle" rowspan="2">5</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data5']['label']['indicador'] }}</td>
            <td>{{ $comunal['data5']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data5']['meta'] }}</td>
            <td class="align-middle text-center {{ ($establecimiento['data5']['avance'] >= $comunal['data5']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $establecimiento['data5']['avance'] }}
            </td>
            <td class="text-right">@numero($establecimiento['data5']['numerador_acumulado'])</td>
            @foreach( $establecimiento['data5']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data5']['label']['denominador'] }}</td>
            <td class="text-right">@numero($establecimiento['data5']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($establecimiento['data5']['denominador_acumulado'])</td>
        </tr>



        <tr>
            <td class="align-middle" rowspan="2">6</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data6']['label']['indicador'] }}</td>
            <td>{{ $comunal['data61']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data6']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($establecimiento['data6']['avance'] >= $comunal['data6']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $establecimiento['data6']['avance'] }}%
            </td>
            <td class="text-right">@numero($establecimiento['data6']['numerador_acumulado'])</td>
            @foreach( $establecimiento['data6']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>
                {{ $comunal['data6']['label']['denominador'] }}
                <span class="badge badge-secondary">REM P 2018</span>
            </td>
            <td class="text-right">@numero($establecimiento['data6']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($establecimiento['data6']['denominador_acumulado'])</td>
        </tr>




        <tr>
            <td class="align-middle" rowspan="2">6.1</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data61']['label']['indicador'] }}</td>
            <td>{{ $comunal['data61']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data61']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($establecimiento['data61']['avance'] >= $comunal['data61']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $establecimiento['data61']['avance'] }}%
            </td>
            <td class="text-right">@numero($establecimiento['data61']['numerador_acumulado'])</td>
            @foreach( $establecimiento['data61']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data61']['label']['denominador'] }}</td>
            <td class="text-right">@numero($establecimiento['data61']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($establecimiento['data61']['denominador_acumulado'])</td>
        </tr>



        <tr>
            <td class="align-middle" rowspan="2">7</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data7']['label']['indicador'] }}</td>
            <td>{{ $comunal['data7']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data7']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($establecimiento['data7']['avance'] >= $comunal['data7']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $establecimiento['data7']['avance'] }}%
            </td>
            <td class="text-right">@numero($establecimiento['data7']['numerador_acumulado'])</td>
            @foreach( $establecimiento['data7']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>
                {{ $comunal['data7']['label']['denominador'] }}
                <span class="badge badge-secondary">REM P 2018</span>
            </td>
            <td class="text-right">@numero($establecimiento['data7']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($establecimiento['data7']['denominador_acumulado'])</td>
        </tr>





        <tr>
            <td class="align-middle" rowspan="2">8</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data8']['label']['indicador'] }}</td>
            <td>{{ $comunal['data8']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data8']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($establecimiento['data8']['avance'] >= $comunal['data8']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $establecimiento['data8']['avance'] }}%
            </td>
            <td class="text-right">@numero($establecimiento['data8']['numerador_acumulado'])</td>
            @foreach( $establecimiento['data8']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data8']['label']['denominador'] }}</td>
            <td class="text-right">@numero($establecimiento['data8']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($establecimiento['data8']['denominador_acumulado'])</td>
        </tr>






        <tr>
            <td class="align-middle" rowspan="2">9</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data9']['label']['indicador'] }}</td>
            <td>{{ $comunal['data9']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data9']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($establecimiento['data9']['avance'] >= $comunal['data9']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $establecimiento['data9']['avance'] }}%
            </td>
            <td class="text-right">@numero($establecimiento['data9']['numerador_acumulado'])</td>
            @foreach( $establecimiento['data9']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data9']['label']['denominador'] }}</td>
            <td class="text-right">@numero($establecimiento['data9']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($establecimiento['data9']['denominador_acumulado'])</td>
        </tr>





        <tr>
            <td class="align-middle" rowspan="2">10</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data10']['label']['indicador'] }}</td>
            <td>{{ $comunal['data10']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data10']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($establecimiento['data10']['avance'] >= $comunal['data10']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $establecimiento['data10']['avance'] }}%
            </td>
            <td class="text-right">@numero($establecimiento['data10']['numerador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($establecimiento['data10']['numerador_acumulado'])</td>
        </tr>
        <tr>
            <td>
                {{ $comunal['data10']['label']['denominador'] }}
                <span class="badge badge-secondary">Población</span>
            </td>
            <td class="text-right">@numero($establecimiento['data10']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($establecimiento['data10']['denominador_acumulado'])</td>
        </tr>



        <tr>
            <td class="align-middle" rowspan="2">13</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data13']['label']['indicador'] }}</td>
            <td>{{ $comunal['data13']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data13']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($establecimiento['data13']['avance'] >= $comunal['data13']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $establecimiento['data13']['avance'] }}%
            </td>
            <td class="text-right">@numero($establecimiento['data13']['numerador_acumulado'])</td>
            @foreach( $establecimiento['data13']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data13']['label']['denominador'] }}</td>
            <td class="text-right">@numero($establecimiento['data13']['denominador_acumulado'])</td>
            @foreach( $establecimiento['data13']['denominadores'] as $denominador)
                <td class="text-right">@numero($denominador)</td>
            @endforeach
        </tr>


        <tr>
            <td class="align-middle" rowspan="2">14</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data14']['label']['indicador'] }}</td>
            <td>{{ $comunal['data14']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data14']['meta'] }}%</td>
            <td class="align-middle text-center" rowspan="2"></td>
            <td class="text-right"></td>
            @for( $i=1; $i < 13; $i++)
                <td class="text-right"></td>
            @endfor
        </tr>
        <tr>
            <td>
                {{ $comunal['data14']['label']['denominador'] }}
            </td>
            <td class="text-right"></td>
            <td colspan="12" class="text-center">
                <span class="badge badge-secondary">No aplica primer corte</span>
            </td>
        </tr>





        <tr>
            <td class="align-middle" rowspan="2">15</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data15']['label']['indicador'] }}</td>
            <td>{{ $comunal['data15']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data15']['meta'] }}%</td>
            <td class="align-middle text-center" rowspan="2"></td>
            <td class="text-right"></td>
            @for( $i=1; $i < 13; $i++)
                <td class="text-right"></td>
            @endfor
        </tr>
        <tr>
            <td>
                {{ $comunal['data15']['label']['denominador'] }}
            </td>
            <td class="text-right"></td>
            <td colspan="12" class="text-center">
                <span class="badge badge-secondary">No aplica primer corte</span>
            </td>
        </tr>





        <tr>
            <td class="align-middle" rowspan="2">16</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data16']['label']['indicador'] }}</td>
            <td>{{ $comunal['data16']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data16']['meta'] }}%</td>
            <td class="align-middle text-center" rowspan="2"></td>
            <td class="text-right"></td>
            @for( $i=1; $i < 13; $i++)
                <td class="text-right"></td>
            @endfor
        </tr>
        <tr>
            <td>
                {{ $comunal['data16']['label']['denominador'] }}
            </td>
            <td class="text-right"></td>
            <td colspan="12" class="text-center">
                <span class="badge badge-secondary">No aplica primer corte</span>
            </td>
        </tr>


        <tr>
            <td class="align-middle" rowspan="2">17</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data17']['label']['indicador'] }}</td>
            <td>{{ $comunal['data17']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data17']['meta'] }}%</td>
            <td class="align-middle text-center {{ ($establecimiento['data17']['avance'] >= $comunal['data17']['meta'] ? 'text-success':'text-danger') }}" rowspan="2">
                {{ $establecimiento['data17']['avance'] }}%
            </td>
            <td class="text-right">@numero($establecimiento['data17']['numerador_acumulado'])</td>
            @foreach( $establecimiento['data17']['numeradores'] as $numerador)
                <td class="text-right">@numero($numerador)</td>
            @endforeach
        </tr>
        <tr>
            <td>{{ $comunal['data17']['label']['denominador'] }}</td>
            <td class="text-right">@numero($establecimiento['data17']['denominador_acumulado'])</td>
            <td colspan="12" class="text-center">@numero($establecimiento['data17']['denominador_acumulado'])</td>
        </tr>



        <tr>
            <td class="align-middle" rowspan="2">18</td>
            <td class="align-middle" rowspan="2">{{ $comunal['data18']['label']['indicador'] }}</td>
            <td>{{ $comunal['data18']['label']['numerador'] }}</td>
            <td class="align-middle text-center" rowspan="2">{{ $comunal['data18']['meta'] }}%</td>
            <td class="align-middle text-center" rowspan="2"></td>
            <td class="text-right"></td>
            @for( $i=1; $i < 13; $i++)
                <td class="text-right"></td>
            @endfor
        </tr>
        <tr>
            <td>
                {{ $comunal['data18']['label']['denominador'] }}
            </td>
            <td class="text-right"></td>
            <td colspan="12" class="text-center">
                <span class="badge badge-secondary">No aplica primer corte</span>
            </td>
        </tr>

    </tbody>
</table>
@endforeach


@endsection

@section('custom_js')

@endsection
