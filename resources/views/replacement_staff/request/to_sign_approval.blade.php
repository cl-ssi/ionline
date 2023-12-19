<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<div class="row">
    <div class="col">
        <h4 class="mb-3">Gestión de Solicitudes para aprobación
    </div>
</div>

@if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
    @if($requestReplacementStaff->requestFather)
        <div class="row">
            <div class="col">
                <div class="alert alert-primary" role="alert">
                    Este formulario corresponde a una extensión del formulario Nº {{ $requestReplacementStaff->requestFather->id }} - {{ $requestReplacementStaff->requestFather->name }}
                </div>
            </div>
        </div>
        <br>
    @endif
@endif

@if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
    <h6><i class="fas fa-file"></i> Formulario de Reemplazos</h6>
    <div class="table-responsive">
        <table class="table table-sm table-bordered small">
            <thead>
                <tr class="table-active">
                    <th colspan="4">Formulario Contratación de Personal - Solicitud Nº {{ $requestReplacementStaff->id }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="table-active">Solicitante</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->user->FullName }}</td>
                    <td style="width: 33%">{{ $requestReplacementStaff->organizationalUnit->name }}</td>
                </tr>
                <tr>
                    <th class="table-active">Nombre de Formulario / Nº de Cargos</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->name }}</td>
                    <td style="width: 33%">{{ $requestReplacementStaff->charges_number }}</td>
                </tr>
                <tr>
                    <th class="table-active">Estamento / Grado</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->profile_manage->name }}</td>
                    <td style="width: 33%">{{ $requestReplacementStaff->degree }}</td>
                </tr>
                <tr>
                    <th class="table-active">Periodo</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->start_date->format('d-m-Y') }}</td>
                    <td style="width: 33%">{{ $requestReplacementStaff->end_date->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th class="table-active">Calidad Jurídica / $ Honorarios</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->legalQualityManage->NameValue }}</td>
                    <td style="width: 33%">
                        @if($requestReplacementStaff->LegalQualityValue == 'Honorarios')
                            ${{ number_format($requestReplacementStaff->salary,0,",",".") }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="table-active">
                        Fundamento de la Contratación / Detalle de Fundamento
                    </th>
                    <td style="width: 33%">
                        {{ $requestReplacementStaff->fundamentManage->NameValue }}
                    </td>
                    <td style="width: 33%">
                        {{ ($requestReplacementStaff->fundamentDetailManage) ? $requestReplacementStaff->fundamentDetailManage->NameValue : '' }}
                    </td>
                </tr>
                <tr>
                    <th class="table-active">Funcionario a Reemplazar</th>
                    <td style="width: 33%">
                        @if($requestReplacementStaff->run)
                            {{$requestReplacementStaff->run}}-{{$requestReplacementStaff->dv}}
                        @endif
                    </td>
                    <td style="width: 33%">{{$requestReplacementStaff->name_to_replace}}</td>
                </tr>
                <tr>
                    <th class="table-active">Otro Fundamento (especifique)</th>
                    <td colspan="2">{{ $requestReplacementStaff->other_fundament }}</td>
                </tr>
                <tr>
                    <th class="table-active">La Persona cumplirá labores en Jornada</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->WorkDayValue }}</td>
                    <td style="width: 33%">{{ $requestReplacementStaff->other_work_day }}</td>
                </tr>
                <tr>
                    <th class="table-active">Archivos</th>
                    <td style="width: 33%">Perfil de Cargo
                        @if($requestReplacementStaff->job_profile_file)
                            <a href="{{ route('replacement_staff.request.show_file', $requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a>
                        @endif
                    </td>
                    <td style="width: 33%">Correo (Verificación Solicitud) <a href="{{ route('replacement_staff.request.show_verification_file', $requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a></td>
                </tr>
                <tr>
                    <th class="table-active">Lugar de Desempeño</th>
                    <td colspan="2">{{ $requestReplacementStaff->ouPerformance->name }}</td>
                </tr>
                <tr>
                    <th class="table-active">Staff Sugerido</th>
                    <td colspan="2">
                        @if($requestReplacementStaff->replacementStaff)
                            {{ $requestReplacementStaff->replacementStaff->FullName }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="table-active">Ítem Presupuestario</th>
                    <td colspan="2">
                        @if($requestReplacementStaff->budgetItem)
                            {{ $requestReplacementStaff->budgetItem->code }} <br>
                            {{ $requestReplacementStaff->budgetItem->name }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <br />
@endif