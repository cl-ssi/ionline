@for ($i = 1; $i <= 2; $i++)
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
                {{ $data8_1 [$i]['label']['numerador'] }}
            </td>            
            @foreach($data8_1[$i]['numeradores'] as $numerador)
            @if ($loop->iteration <= 3) <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                @endif
            @endforeach
            <td><strong>{{$data8_1[$i]['numerador_acumulado']}}</strong></td>
            <td rowspan="2" class="align-middle text-center"> <span class="{{ ($data8_1[$i]['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data8_1[$i]['meta'])) ? 'text-success':'text-danger' }}">{{ number_format($data8_1[$i]['cumplimiento'], 2, ',', '.') }}% </span></td>
            <td rowspan="2" class="align-middle text-center">{{ $data8_1[$i]['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center"><a href="#" data-toggle="tooltip" title="{{$data8_1[$i]['calculo']}}">{{ $data8_1[$i]['resultado'] }}%</a></td>
            <td rowspan="2" class="align-middle text-center">{{ $data8_1[$i]['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle text-center">{{$data8_1[$i]['cumplimientoponderado']}}%</td>
        </tr>

        <tr class="text-center">
            <td class="text-left">
                {{ $data8_1[$i]['label']['denominador'] }}
            </td>
            @foreach($data8_1[$i]['denominadores'] as $denominador)
            @if ($loop->iteration <= 3) <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                @endif
                @endforeach
            <td><strong>{{$data8_1[$i]['denominador_acumulado']}}</strong></td>
        </tr>
    </tbody>
</table>
<br>
@endfor