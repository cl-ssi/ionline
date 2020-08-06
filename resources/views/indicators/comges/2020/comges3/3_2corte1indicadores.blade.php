@for ($i = 1; $i <= 3; $i++)
<table class="table table-sm table-bordered small mb-4">
    <thead>
        <tr class="text-center">
            <th colspan="100%">ACCIÓN {{$i}}</th>
        </tr>
        <tr class="text-center">
            <th class="label">Indicador</th>            
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Acum</th>
            <th nowrap>% Cump. Obt</th>
            <th nowrap>% Cump. Esp</th>
            <th nowrap>Resultado</th>
            <th>Peso Medio Ponderado</th>
            <th>% de Cumplimiento Ponderado</th>
        </tr>
    </thead>
    <tbody>
        <tr class="text-center">
            <td class="text-left glosa">
                {!! $data3_2 [$i]['label']['numerador'] !!}
            </td>            
            @foreach($data3_2[$i]['numeradores'] as $numerador)
            @if ($loop->iteration <= 3)            
            @if (Auth::check())
            <td class="text-right"><a href="{{ route('indicators.comgescreate2020', [$numerador ? $numerador->id: 0, 3.2.$i, $loop->iteration, 'numerador']) }}">{{ number_format( $numerador? $numerador->value: 0, 0, ',', '.') }}</a></td>
            @else
            <td class="text-right">{{ number_format( $numerador? $numerador->value: 0, 0, ',', '.') }}</td>
            @endif
            @endif
            @endforeach
            <td><strong>{{$data3_2[$i]['numerador_acumulado']}}</strong></td>
            <td rowspan="2" class="align-middle text-center"> <span class="{{ ($data3_2[$i]['cumplimiento'] >= preg_replace("/[^0-9,]/", '', $data3_2[$i]['meta'])) ? 'text-success':'text-danger' }}">{{ number_format($data3_2[$i]['cumplimiento'], 2, ',', '.') }}% </span></td>
            <td rowspan="2" class="align-middle text-center">{{ $data3_2[$i]['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center"><a href="#" data-toggle="tooltip" title="{{$data3_2[$i]['calculo']}}">{{ $data3_2[$i]['resultado'] }}%</a></td>
            <td rowspan="2" class="align-middle text-center">{{ $data3_2[$i]['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle text-center">{{$data3_2[$i]['cumplimientoponderado']}}%</td>
        </tr>
        <tr class="text-center">
            <td class="text-left">
                {{ $data3_2[$i]['label']['denominador'] }}
            </td>
            @foreach($data3_2[$i]['denominadores'] as $denominador)
            @if ($loop->iteration <= 3)            
            @if (Auth::check())
            <td class="text-right"><a href="{{ route('indicators.comgescreate2020', [$denominador ? $denominador->id: 0, 3.2.$i, $loop->iteration, 'denominador']) }}">{{ number_format( $denominador? $denominador->value: 0, 0, ',', '.') }}</a></td>
            @else
            <td class="text-right">{{ number_format( $denominador? $denominador->value: 0, 0, ',', '.') }}</td>
            @endif
            @endif
            @endforeach
            <td><strong>{{$data3_2[$i]['denominador_acumulado']}}</strong></td>
        </tr>
    </tbody>
</table>
<br>
@endfor