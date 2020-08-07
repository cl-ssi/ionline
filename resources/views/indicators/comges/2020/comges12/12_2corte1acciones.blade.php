<table class="table table-sm table-bordered small mb-4">
    <thead>
        <tr class="text-center">
            <th class="label">Acciones y/o metas específicas</th>
            <th nowrap>Medios de Verificación</th>
            <th>Ponderación por corte <br> % de la evaluación anual</th>
        </tr>
    </thead>
    <tbody>
        <tr class="text-center">
            <td class="text-justify">
                <ol>
                    <li>{!! $data12_2[1]['accion'] !!}</li>
                </ol>
            </td>
            <td class="text-justify">
                <ol type="i" start="7">
                    <li>{!! $data12_2[1]['verificacion'] !!}</li>
                </ol>
            </td>
            <td class="align-middle text-center">
            {{ $data12_2['ponderacion']  }}<br>
            {{$data12_2[1]['anual'] }}% de la evaluación anual
            </td>
        </tr>
    </tbody>
</table>