@extends('layouts.document')

@section('title', 'DNC ' . $identifyNeed->id)

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
        
        .signature-container {
            height: 160px;
        }
        
    </style>

    <div style="float: right; width: 300px; padding-top: 66px;">

        <div class="left quince"
            style="padding-left: 2px; padding-bottom: 10px;">
            <strong style="text-transform: uppercase; padding-right: 30px;">
                Cuestionario DNC N°: {{ $identifyNeed->id }}
            </strong>
        </div>

        {{--
        <div style="padding-top:5px; padding-left: 2px;">
            Iquique, {{ $identifyNeed->created_at->format('d-m-Y H:i') }}
        </div>
        --}}
    </div>

    <div style="clear: both; padding-bottom: 35px"></div>

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
            <th style="background-color: #EEEEEE;" colspan="2">Asunto</th>
        </tr>
        <tr align="center">
            <td colspan="2">{{ $identifyNeed->subject }}</td>
        </tr>
        <tr>
            <th style="width: 50%; background-color: #EEEEEE;">Estamento</th>
            <th style="width: 50%; background-color: #EEEEEE;">Familia de Cargo</th>
        </tr>
        <tr align="center">
            <td>{{ $identifyNeed->estament->name }}</td>
            <td>{{ $identifyNeed->family_position_value }}</td>
        </tr>
    </table>

    <div style="clear: both; padding-bottom: 15px"></div>

    <table class="tabla">
        <tr>
            <th style="background-color: #EEEEEE;" colspan="2">Naturaleza de la Necesidad</th>
        </tr>
        <tr>
            <td style="width: 10%;" align="center">
                @if (in_array('necesidad propia', $identifyNeed->nature_of_the_need))
                    X
                @endif
            </td>
            <td style="width: 90%;" align="left">A una necesidad propia, relacionada con las funciones específicas que desempeño.</td>
        </tr>
        <tr>
            <td style="width: 10%;" align="center">
                @if (in_array('necesidad de mi equipo de trabajo', $identifyNeed->nature_of_the_need))
                    X
                @endif
            </td>
            <td style="width: 90%;" align="left">A una necesidad de mi equipo de trabajo, considerando el desarrollo de habilidades colectivas.</td>
        </tr>
        <tr>
            <td style="width: 10%;" align="center">
                @if (in_array('necesidad de otros equipos', $identifyNeed->nature_of_the_need))
                    X
                @endif
            </td>
            <td style="width: 90%;" align="left">A una necesidad de otros equipos, con los que me relaciono directamente en mi gestión u operatividad. (deberás responder las preguntas de la sección "otros equipos")</td>
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
                @if (in_array('18834', $identifyNeed->law))
                    X
                @endif
            </td>
            <th style="background-color: #EEEEEE;">Ley 19.664</th>
            <td style="width: 10%;">
                @if (in_array('19664', $identifyNeed->law))
                    X
                @endif
            </td>
            <th style="background-color: #EEEEEE;">Ley 15.076</th>
            <td style="width: 10%;">
                @if (in_array('15076', $identifyNeed->law))
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
            <td>{{ $identifyNeed->coffee_break_price }}</td>
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
            <td>{{ $identifyNeed->transport_price }}</td>
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
            <td>{{ $identifyNeed->accommodation_price }}</td>
        </tr>
    </table>

    <!-- Sección de las aprobaciones -->
    <div class="signature-container">
        <div class="signature" style="padding-left: 32px;">
            {{ $identifyNeed->user->initials }}
        </div>
        
        <div class="signature" style="padding-left: 6px; padding-right: 6px;">

        </div>
        <div class="signature">

        </div>
    </div>
@endsection
