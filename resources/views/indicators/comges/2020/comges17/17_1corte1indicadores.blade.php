<table class="table table-sm table-bordered small mb-4">
    <thead>
        <tr class="text-center">
            <th colspan="100%">ACCIÓN 1</th>
        </tr>
        <tr class="text-center">
            <th class="label">Indicador</th>            
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
                {{ $data17_1 [1]['label']['numerador'] }}
            </td>             
            <td rowspan="2" class="align-middle text-center"> <span class="{{ ($data17_1[1]['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data17_1[1]['meta'])) ? 'text-success':'text-danger' }}">{{ number_format($data17_1[1]['cumplimiento'], 2, ',', '.') }}% </span></td>
            <td rowspan="2" class="align-middle text-center">{{ $data17_1[1]['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center"><a href="#" data-toggle="tooltip" title="{{$data17_1[1]['calculo']}}">{{ $data17_1[1]['resultado'] }}%</a></td>
            <td rowspan="2" class="align-middle text-center">{{ $data17_1[1]['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle text-center">{{$data17_1[1]['cumplimientoponderado']}}%</td>
        </tr>        
    </tbody>
</table>
<br>



<table class="table table-sm table-bordered small mb-4">
    <thead>
        <tr class="text-center">
            <th colspan="100%">ACCIÓN 2</th>
        </tr>
        <tr class="text-center">
            <th class="label">Indicador</th>           
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
                {{ $data17_1 [2]['label']['numerador'] }}
            </td>            
            <td rowspan="2" class="align-middle text-center"> <span class="{{ ($data17_1[2]['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data17_1[2]['meta'])) ? 'text-success':'text-danger' }}">{{ number_format($data17_1[2]['cumplimiento'], 2, ',', '.') }}% </span></td>
            <td rowspan="2" class="align-middle text-center">{{ $data17_1[2]['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center"><a href="#" data-toggle="tooltip" title="{{$data17_1[2]['calculo']}}">{{ $data17_1[2]['resultado'] }}%</a></td>
            <td rowspan="2" class="align-middle text-center">{{ $data17_1[2]['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle text-center">{{$data17_1[2]['cumplimientoponderado']}}%</td>
        </tr>       
    </tbody>
</table>
<br>

<table class="table table-sm table-bordered small mb-4">
    <thead>
        <tr class="text-center">
            <th colspan="100%">ACCIÓN 3</th>
        </tr>
        <tr class="text-center">
            <th class="label">Indicador</th>            
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
                {{ $data17_1 [3]['label']['numerador'] }}
            </td>            
            <td rowspan="2" class="align-middle text-center"> <span class="{{ ($data17_1[3]['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data17_1[3]['meta'])) ? 'text-success':'text-danger' }}">{{ number_format($data17_1[3]['cumplimiento'], 2, ',', '.') }}% </span></td>
            <td rowspan="2" class="align-middle text-center">{{ $data17_1[3]['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center"><a href="#" data-toggle="tooltip" title="{{$data17_1[3]['calculo']}}">{{ $data17_1[3]['resultado'] }}%</a></td>
            <td rowspan="2" class="align-middle text-center">{{ $data17_1[3]['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle text-center">{{$data17_1[3]['cumplimientoponderado']}}%</td>
        </tr>

        <tr class="text-center">            
        </tr>
    </tbody>
</table>
<br>