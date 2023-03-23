<!-- Modal -->
<div class="modal fade" id="exampleModalCenter-req-{{ $requestReplacementStaff->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Gestión de Solicitudes para aprobación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                @if(!$pending_requests_to_sign->Where('id', $requestReplacementStaff->id)->isEmpty())
                @foreach($pending_requests_to_sign->Where('id', $requestReplacementStaff->id) as $requestReplacementStaff)
                    <h6><i class="fas fa-file"></i> Formulario de Reemplazos</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
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
                                        {{ $requestReplacementStaff->fundamentDetailManage->NameValue }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-active">Funcionario a Reemplazar
                                    </th>
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
                            </tbody>
                        </table>
                    </div>

                    <br />
                    
                @endforeach
                @endif

                @else
                    <h6><i class="fas fa-file"></i> Formulario de Convocatorias</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr class="table-active">
                                    <th colspan="4">
                                        Formulario Contratación de Personal - Solicitud Nº {{ $requestReplacementStaff->id }}
                                        @switch($requestReplacementStaff->request_status)
                                            @case('pending')
                                                <span class="badge bg-warning">{{ $requestReplacementStaff->StatusValue }}</span>
                                                @break

                                            @case('complete')
                                                <span class="badge bg-success">{{ $requestReplacementStaff->StatusValue }}</span>
                                                @break

                                            @case('rejected')
                                                <span class="badge bg-danger">{{ $requestReplacementStaff->StatusValue }}</span>
                                                @break

                                            @default
                                                Default case...
                                        @endswitch
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="table-active">Creador / Solicitante</th>
                                    <td style="width: 33%">
                                        {{ $requestReplacementStaff->user->FullName }} <br>
                                        {{ $requestReplacementStaff->organizationalUnit->name }}
                                    </td>
                                    <td style="width: 33%">
                                        {{($requestReplacementStaff->requesterUser) ?  $requestReplacementStaff->requesterUser->TinnyName : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-active">Nombre de Solicitud</th>
                                    <td colspan="2">{{ $requestReplacementStaff->name }}</td>
                                </tr>
                                <tr>
                                    <th class="table-active">Archivos</th>
                                    <td colspan="2">Correo (Verificación Solicitud) <a href="{{ route('replacement_staff.request.show_verification_file', $requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    </br>

                    <h6><i class="fas fa-list-ol"></i> Listado de cargos</h6>

                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>N° de cargos</th>
                                    <th>Estamento</th>
                                    <th>Grado / Renta</th>
                                    <th>Calidad Jurídica</th>
                                    <th>Fundamento</th>
                                    <th>Jornada</th>
                                    <th>Perfil de Cargo</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($requestReplacementStaff->positions as $position)
                                <tr>
                                    <td>{{ $position->charges_number }}</td>
                                    <td>{{ $position->profile_manage->name ?? '' }}</td>
                                    <td>{{ $position->degree ?? number_format($position->salary, 0, ",", ".") }}</td>
                                    <td>{{ $position->legalQualityManage->NameValue ?? '' }}</td>
                                    <td>{{ $position->fundamentManage->NameValue ?? '' }}<br>
                                        {{ $position->fundamentDetailManage->NameValue ?? '' }}</td>
                                    <td>{{ $position->WorkDayValue ?? '' }}</td>
                                    <td>
                                        <a class="btn btn-outline-secondary"
                                            href="{{ route('replacement_staff.request.show_file_position', $position) }}"
                                            target="_blank"> <i class="fas fa-paperclip"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                @endif

                <h6><i class="fas fa-signature"></i> El proceso debe contener las aprobaciones de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tbody>
                            <tr>
                                @foreach($requestReplacementStaff->RequestSign as $sign)
                                <td class="table-active text-center">
                                    <strong>{{ $sign->organizationalUnit->name }}</strong><br>
                                </td>
                                @endforeach
                                </tr>
                                <tr>
                                    @foreach($requestReplacementStaff->RequestSign as $requestSign)
                                        <td align="center">
                                            {{--@if($requestSign->request_status == 'pending' && $requestSign->organizational_unit_id == Auth::user()->organizationalUnit->id) --}}
                                            @if($requestSign->request_status == 'pending' && in_array($requestSign->organizational_unit_id, $iam_authorities_in))
                                                Estado: {{ $requestSign->StatusValue }} <br><br>
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.sign.update', [$requestSign, 'status' => 'accepted', $requestReplacementStaff]) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                onclick="return confirm('¿Está seguro que desea Aceptar la solicitud?')"
                                                                title="Aceptar">
                                                                <i class="fas fa-check-circle"></i></a>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col-sm">
                                                    <p>
                                                        <a class="btn btn-danger btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                            <i class="fas fa-times-circle"></i>
                                                        </a>
                                                    </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <div class="collapse" id="collapseExample">
                                                            <div class="card card-body">
                                                            <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.sign.update', [$requestSign, 'status' => 'rejected', $requestReplacementStaff]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label class="float-left" for="for_observation">Motivo Rechazo</label>
                                                                    <textarea class="form-control" id="for_observation" name="observation" rows="2"></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-danger btn-sm float-right"
                                                                    onclick="return confirm('¿Está seguro que desea Rechazar la solicitud?')"
                                                                    title="Rechazar">
                                                                    <i class="fas fa-times-circle"></i> Rechazar</a>
                                                                </button>
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($requestSign->request_status == 'accepted')
                                                <span style="color: green;">
                                                <i class="fas fa-check-circle"></i> {{ $requestSign->StatusValue }}
                                                </span> <br>
                                                <i class="fas fa-user"></i> {{ $requestSign->user->FullName }}<br>
                                                <i class="fas fa-calendar-alt"></i> {{ $requestSign->date_sign->format('d-m-Y H:i:s') }}<br>
                                            @else
                                                @if($requestSign->request_status == NULL)
                                                    <i class="fas fa-ban"></i> No disponible para Aprobación.<br>
                                                @else
                                                    <i class="fas fa-clock"></i> {{ $requestSign->StatusValue }}<br>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
