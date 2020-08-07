<table class="table table-sm table-bordered small mb-4">
    <thead>
        <tr class="text-center">
            <th colspan="100%">ACCIÓN 1</th>
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
                {{ $data18_1[1] ['label']['numerador'] }}                
            </td>@foreach($data18_1[1]['numeradores'] as $numerador)
            @if ($loop->iteration <= 3)            
            @if (Auth::check())
            <td class="text-right"><a href="{{ route('indicators.comgescreate2020', [$numerador ? $numerador->id: 0, 18.1, $loop->iteration, 'numerador']) }}">{{ number_format( $numerador? $numerador->value: 0, 0, ',', '.') }}</a></td>
            @else
            <td class="text-right">{{ number_format( $numerador? $numerador->value: 0, 0, ',', '.') }}</td>
            @endif
            @endif
            @endforeach
            <td><strong>{{$data18_1[1]['numerador_acumulado']}}</strong></td>
            <td rowspan="2" class="align-middle text-center"> <span class="{{ ($data18_1[1]['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data18_1[1]['meta'])) ? 'text-success':'text-danger' }}">{{ number_format($data18_1[1]['cumplimiento'], 2, ',', '.') }}% </span></td>
            <td rowspan="2" class="align-middle text-center">{{ $data18_1[1]['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center"><a href="#" data-toggle="tooltip" title="{{$data18_1[1]['calculo']}}">{{ $data18_1[1]['resultado'] }}%</a></td>
            <td rowspan="2" class="align-middle text-center">{{ $data18_1[1]['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle text-center">{{$data18_1[1]['cumplimientoponderado']}}%</td>
        </tr>

        <tr class="text-center">
            <td class="text-left">
                {{ $data18_1[1]['label']['denominador'] }}
            </td>
            @foreach($data18_1[1]['denominadores'] as $denominador)
            @if ($loop->iteration <= 3)            
            @if (Auth::check())
            <td class="text-right"><a href="{{ route('indicators.comgescreate2020', [$denominador ? $denominador->id: 0, 18.1, $loop->iteration, 'denominador']) }}">{{ number_format( $denominador? $denominador->value: 0, 0, ',', '.') }}</a></td>
            @else
            <td class="text-right">{{ number_format( $denominador? $denominador->value: 0, 0, ',', '.') }}</td>
            @endif
            @endif
            @endforeach
            <td><strong>{{$data18_1[1]['denominador_acumulado']}}</strong></td>
        </tr>
    </tbody>
</table>