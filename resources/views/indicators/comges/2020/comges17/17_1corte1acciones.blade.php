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
                    <li>{!! $data17_1[1]['accion'] !!}</li>
                </ol>
            </td>
            <td class="text-justify">
                <ol type="i" start="16">
                    <li>{!! $data17_1[1]['verificacion'] !!}</li>
                </ol>
            </td>
            <td class="align-middle text-center" rowspan="4">
            {{ $data17_1['ponderacion']  }}<br>
            {{$data17_1[1]['anual'] }}% de la evaluación anual
            </td>
        </tr>
        <tr class="text-center">
            <td class="text-justify" >
                <ol start="2">
                    <li>{!! $data17_1[2]['accion'] !!}</li>
                </ol>
            </td>
            <td class="text-justify">   
            <ol type="i" start="1">  
                    <li>{!! $data17_1[2]['verificacion'] !!}</li>
                    </ol>
            </td>            
        </tr>
        <tr class="text-center">
            <td class="text-center" >
                <ol start="3">
                    <li>{!! $data17_1[3]['accion'] !!}</li>
                </ol>
            </td>
            <td class="text-justify">
                <ol start="1">
                    <li>{!! $data17_1[3]['verificacion'] !!}</li>
                    </ol>
            </td>            
        </tr>        
    </tbody>
</table>