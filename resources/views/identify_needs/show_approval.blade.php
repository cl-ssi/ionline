<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<h5><i class="bi bi-person-video"></i> Formulario de Necesidades De Capacitaciones</h5>
<h6>ID: {{ $identifyNeed->id }}<h6>

<h6 class="mt-3"><i class="fas fa-info-circle"></i> Usuario</h6>
<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active" width="33%">RUN</th>
                <th class="table-active" width="33%">Nombre Completo</th>
                <th class="table-active" width="33%">Correo Personal</th>
            </tr>
            <tr class="text-center">
                <td>{{ $identifyNeed->user->id }}-{{ $identifyNeed->user->dv }}</td>
                <td>{{ $identifyNeed->user->full_name  }}</td>
                <td>{{ $identifyNeed->user->email_personal }}</td>
            </tr>
            <tr class="text-center">
                <th class="table-active" width="33%">Correo Institucional</th>
                <th class="table-active" width="33%">Unidad Organizacional</th>
                <th class="table-active" width="33%">Cargo</th>
            </tr>
            <tr class="text-center">
                <td>{{ $identifyNeed->user->email }}</td>
                <td>{{ $identifyNeed->organizationalUnit->name  }}</td>
                <td>{{ $identifyNeed->user->position }}</td>
            </tr>
        </tbody>
    </table>
</div>

<h6><i class="fas fa-info-circle"></i> Formulario Detección Necesidades De Capacitación</h6>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active">Nombre de Actividad</th>
            </tr>
            <tr class="text-center">
                <td>{{ $identifyNeed->subject }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active" colspan="2">Naturaleza de la Necesidad</th>
            </tr>
            <tr class="text-center">
                <th class="table-active" width="50%">Red Asistencial</th>
                <th class="table-active" width="50%">Dirección Servicio de Salud</th>
            </tr>
            <tr class="text-center">
                <td>
                    @if($identifyNeed->nature_of_the_need === 'red asistencial')
                        X
                    @endif
                </td>
                <td>
                    @if($identifyNeed->nature_of_the_need  === 'dss')
                        X
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active">¿Cuál es el principal desafío o problema que enfrenta y que podría resolverse a través de una capacitación?</th>
            </tr>
            <tr>
                <td style="white-space: pre-line;">{{ $identifyNeed->question_1 }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active">¿Esta necesidad de capacitación afecta el cumplimiento de algún objetivo estratégico, meta o compromiso de gestión en su área o en la institución?</th>
            </tr>
            <tr>
                <td style="white-space: pre-line;">{{ $identifyNeed->question_2 }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active">¿Qué habilidades o conocimientos específicos considera que se necesita mejorar para un mejor desempeño?</th>
            </tr>
            <tr>
                <td style="white-space: pre-line;">{{ $identifyNeed->question_3 }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active">¿Cuál es el tema específico que debería abordar esta capacitación?</th>
            </tr>
            <tr>
                <td style="white-space: pre-line;">{{ $identifyNeed->question_4 }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active" colspan="2">Esta actividad esta dirigida para funcionarios o funcionarias de la Ley</th>
            </tr>
            <tr class="text-center">
                <th class="table-active" width="50%">Ley 18.834</th>
                <th class="table-active" width="50%">Ley 19.664</th>
            </tr>
            <tr class="text-center">
                <td>
                    @if ($identifyNeed->law == '18834')
                        X
                    @endif
                </td>
                <td>
                    @if ($identifyNeed->law == '19664')
                        X
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active">¿Qué objetivo se espera alcanzar con esta capacitación?</th>
            </tr>
            <tr>
                <td style="white-space: pre-line;">{{ $identifyNeed->question_5 }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active">¿Qué resultados inmediatos espera lograr después de esta capacitación?</th>
            </tr>
            <tr>
                <td style="white-space: pre-line;">{{ $identifyNeed->question_6 }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active" width="50%">¿Qué tipo de capacitación considera que seria mejor para abordar esta necesidad?</th>
                <th class="table-active" width="50%">Otro tipo de capacitación</th>
            </tr>
            <tr class="text-center">
                <td>{{ $identifyNeed->training_type_value }}</td>
                <td>{{ $identifyNeed->other_training_type }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active" width="50%">¿Con qué Objetivo Estratégico se relaciona esta Actividad?</th>
                <th class="table-active" width="50%">Objetivos de Impacto</th>
            </tr>
            <tr class="text-center">
                <td>{{ $identifyNeed->strategic_axis_value }}</td>
                <td>{{ $identifyNeed->impact_objective_value }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active">¿Qué modalidad prefiere?</th>
            </tr>
            <tr class="text-center">
                <td>{{ $identifyNeed->mechanism_value }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active" colspan="2">Modalidad Online</th>
            </tr>
            <tr class="text-center">
                <th class="table-active" width="50%">¿La actividad se encuentra dentro de la oferta?</th>
                <th class="table-active" width="50%">¿El curso podría ser una Capsula Digital?</th>
            </tr>
            <tr class="text-center">
                <td>{{ $identifyNeed->exists_value }}</td>
                <td>{{ $identifyNeed->digital_capsule_value }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active" width="50%">¿Esta Actividad considera Coffee Break?</th>
                <th class="table-active" width="50%">¿Cuanto es el Valor de Coffe Break?</th>
            </tr>
            <tr class="text-center">
                <td>{{ $identifyNeed->coffee_break_value }}</td>
                <td>${{ $identifyNeed->coffee_break_price ? number_format($identifyNeed->coffee_break_price, 0, ',', '.') : '' }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active" width="50%">¿La Actividad considera Traslado de los (las) Relatores (as)?</th>
                <th class="table-active" width="50%">¿Cuánto es el valor de traslado?</th>
            </tr>
            <tr class="text-center">
                <td>{{ $identifyNeed->transport ? 'Sí' : 'No' }}</td>
                <td>${{ $identifyNeed->transport_price ? number_format($identifyNeed->transport_price, 0, ',', '.') : '' }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active" width="50%">¿La Actividad considera alojamiento del o los (las) Relatores (as)?</th>
                <th class="table-active" width="50%">¿Cuánto es el valor de alojamiento?</th>
            </tr>
            <tr class="text-center">
                <td>{{ $identifyNeed->accommodation ? 'Sí' : 'No' }}</td>
                <td>${{ $identifyNeed->accommodation_price ? number_format($identifyNeed->accommodation_price, 0, ',', '.') : '' }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr class="text-center">
                <th class="table-active" width="50%">Valor de la Actividad (Excluye Coffee, Traslado y Alojamiento)</th>
                <th class="table-active" width="50%">Valor Total</th>
            </tr>
            <tr class="text-center">
                <td>${{ number_format($identifyNeed->activity_value, 0, ',', '.') }}</td>
                <td>${{ number_format($identifyNeed->total_value, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</div>