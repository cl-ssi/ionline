@for ($i = 1; $i <= 1; $i++)
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
                {{ $data15_3 [$i]['label']['numerador'] }}
            </td>            
            @foreach($data15_3[$i]['numeradores'] as $numerador)
            @if ($loop->iteration <= 3)            
            @if (Auth::check())
            <td class="text-right"><a href="{{ route('indicators.comgescreate2020', [$numerador ? $numerador->id: 0, 15.3, $loop->iteration, 'numerador']) }}">{{ number_format( $numerador? $numerador->value: 0, 0, ',', '.') }}</a></td>
            @else
            <td class="text-right">{{ number_format( $numerador? $numerador->value: 0, 0, ',', '.') }}</td>
            @endif
            @endif
            @endforeach
            <td><strong>{{$data15_3[$i]['numerador_acumulado']}}</strong></td>
            <td rowspan="2" class="align-middle text-center"> <span class="{{ ($data15_3[$i]['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data15_3[$i]['meta'])) ? 'text-success':'text-danger' }}">{{ number_format($data15_3[$i]['cumplimiento'], 2, ',', '.') }}% </span></td>
            <td rowspan="2" class="align-middle text-center">{{ $data15_3[$i]['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center"><a href="#" data-toggle="tooltip" title="{{$data15_3[$i]['calculo']}}">{{ $data15_3[$i]['resultado'] }}%</a></td>
            <td rowspan="2" class="align-middle text-center">{{ $data15_3[$i]['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle text-center">{{$data15_3[$i]['cumplimientoponderado']}}%</td>
        </tr>

        <tr class="text-center">
            <td class="text-left">
                {{ $data15_3[$i]['label']['denominador'] }}
            </td>
            @foreach($data15_3[$i]['denominadores'] as $denominador)
            @if ($loop->iteration <= 3)            
            @if (Auth::check())
            <td class="text-right"><a href="{{ route('indicators.comgescreate2020', [$denominador ? $denominador->id: 0, 15.3, $loop->iteration, 'denominador']) }}">{{ number_format( $denominador? $denominador->value: 0, 0, ',', '.') }}</a></td>
            @else
            <td class="text-right">{{ number_format( $denominador? $denominador->value: 0, 0, ',', '.') }}</td>
            @endif
            @endif
            @endforeach
            <td><strong>{{$data15_3[$i]['denominador_acumulado']}}</strong></td>
        </tr>
    </tbody>
</table>
<br>
@endfor