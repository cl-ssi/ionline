@extends('layouts.document')
@section('title', 'Informe de Calificación Nº: ' . $report->id)
@section('linea1', $report->createdOrganizationalUnit->name)
@section('linea3', 'id: ' . $report->id . ' - ' . $report->createdUser->initials)

@section('content')

    <style>
        .tabla th,
        .tabla td {
            padding: 3px;
            /* Ajusta este valor a tus necesidades */
        }

        .totales {
            margin-left: auto;
            margin-right: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .nowrap {
            white-space: nowrap;
        }
        .nota {
        font-size: 8px;
        text-decoration: underline;
    }
    </style>
    <div style="float: right; width: 300px; padding-top: 66px;">
    
        <div class="left quince"
                style="padding-left: 2px; padding-bottom: 10px;">
                <strong style="text-transform: uppercase; padding-right: 30px;">
                    Número:
                </strong>
                <span class="catorce negrita">{{ $report->id }}</span>                
        </div>

    </div>

    <div style="clear: both; padding-bottom: 35px"></div>

    <div class="center diez">
        <strong style="text-transform: uppercase;">
                INFORME DE DESEMPEÑO
        </strong>
    </div>
    <br><br><br>

    <table class="tabla">
        <tr>
            <th>
                PERIODO
            </th>
            <td class="nowrap" style="text-transform: uppercase;">
                {{ $report->period?->name }}  ({{ $report->period?->start_at->format('d-m-Y') }} - {{ $report->period?->end_at->format('d-m-Y') }} )
            </td>
        </tr>
        <tr>
            <th>
                NOMBRE FUNCIONARIO
            </th>
            <td style="text-transform: uppercase;">
                {{ $report->receivedUser?->full_name_upper }}
            </td>
        </tr>
        <tr>
            <th>
                UNIDAD DESEMPEÑO
            </th>
            <td class="nowrap" style="text-transform: uppercase;">
                {{ $report->receivedOrganizationalUnit?->name }}
            </td>
        </tr>
        <tr>
            <th>
                NOMBRE JEFE DIRECTO
            </th>
            <td class="nowrap" style="text-transform: uppercase;">
                {{ $report->createdUser?->full_name_upper }}
            </td>
        </tr>
    </table>
    <br><br><br><br>

    <table class="tabla">
        <thead>
            <tr>
                <th>1</th>
                <th>FACTOR RENDIMIENTO</th>
                <th>Considerar los subfactores, cantidad de trabajo y calidad de la labor realizada.</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3">Subfactor Cantidad de Trabajo:{{ $report->cantidad_de_trabajo }} </td>
            </tr>
            <tr>
                <td colspan="3">Subfactor Calidad de la labor realizada: {{ $report->calidad_del_trabajo }}</td>
            </tr>
        </tbody>


    </table>
    <br><br><br><br>
    
    <table class="tabla">
        <thead>
            <tr>
                <th>2</th>
                <th>FACTOR CONDICIONES PERSONALES</th>
                <th>Considerar los subfactores, conocimiento del trabajo, interés por el trabajo que realiza, y capacidad para realizar trabajos en grupo. </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3">Subfactor conocimiento del trabajo: {{ $report->conocimiento_del_trabajo }} </td>
            </tr>
            <tr>
                <td colspan="3">Subfactor interés por el trabajo que realiza: {{ $report->interes_por_el_trabajo }}</td>
            </tr>
            <tr>
                <td colspan="3">Subfactor capacidad para realizar trabajos en grupo: {{ $report->capacidad_trabajo_en_grupo }}</td>
            </tr>
        </tbody>
    </table>
    <br><br><br><br>

    <table class="tabla">
        <thead>
            <tr>
                <th>3</th>
                <th>FACTOR COMPORTAMIENTO FUNCIONARIO</th>
                <th>Considerar los subfactores asistencia y puntualidad, y cumplimiento de normas e instrucciones.</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3">Subfactor asistencia y puntualidad: {{ $report->asistencia }} {{ $report->puntualidad }}  </td>
            </tr>
            <tr>
                <td colspan="3">Subfactor cumplimiento de normas e instrucciones: {{ $report->cumplimiento_normas_e_instrucciones }}</td>
            </tr>
        </tbody>
    </table>

    <br><br><br><br>
    <table class="tabla">
        <thead>
            <tr>
                <th colspan="3">Observaciones <small>(opcional)</small></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="3">Observación Usuario Creador: {{ $report->creator_user_observation }}</td>
            </tr>
            <tr>
                <td colspan="3">Observación Funcionario Receptor: {{ $report->received_user_observation }}</td>
            </tr>
        </tbody>
    </table>

    
    
    

    <!-- Sección de las aprobaciones -->
    <div class="signature-container">
        <span class="nota">NOTA: El Informe de desempeño deberá considerar en cada subfactor los conceptos dispuestos en el Art. 13 del Decreto N°1229 Reglamento de Calificaciones, a saber sobresaliente o excelente, muy bueno, bueno,  más que regular, regular, deficiente, malo, considerando la fundamentación respectiva notificada al funcionario en el presente informe de desempeño.</span>
        <br>

        <div class="signature" style="padding-left: 32px;">
            @if($approval = $report->approvals->where('position', 'left')->first())
                @include('sign.calificaciones', [
                    'approval' => $approval,
                    'observacion' => $report->received_user_observation
                ])
            @endif
        </div>
        <div class="signature" style="padding-left: 6px; padding-right: 6px;">
            @if($approval = $report->approvals->where('position', 'center')->first())
                @include('sign.calificaciones', [
                    'approval' => $approval,
                    'observacion' => $report->received_user_observation
                ])
            @endif
        </div>
        <div class="signature">
            @if($approval = $report->approvals->where('position', 'right')->first())
                @include('sign.calificaciones', [
                    'approval' => $approval,
                    'observacion' => $report->received_user_observation,
                ])
            @endif
        </div>
    </div>
    

@endsection