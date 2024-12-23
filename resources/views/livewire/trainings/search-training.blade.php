<div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm small">
            <thead>
                <tr class="text-center">
                    <th rowspan="2">ID</th>
                    <th rowspan="2">Estado</th>
                    <th rowspan="2">Fecha Creación</th>
                    <th rowspan="2">Funcionario</th>
                    <th rowspan="2">Nombre de la Actividad</th>
                    <th colspan="2">Fecha</th>
                    <th rowspan="2"></th>
                </tr>
                <tr class="text-center">
                    <th>Inicio</th>
                    <th>Termino</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trainings as $key => $training)
                <tr>
                    <th class="text-center" width="4%">{{ $training->id }}</th>
                    <td width="7%" class="text-center">
                        @switch($training->StatusValue)
                            @case('Guardado')
                                <span class="{{ ($bootstrap == 'v4') ? 'badge badge-primary' : 'badge text-bg-primary' }}">{{ $training->StatusValue }}</span>
                                @break
                            
                            @case('Enviado')
                                <span class="{{ ($bootstrap == 'v4') ? 'badge badge-warning' : 'badge text-bg-warning' }}">{{ $training->StatusValue }}</span>
                                @break

                            @case('Certificado Pendiente')
                                <span class="{{ ($bootstrap == 'v4') ? 'badge badge-warning' : 'badge text-bg-warning' }}">{{ $training->StatusValue }}</span>
                                @break

                            @case('Rechazado')
                                <span class="{{ ($bootstrap == 'v4') ? 'badge badge-danger' : 'badge text-bg-danger' }}">{{ $training->StatusValue }}</span>
                                @break
                            
                            @case('Finalizado')
                                <span class="{{ ($bootstrap == 'v4') ? 'badge badge-success' : 'badge text-bg-success' }}">{{ $training->StatusValue }}</span>
                                @break
                        @endswitch
                    </td>
                    <td width="7%">{{ $training->created_at->format('d-m-Y H:i:s') }}</td>
                    <td width="29%">
                        {{ $training->userTraining->fullName }} <br><br>
                        <small><b>{{ ($training->userTrainingOu) ? $training->userTrainingOu->name : 'Funcionario Externo'}}</b></small> <br>
                        <small><b>{{ ($training->userTrainingEstablishment) ? $training->userTrainingEstablishment->name : '' }}</b></small>
                    </td>
                    <td width="29%">
                        {{ $training->activity_name }}<br><br>
                        <small><b>Tipo de Actividad:</b> {{ $training->activity_type }}</b></small> <br>
                    </td>
                    <td class="text-center" width="7%">{{ $training->activity_date_start_at->format('d-m-Y') }}</td>
                    <td class="text-center" width="7%">{{ $training->activity_date_end_at->format('d-m-Y') }}</td>
                    <td width="12%" class="text-center">
                        @if($training->canEdit())
                            @if(auth()->guard('external')->check() == true )
                                <a href="{{ route('external_trainings.external_edit', $training) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit"></i> 
                                </a>
                            @else
                                @if($training->user_creator_id == auth()->id())
                                    <a href="{{ route('trainings.edit', $training) }}"
                                        class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-edit"></i> 
                                    </a>
                                @else
                                    <a href="{{ route('trainings.show', $training) }}"
                                        class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            @endif
                        @endif

                        @if($training->canShow())
                            @if(auth()->guard('external')->check() == true)
                                <a href="{{ route('external_trainings.external_show', $training) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @else
                                <a href="{{ route('trainings.show', $training) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif
                        @endif

                        @if($training->canViewCerticatePdf())
                            @if(auth()->guard('external')->check() == true)
                                <a href="{{ route('external_trainings.show_file', ['training' => $training, 'type' => 'certificate_file']) }}"
                                    target="_blank"
                                    class="btn btn-outline-success btn-sm"
                                    title="Certificado">
                                    <i class="fas fa-file-pdf fa-fw"></i>
                                </a>
                            @else
                                <a href="{{ route('trainings.show_file', ['training' => $training, 'type' => 'certificate_file']) }}"
                                    target="_blank"
                                    class="btn btn-outline-success btn-sm"
                                    data-bs-toggle="tooltip"
                                    title="Certificado">
                                    <i class="fas fa-file-pdf fa-fw"></i>
                                </a>
                            @endif
                        @endif

                        @if($training->canViewSummayPdf() && auth()->guard('external')->check() != true)
                            <a class="btn btn-outline-primary btn-sm"
                                target="_blank"
                                href="{{ route('trainings.show_summary_pdf', $training) }}"
                                data-bs-toggle="tooltip" 
                                title="Documento Resumen">
                                <i class="fas fa-file-pdf fa-fw"></i>
                            </a>
                        @endif

                        @if($training->canUploadCertificate() && (Route::is('trainings.own_index') || Route::is('external_trainings.external_own_index')))
                            <!-- Button trigger modal -->
                            @if(auth()->guard('external')->check())
                                <button type="button" 
                                    class="btn btn-outline-success btn-sm"
                                    data-toggle="modal" 
                                    data-target="#exampleModal">
                                    <i class="fas fa-file-upload fa-fw"></i>
                                </button>
                            
                                <!-- Modal -->
                                @include('trainings.modals.upload_certificate', [
                                        'external'  => 'yes',
                                        'training'  => $training 
                                    ]
                                )
                            @else
                                @if(auth()->user()->id == $training->user_training_id)
                                    <button type="button" 
                                        class="btn btn-outline-success btn-sm" 
                                        data-bs-toggle="modal"
                                        data-bs-toggle="tooltip"   
                                        data-bs-placement="top"
                                        title="Subir Certificado"
                                        data-bs-target="#exampleModal-{{ $training->id }}">
                                        <i class="fas fa-file-upload fa-fw"></i>
                                    </button>
                                @endif

                                <!-- Modal -->
                                @include('trainings.modals.upload_certificate', [
                                        'external' => 'no',
                                        'training'  => $training 
                                    ]
                                )
                            @endif  
                            
                            <span class="{{ ($bootstrap == 'v4') ? 'badge badge-warning' : 'badge text-bg-warning' }} mt-2">
                                Cargar Certificado Hasta <br>
                                {{ $training->addBusinessDays($training->activity_date_end_at, 20)->format('d-m-Y') }}
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
