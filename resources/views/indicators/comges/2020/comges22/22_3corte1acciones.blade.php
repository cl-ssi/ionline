<table class="table table-sm table-bordered small mb-4">
    <thead>
        <tr class="text-center">
            <th nowrap class="label">Acciones y/o metas específicas</th>
            <th nowrap>Medios de Verificación <a target="_blank" href="http://isalud.minsal.cl/ministerio/dgstic/SIDRA_2/_layouts/15/Authenticate.aspx?Source=%2Fministerio%2Fdgstic%2FSIDRA%5F2%2FPaginas%2Fdefault%2Easpx">Link</a> </th>
            <th>Ponderación por corte <br> % de la evaluación anual</th>
        </tr>
    </thead>
    <tbody>
        <tr class="text-center">
            <td class="text-justify">
                <ol>
                    <li>{{ $data22_3[1]['accion'] }}</li>
                </ol>
            </td>
            <td class="text-justify">
                <ol type="i" start="5">
                    <li>{!! $data22_3[1]['verificacion'] !!}</li>
                </ol>
            </td>
            <td class="align-middle text-center">
            {{ $data22_3['ponderacion'] }}% <br>
            {{$data22_3[1]['anual'] }}% de la evaluación anual
            </td>
        </tr>
    </tbody>
</table>