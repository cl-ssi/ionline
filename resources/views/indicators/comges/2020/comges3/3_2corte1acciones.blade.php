
<table class="table table-sm table-bordered small mb-4">
    <thead>
        <tr class="text-center">
            <th class="label">Acciones y/o metas específicas</th>
            <th nowrap>Medios de Verificación</th>
            <th>Ponderación por corte <br> % de la evaluación anual</th>
        </tr>
    </thead>
    <tbody>
@for ($i = 1; $i <= 3; $i++)
        <tr class="text-center">
            <td class="text-justify">
                <ol start="{{$i}}">
                    <li>{!! $data3_2[$i]['accion'] !!}</li>
                </ol>
            </td>
            <td class="text-justify">
                <ol type="i" start="{!! $data3_2[$i]['iverificacion'] !!}">
                    <li>{!! $data3_2[$i]['verificacion'] !!}</li>
                </ol>
            </td>
            @if ($i === 1)
            <td class="align-middle text-center" rowspan="0">
            {{ $data3_2['ponderacion']  }}<br>
            {{$data3_2[$i]['anual'] }}% de la evaluación anual
            </td>
            @endif
            
        </tr>
@endfor
    </tbody>
</table>
