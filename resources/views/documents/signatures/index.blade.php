@extends('layouts.bt5.app')

@section('title', 'Firmas y distribución')

@section('content')

    <style>
        .circle-icon {
            width: 28px; /* Ancho fijo */
            height: 28px; /* Altura fija */
        }
    </style>


    <h3 class="mb-3">Solicitudes de firmas y distribución</h3>

    @if ($tab == 'pendientes')
        <form class="form d-print-none" method="GET" action="{{ route('documents.signatures.index', ['pendientes']) }}">
    @endif
    @if ($tab == 'mis_documentos')
        <form class="form d-print-none" method="GET" action="{{ route('documents.signatures.index', ['mis_documentos']) }}">
    @endif
    <div class="input-group mb-3">

        <a class="btn btn-primary" href="{{ route('documents.signatures.create') }}">
            <i class="fas fa-plus"></i> Nueva solicitud</a>

        <input type="text" class="form-control" id="forsearch" onkeyup="filter(3)"
            placeholder="Buscar por materia o descripción o Id" autocomplete="off" name="search"
            value="{{ app('request')->input('search') }}">

        <button class="btn btn-outline-secondary" type="submit">
            <i class="fas fa-search" aria-hidden="true"></i></button>
    </div>
    </form>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $tab == 'pendientes' ? 'active' : '' }} "
                href=" {{ route('documents.signatures.index', ['pendientes']) }} ">
                Pendientes por firmar
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab == 'mis_documentos' ? 'active' : '' }}"
                href="{{ route('documents.signatures.index', ['mis_documentos']) }}">
                Mis solicitudes creadas
            </a>
        </li>
    </ul>

    @if ($tab == 'pendientes')

        <h4>Pendientes por firmar</h4>

        <button class="btn btn-primary mb-2" id="massSign" onclick="getMassSignModalContent()" disabled
            data-bs-toggle="modal"
            title="Seleccione solicitudes pendientes para firmar de forma masiva.">
            <i class="fas fa-file-signature"></i>Firmar
        </button>

        <div class="table-responsive">
            <table class="table table-striped table-sm table-bordered small">
                <thead class="text-center">
                    <tr>
                        <th scope="col">Sel.</th>
                        <th scope="col">Id <i class="fas fa-signature"></i></th>
                        <th scope="col" width="8%">Fecha de Solicitud</th>
                        <th scope="col">Firmante</th>
                        <th scope="col">Materia</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Creador</th>
                        <th scope="col">Firmar</th>
                        <th scope="col">Rech.</th>
                        <th scope="col" width="10%" style="word-wrap: break-word; white-space: normal;">Firmas</th>
                        <th scope="col">Ver</th>
                        <th scope="col">Anexos
                            <div class="mx-4"></div>
                        </th>

                        <th scope="col">Link</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingSignaturesFlows as $pendingSignaturesFlow)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="for_selected_flows"
                                        name="selected_flows[]" value="{{ $pendingSignaturesFlow->id }}">
                                </div>
                            </td>
                            <td>{{ $pendingSignaturesFlow->signature->id }}</td>
                            {{-- <td>{{ $pendingSignaturesFlow->signature->request_date->format('Y-m-d') }}</td> --}}
                            <td>{{ $pendingSignaturesFlow->signature->created_at->format('Y-m-d') }}</td>
                            <td>
                                <b>{{ $pendingSignaturesFlow->signerName }}</b><br>
                                {{ $pendingSignaturesFlow->type }}
                                @if ($pendingSignaturesFlow->userSigner->absent == 1)
                                    @if ($pendingSignaturesFlow->userSigner->subrogant)
                                        <br>
                                        <b>Firma Subrrogada por</b>:<br>
                                        {{ $pendingSignaturesFlow->userSigner->subrogant->tinyName }}
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($pendingSignaturesFlow->signature->reserved)
                                    <i class="fas fa-user-secret"></i>
                                @endif
                                {{ $pendingSignaturesFlow->signature->subject }}
                            </td>
                            <td>{!! $pendingSignaturesFlow->signature->description !!}</td>
                            <td>{{ $pendingSignaturesFlow->signature->responsable->tinyName }}</td>
                            <td>
                                @can('Documents: signatures and distribution')
                                    <button type="button" class="btn btn-sm btn-outline-primary" @disabled(auth()->user()->godMode)
                                        onclick="getSignModalContent({{ $pendingSignaturesFlow->id }})"
                                        title="Firmar documento">
                                        <i class="fas fa-fw fa-file-signature"></i>
                                    </button>
                                @endcan
                            </td>
                            <td>
                                @can('Documents: signatures and distribution')
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                        @disabled(auth()->user()->godMode)
                                        data-bs-target="#rejectSignature{{ $pendingSignaturesFlow->id }}"
                                        title="Rechazar documento">
                                        <i class="fas fa-fw fa-times-circle"></i>
                                    </button>
                                @endcan
                            </td>
                            <td class="text-center" nowrap>
                                {{--
                        <button id="btnFlowsModal" type="button" class="btn btn-sm btn-outline-primary"
                            onclick="getSignatureFlowsModal({{$pendingSignaturesFlow->signature->id}})"
                            title="Ver circuito de firmas"><i class="fas fa-fw fa-search"></i>
                        </button>
                        --}}
                                @foreach ($pendingSignaturesFlow->signature->signaturesFlows as $key => $signatureFlow)
                                    @if ($signatureFlow->status == '1' && $signatureFlow->real_signer_id === null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-success text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="{{ $signatureFlow->type == 'firmante' ? 'Firmado ' : 'Visado ' }}
                                            por {{ $signatureFlow->signerName }}
                                            el {{ $signatureFlow->signature_date->format('d-m-Y H:i:s') }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif
                                    @if ($signatureFlow->status == '1' && $signatureFlow->real_signer_id != null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-success text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="Firmante Asignado: {{ $signatureFlow->signerName }}
                                        Firma Subrogada por: {{ $signatureFlow->realSignerName }}
                                        Fecha: {{ $signatureFlow->signature_date->format('d-m-Y H:i:s') }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif

                                    @if ($signatureFlow->status === 0 && $signatureFlow->real_signer_id === null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-danger text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="{{ $signatureFlow->created_at }} - Rechazado por {{ $signatureFlow->signerName }} - Motivo: {{ $signatureFlow->observation }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif

                                    @if ($signatureFlow->status === 0 && $signatureFlow->real_signer_id != null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-danger text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="Firmante Asignado: {{ $signatureFlow->signerName }} - Rechazado por Subrogante: {{ $signatureFlow->realSignerName }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif

                                    @if ($signatureFlow->status === null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip" data-placement="top"
                                            title="Pendiente {{ $signatureFlow->type == 'firmante' ? 'firma ' : 'visación ' }} de {{ $signatureFlow->signerName }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('documents.signatures.showPdf', [$pendingSignaturesFlow->signaturesFile->id, time()]) }}"
                                    class="btn btn-sm btn-outline-secondary" target="_blank" title="Ver documento">
                                    <span class="fas fa-fw fa-file" aria-hidden="true"></span>
                                </a>

                                {{--                        <a href="https://storage.googleapis.com/{{env('app_env') === 'production' ? 'saludiquique-storage' : 'saludiquique-dev'}}/{{ $pendingsignaturesflow->signaturesfile->signed_file ?? $pendingsignaturesflow->signaturesfile->file }}" --}}
                                {{--                           class="btn btn-sm btn-outline-secondary" target="_blank" title="ver documento"> --}}
                                {{--                            <span class="fas fa-file" aria-hidden="true"></span> --}}
                                {{--                        </a> --}}

                            </td>
                            <td>
                                @foreach ($pendingSignaturesFlow->signature->signaturesFiles->where('file_type', 'anexo') as $anexo)
                                    <a href="{{ route('documents.signatures.showPdfAnexo', $anexo) }}" target="_blank"><i
                                            class="fas fa-paperclip" title="anexo"></i>
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @if ($pendingSignaturesFlow->signature->url)
                                    <a href="{{ $pendingSignaturesFlow->signature->url }}" target="_blank"> <i
                                            class="fa fa-link"></i> </a>
                                @endif
                            </td>
                        </tr>
                        {{-- Modal rechazo --}}
                        <div class="modal fade" id="rejectSignature{{ $pendingSignaturesFlow->id }}" tabindex="-1"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Rechazar Firma</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" class="form-horizontal"
                                        action="{{ route('documents.signatures.rejectSignature', $pendingSignaturesFlow->id) }}"
                                        enctype="multipart/form-data" id="rejectForm{{ $pendingSignaturesFlow->id }}">
                                        <div class="modal-body">
                                            @csrf
                                            <!-- input hidden contra ataques CSRF -->
                                            @method('POST')
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="forobservacion">Observación</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="forobservacion" name="observacion" maxlength="255"
                                                        autocomplete="off"
                                                        form="rejectForm{{ $pendingSignaturesFlow->id }}" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar
                                            </button>

                                            <button form="rejectForm{{ $pendingSignaturesFlow->id }}"
                                                class="btn btn-danger" type="submit">
                                                <i class="fas fa-edit"></i> Rechazar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br />

        <h4>Firmados/Rechazados</h4>

        <div class="table-responsive">
            <table class="table table-striped table-sm table-bordered small">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Id</th>
                        <th scope="col" width="8%">Fecha de Solicitud</th>
                        <th scope="col">Firmante</th>
                        <th scope="col">Materia de Resolución</th>
                        <th scope="col font-monospace">Descripción</th>
                        <th scope="col">Creador</th>
                        <th scope="col">Estado Solicitud</th>
                        <th scope="col" width="10%" style="word-wrap: break-word; white-space: normal;">Firmas</th>
                        <th scope="col">Ver</th>
                        <th scope="col">Anexos
                            <div class="mx-4"></div>
                        </th>

                        <th scope="col">Link</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($signedSignaturesFlows as $signedSignaturesFlow)
                        <tr>
                            <td>{{ $signedSignaturesFlow->signature->id ?? '' }}</td>
                            <td>{{ $signedSignaturesFlow->signature->created_at->format('Y-m-d') }}</td>
                            <td>
                                <b>{{ $signedSignaturesFlow->userSigner->tinyName }}</b>
                                <br>
                                {{ $signedSignaturesFlow->signature ? $signedSignaturesFlow->type : '' }}
                            </td>
                            <td>{{ $signedSignaturesFlow->signature->subject ?? '' }}</td>
                            <td>{!! $signedSignaturesFlow->signature->description ?? '' !!}</td>
                            <td>
                                @if ($signedSignaturesFlow->signature)
                                    {{ $signedSignaturesFlow->signature->responsable->tinyName }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($signedSignaturesFlow->status === 1)
                                    <p class="text-success">Aceptada</p>
                                @elseif($signedSignaturesFlow->status === 0 or $signedSignaturesFlow->signature->rejected_at != null)
                                    <p class="text-danger">Rechazada</p>
                                    <span class="small text-danger">{{ $signedSignaturesFlow->observation }}</span>
                                @else
                                    Pendiente
                                @endif
                            </td>
                            <td class="text-center" nowrap>
                                {{--
                        @if ($signedSignaturesFlow->signature)
                        <button id="btnFlowsModal" type="button" class="btn btn-sm btn-outline-primary"
                            onclick="getSignatureFlowsModal({{$signedSignaturesFlow->signature->id}})"
                            title="Ver circuito de firmas"><i class="fas fa-fw fa-search"></i>
                        </button>
                        @endif
                        --}}

                                @foreach ($signedSignaturesFlow->signature->signaturesFlows as $key => $signatureFlow)
                                    @if ($signatureFlow->status == '1' && $signatureFlow->real_signer_id === null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-success text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="{{ $signatureFlow->type == 'firmante' ? 'Firmado ' : 'Visado ' }}
                                            por {{ $signatureFlow->signerName }}
                                            el {{ $signatureFlow->signature_date->format('d-m-Y H:i:s') }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif

                                    @if ($signatureFlow->status == '1' && $signatureFlow->real_signer_id != null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-success text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="Firmante Asignado: {{ $signatureFlow->signerName }}
                                        Firma Subrogada por: {{ $signatureFlow->realSignerName }}
                                        Fecha: {{ $signatureFlow->signature_date->format('d-m-Y H:i:s') }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif

                                    @if ($signatureFlow->status === 0 && $signatureFlow->real_signer_id === null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-danger text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="{{ $signatureFlow->created_at }} - Rechazado por {{ $signatureFlow->signerName }} - Motivo: {{ $signatureFlow->observation }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif

                                    @if ($signatureFlow->status === 0 && $signatureFlow->real_signer_id != null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-danger text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="Firmante Asignado: {{ $signatureFlow->signerName }} - Rechazado por Subrogante: {{ $signatureFlow->realSignerName }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif

                                    @if ($signatureFlow->status === null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="Pendiente {{ $signatureFlow->type == 'firmante' ? 'firma ' : 'visación ' }} de {{ $signatureFlow->signerName }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('documents.signatures.showPdf', [$signedSignaturesFlow->signaturesFile->id, time()]) }}"
                                    class="btn btn-sm btn-outline-secondary" target="_blank" title="Ver documento">
                                    <span class="fas fa-fw fa-file" aria-hidden="true"></span>
                                </a>
                            </td>
                            <td>
                                @if ($signedSignaturesFlow->signature)
                                    @foreach ($signedSignaturesFlow->signature->signaturesFiles->where('file_type', 'anexo') as $anexo)
                                        <a href="{{ route('documents.signatures.showPdfAnexo', $anexo) }}"
                                            class="link-primary" target="_blank">
                                            <i class="fas fa-paperclip" title="anexo"></i>
                                        </a>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if ($signedSignaturesFlow->signature && $signedSignaturesFlow->signature->url)
                                    <a href="{{ $signedSignaturesFlow->signature->url }}" target="_blank"> <i
                                            class="fa fa-link"></i> </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $signedSignaturesFlows->links() }}

    @endif

    @if ($tab == 'mis_documentos')
        <h4>Mis Solicitudes</h4>
        <div class="table-responsive">
            <table class="table table-striped table-sm table-bordered small">
                <thead class="text-center">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col" width="8%">Fecha de Solicitud</th>
                        <th scope="col">Materia de Resolución</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Estado Solicitud</th>
                        <th scope="col">Doc</th>
                        <th scope="col">Firmas</th>
                        <th scope="col" colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mySignatures as $signature)
                        <tr>
                            <td>{{ $signature->id }}</td>
                            {{-- <td>{{ $signature->request_date->format('Y-m-d') }}</td> --}}
                            <td>{{ $signature->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if ($signature->reserved)
                                    <i class="fas fa-user-secret"></i>
                                @endif
                                {{ $signature->subject }}
                            </td>
                            <td>{{ $signature->description }}</td>
                            <td class="text-center">
                                @if ($signature->signaturesFlows->count() === $signature->signaturesFlows->where('status', 1)->count())
                                    <p class="text-success">Aceptada</p>

                                    @livewire('documents.signature.distribute', ['signature' => $signature])
                                @elseif($signature->signaturesFlows->where('status', '===', 0)->count() > 0)
                                    <p class="text-danger">Rechazo</p>
                                @else
                                    Pendiente</p>

                                    <a
                                        href="{{ route('documents.signatures.notificationPending', ['id' => $signature->id]) }}"><i
                                            class="fas fa-bell"></i><small> Volver a Notificar</small></a>
                                @endif
                            </td>
                            <td>

                                <a href="{{ route('documents.signatures.showPdf', [$signature->signaturesFileDocument->id, time()]) }}"
                                    class="btn btn-sm btn-outline-secondary" target="_blank" title="Ver documento">
                                    <span class="fas fa-fw fa-file" aria-hidden="true"></span>
                                </a>

                                {{--                        <a href="https://storage.googleapis.com/{{env('APP_ENV') === 'production' ? 'saludiquique-storage' : 'saludiquique-dev'}}/{{$signature->signaturesFileDocument->signed_file ?? $signature->signaturesFileDocument->file}}" --}}
                                {{--                            class="btn btn-sm btn-outline-secondary" target="_blank" title="Ver documento"> --}}
                                {{--                            <span class="fas fa-fw fa-file" aria-hidden="true"></span> --}}
                                {{--                        </a> --}}
                            </td>
                            <td class="text-center" nowrap>
                                <!-- <button id="btnFlowsModal" type="button" class="btn btn-sm btn-outline-primary"
                                onclick="getSignatureFlowsModal({{ $signature->id }})" title="Ver circuito de firmas"><i
                                    class="fas fa-fw fa-search"></i>
                            </button> -->

                                @foreach ($signature->SignaturesFlows as $key => $signatureFlow)
                                    @if ($signatureFlow->status == '1' && $signatureFlow->real_signer_id === null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-success text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="{{ $signatureFlow->type == 'firmante' ? 'Firmado ' : 'Visado ' }}
                                            por {{ $signatureFlow->signerName }}
                                            el {{ $signatureFlow->signature_date->format('d-m-Y H:i:s') }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif
                                    @if ($signatureFlow->status == '1' && $signatureFlow->real_signer_id != null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-success text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="Firmante Asignado: {{ $signatureFlow->signerName }}
                                        Firma Subrogada por: {{ $signatureFlow->realSignerName }}
                                        Fecha: {{ $signatureFlow->signature_date->format('d-m-Y H:i:s') }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif

                                    @if ($signatureFlow->status === 0 && $signatureFlow->real_signer_id === null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-danger text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="{{ $signatureFlow->created_at }} - Rechazado por {{ $signatureFlow->signerName }} - Motivo: {{ $signatureFlow->observation }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif

                                    @if ($signatureFlow->status === 0 && $signatureFlow->real_signer_id != null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark bg-danger text-white rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="Firmante Asignado: {{ $signatureFlow->signerName }} - Rechazado por Subrogante: {{ $signatureFlow->realSignerName }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif

                                    @if ($signatureFlow->status === null)
                                        <span
                                            class="circle-icon d-inline-block img-thumbnail border-dark rounded-circle font-monospace"
                                            tabindex="0" data-toggle="tooltip"
                                            title="Pendiente {{ $signatureFlow->type == 'firmante' ? 'firma ' : 'visación ' }} de {{ $signatureFlow->signerName }}">
                                            {{ substr($signatureFlow->userSigner->initials, 0, 2) }}
                                        </span>
                                    @endif
                                @endforeach
                            </td>
                            <td class="text-center">
                                <a href="{{ route('documents.signatures.edit', $signature) }}"
                                    class="btn btn-sm btn-outline-secondary" title="Editar solicitud">
                                    <span class="fas fa-fw fa-edit" aria-hidden="true"></span>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-outline-danger" title="Eliminar solicitud"
                                    @if ($signature->responsable_id != Auth::id()) disabled @endif data-toggle="modal"
                                    data-target="#deleteSignature{{ $signature->id }}">
                                    <i class="fas fa-fw fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        {{-- Modal eliminar --}}
                        <div class="modal fade" id="deleteSignature{{ $signature->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">¿Desea eliminar la solicitud?
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" class="form-horizontal"
                                        action="{{ route('documents.signatures.destroy', $signature) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <!-- input hidden contra ataques CSRF -->
                                        @method('DELETE')

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancelar
                                            </button>

                                            <button class="btn btn-danger" type="submit">
                                                <i class="fas fa-edit"></i> Eliminar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $mySignatures->links() }}
    @endif

    {{-- ************************* El pop up up up del OTP ************************************** --}}
    <div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div id="signModalContent">
                </div>
            </div>

        </div>
    </div>

    {{-- Modal flujo de firmas --}}
    <div class="modal fade" id="flowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Flujo Firmas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div id="flowsModalBody">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.0.0/axios.min.js"
        integrity="sha512-26uCxGyoPL1nESYXHQ+KUmm3Maml7MEQNWU8hIt1hJaZa5KQAQ5ehBqK6eydcCOh6YAuZjV3augxu/5tY4fsgQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function getSignatureFlowsModal(idSignature) {
            axios.get('/documents/signatures/signatureFlows/' + idSignature, {
                    responseType: 'document'
                })
                .then(function(response) {
                    const contentdiv = document.getElementById("flowsModalBody");
                    contentdiv.innerHTML = response.data.documentElement.innerHTML;
                })
                .then(function() {
                    const flowModal = new bootstrap.Modal(document.getElementById('flowModal'));
                    flowModal.show();
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        function getSignModalContent(idPendingSignaturesFlow) {
            axios.get('/documents/signatures/signModal/' + idPendingSignaturesFlow, {
                    responseType: 'document'
                })
                .then(function(response) {
                    const contentdiv = document.getElementById("signModalContent");
                    // console.log(response.data);
                    contentdiv.innerHTML = response.data.documentElement.innerHTML;
                })
                .then(function() {
                    const signModal = new bootstrap.Modal(document.getElementById('signModal'));
                    signModal.show();
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        function getMassSignModalContent() {
            const idPendingSignaturesFlows = [];
            $("input:checkbox[id=for_selected_flows]:checked").each(function() {
                idPendingSignaturesFlows.push($(this).val());
            });

            console.log(idPendingSignaturesFlows);

            axios.get('/documents/signatures/massSignModal/' + idPendingSignaturesFlows, {
                    responseType: 'document'
                })
                .then(function(response) {
                    const contentdiv = document.getElementById("signModalContent");
                    contentdiv.innerHTML = response.data.documentElement.innerHTML;
                })
                .then(function() {
                    const massSignModal = new bootstrap.Modal(document.getElementById('signModal'));
                    massSignModal.show();
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                });
        }

        function disableButton(form) {
            form.signBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Firmando...';
            form.signBtn.disabled = true;
            form.cancelSignBtn.disabled = true;
            return true;
        }

        //Seleccionar maximo 10 muestras. Habilita botones derivar recepcionar massivos
        jQuery(function() {
            var max = 10;
            var checkboxes = $('input[type="checkbox"]');
            checkboxes.change(function() {
                var current = checkboxes.filter(':checked').length;
                checkboxes.filter(':not(:checked)').prop('disabled', current >= max);

                if (current == 0) {
                    document.getElementById('massSign').disabled = true;
                } else {
                    document.getElementById('massSign').disabled = false;
                }

            });
        });
    </script>
@endsection
