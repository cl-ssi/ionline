<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" data-mutate-approach="sync"></script> -->

<h5><i class="bi bi-person-video"></i> Formulario de Necesidades De Capacitaciones</h5>
<h6>ID: {{ $identifyNeed->id }}<h6>

<div class="left"><b>I. Usuario</b></div>

<div style="clear: both; padding-bottom: 5px"></div>

<table class="tabla">
    <tr>
        <th style="width: 33%; background-color: #EEEEEE;">RUN</th>
        <th style="width: 33%; background-color: #EEEEEE;">Nombre Completo</th>
        <th style="width: 33%; background-color: #EEEEEE;">Correo Personal</th>
    </tr>
    <tr align="center">
        <td>{{ $identifyNeed->user->id }}-{{ $identifyNeed->user->dv }}</td>
        <td>{{ $identifyNeed->user->full_name  }}</td>
        <td>{{ $identifyNeed->user->email_personal }}</td>
    </tr>

    <tr>
        <th style="width: 33%; background-color: #EEEEEE;">Correo Institucional</th>
        <th style="width: 33%; background-color: #EEEEEE;">Unidad Organizacional</th>
        <th style="width: 33%; background-color: #EEEEEE;">Cargo</th>
    </tr>
    <tr align="center">
        <td>{{ $identifyNeed->user->email }}</td>
        <td>{{ $identifyNeed->organizationalUnit->name  }}</td>
        <td>{{ $identifyNeed->user->position }}</td>
    </tr>
</table>

{{--
<div style="clear: both; padding-bottom: 15px"></div>

<div class="left"><b>II. Jefatura</b></div>

<div style="clear: both; padding-bottom: 5px"></div>

<table class="tabla">
    <tr>
        <th style="width: 50%; background-color: #EEEEEE;">Nombre Jefatura</th>
        <th style="width: 50%; background-color: #EEEEEE;">Correo</th>
    </tr>
    <tr align="center">
        <td>{{ $user->boss ? $user->boss->full_name : '' }}</td>
        <td>{{ $user->boss ? $user->boss->email : '' }}</td>
    </tr>
</table>
--}}

<div style="clear: both; padding-bottom: 15px"></div>

<div class="left"><b>III.Formulario Detección Necesidades De Capacitación</b></div>

<div style="clear: both; padding-bottom: 5px"></div>

<table class="tabla">
    <tr>
        <th style="background-color: #EEEEEE;" colspan="2">Nombre de Actividad</th>
    </tr>
    <tr align="center">
        <td colspan="2">{{ $identifyNeed->subject }}</td>
    </tr>
    {{--
    <tr>
        <th style="width: 50%; background-color: #EEEEEE;">Estamento</th>
        <th style="width: 50%; background-color: #EEEEEE;">Familia de Cargo</th>
    </tr>
    <tr align="center">
        <td>{{ $identifyNeed->estament->name }}</td>
        <td>{{ $identifyNeed->family_position_value }}</td>
    </tr>
    --}}
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="background-color: #EEEEEE;" colspan="4">Naturaleza de la Necesidad</th>
    </tr>
    <tr>
        <td style="background-color: #EEEEEE;">Red Asistencial</td>
        <td style="width: 10%;" align="center">
            @if($identifyNeed->nature_of_the_need === 'red asistencial')
                X
            @endif
        </td>
        <td style="background-color: #EEEEEE;">Dirección Servicio de Salud</td>
        <td style="width: 10%;" align="center">
            @if($identifyNeed->nature_of_the_need  === 'dss')
                X
            @endif
        </td>
        
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="background-color: #EEEEEE;" colspan="2">¿Cuál es el principal desafío o problema que enfrenta y que podría resolverse a través de una capacitación?</th>
    </tr>
    <tr align="center">
        <td colspan="2">{{ $identifyNeed->question_1 }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="background-color: #EEEEEE;" colspan="2">¿Esta necesidad de capacitación afecta el cumplimiento de algún objetivo estratégico, meta o compromiso de gestión en su área o en la institución?</th>
    </tr>
    <tr align="center">
        <td colspan="2">{{ $identifyNeed->question_2 }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="background-color: #EEEEEE;" colspan="2">¿Qué habilidades o conocimientos específicos considera que se necesita mejorar para un mejor desempeño?</th>
    </tr>
    <tr align="center">
        <td colspan="2">{{ $identifyNeed->question_3 }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="background-color: #EEEEEE;" colspan="2">¿Cuál es el tema específico que debería abordar esta capacitación?</th>
    </tr>
    <tr align="center">
        <td colspan="2">{{ $identifyNeed->question_4 }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="background-color: #EEEEEE;" colspan="6">Esta actividad esta dirigida para funcionarios o funcionarias de la Ley</th>
    </tr>
    <tr align="center">
        <th style="background-color: #EEEEEE;">Ley 18.834</th>
        <td style="width: 10%;">
            @if ($identifyNeed->law == '18834')
                X
            @endif
        </td>
        <th style="background-color: #EEEEEE;">Ley 19.664</th>
        <td style="width: 10%;">
            @if ($identifyNeed->law == '19664')
                X
            @endif
        </td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="background-color: #EEEEEE;" colspan="2">¿Qué objetivo se espera alcanzar con esta capacitación?</th>
    </tr>
    <tr align="center">
        <td colspan="2">{{ $identifyNeed->question_5 }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="background-color: #EEEEEE;" colspan="2">¿Qué resultados inmediatos espera lograr después de esta capacitación?</th>
    </tr>
    <tr align="center">
        <td colspan="2">{{ $identifyNeed->question_6 }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="width: 50%; background-color: #EEEEEE;">¿Qué tipo de capacitación considera que seria mejor para abordar esta necesidad?</th>
        <th style="width: 50%; background-color: #EEEEEE;">Otro tipo de capacitación</th>
    </tr>
    <tr align="center">
        <td>{{ $identifyNeed->training_type_value }}</td>
        <td>{{ $identifyNeed->other_training_type }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="background-color: #EEEEEE;" colspan="2">¿Con qué Objetivo Estratégico se relaciona esta Actividad?</th>
    </tr>
    <tr align="center">
        <td colspan="2">{{ $identifyNeed->strategic_axis_value }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="background-color: #EEEEEE;" colspan="2">Objetivos de Impacto</th>
    </tr>
    <tr align="center">
        <td colspan="2">{{ $identifyNeed->impact_objective_value }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="width: 50%; background-color: #EEEEEE;">¿Qué modalidad prefiere?</th>
        <th style="width: 50%; background-color: #EEEEEE;">¿Cuantas cupos considera esta actividad?</th>
    </tr>
    <tr align="center">
        <td>{{ $identifyNeed->mechanism_value }}</td>
        <td>{{ $identifyNeed->places }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="width: 50%; background-color: #EEEEEE;">Modalidad Online</th>
        <th style="width: 50%;"></th>
    </tr>
    <tr align="center">
        <td>{{ $identifyNeed->online_type_mechanism_value }}</td>
        <td></td>
    </tr>
    <tr>
        <th style="width: 50%; background-color: #EEEEEE;">¿La actividad se encuentra dentro de la oferta?</th>
        <th style="width: 50%; background-color: #EEEEEE;">¿El curso podría ser una Capsula Digital?</th>
    </tr>
    <tr align="center">
        <td>{{ $identifyNeed->exists_value }}</td>
        <td>{{ $identifyNeed->digital_capsule_value }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="width: 50%; background-color: #EEEEEE;">¿Esta Actividad considera Coffee Break?</th>
        <th style="width: 50%; background-color: #EEEEEE;">¿Cuanto es el Valor de Coffe Break?</th>
    </tr>
    <tr align="center">
        <td>{{ $identifyNeed->coffee_break_value }}</td>
        <td>${{ $identifyNeed->coffee_break_price ? number_format($identifyNeed->coffee_break_price, 0, ',', '.') : '' }}</td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="width: 50%; background-color: #EEEEEE;">¿La Actividad considera Traslado de los (las) Relatores (as)?</th>
        <th style="width: 50%; background-color: #EEEEEE;">¿Cuánto es el valor de traslado?</th>
    </tr>
    <tr align="center">
        <td>{{ $identifyNeed->transport ? 'Sí' : 'No' }}</td>
        <td>${{ $identifyNeed->transport_price ? number_format($identifyNeed->transport_price, 0, ',', '.') : ''}}
        </td>
    </tr>
</table>

<div style="clear: both; padding-bottom: 15px"></div>

<table class="tabla">
    <tr>
        <th style="width: 50%; background-color: #EEEEEE;">¿La Actividad considera alojamiento del o los (las) Relatores (as)?</th>
        <th style="width: 50%; background-color: #EEEEEE;">¿Cuánto es el valor de alojamiento?</th>
    </tr>
    <tr align="center">
        <td>{{ $identifyNeed->accommodation ? 'Sí' : 'No' }}</td>
        <td>${{ $identifyNeed->accommodation_price ? number_format($identifyNeed->accommodation_price, 0, ',', '.') : ''}}</td>
    </tr>
</table>

<table class="tabla">
    <tr>
        <th style="width: 50%; background-color: #EEEEEE;">Valor de la Actividad (Excluye Coffee, Traslado y Alojamiento)</th>
        <th style="width: 50%; background-color: #EEEEEE;">Valor Total</th>
    </tr>
    <tr align="center">
        <td>${{ number_format($identifyNeed->activity_value, 0, ',', '.') }}</td>
        <td>${{ number_format($identifyNeed->total_value, 0, ',', '.') }}</td>
    </tr>
</table>