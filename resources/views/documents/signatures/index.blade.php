@extends('layouts.app')

@section('title', 'Firmas y distribución')

@section('content')

    <h3 class="mb-3">Solicitudes de firmas y distribución</h3>

    <form class="form d-print-none" method="GET" action="">
        <fieldset class="form-group">
            <div class="input-group">

                <div class="input-group-prepend">
                    <a class="btn btn-primary" href="{{ route('documents.signatures.create') }}">
                        <i class="fas fa-plus"></i> Nueva solicitud</a>
                </div>

                <input type="text" class="form-control" id="forsearch" onkeyup="filter(3)"
                       placeholder="Buscar por materia o descripción"
                       name="search" readonly>

                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search" aria-hidden="true"></i></button>
                </div>
            </div>
        </fieldset>
    </form>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{($tab == 'pendientes') ? 'active' : ''}} "
               href=" {{route('documents.signatures.index', ['pendientes'])}} ">
                Pendientes por firmar
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{($tab == 'mis_documentos') ? 'active' : ''}}"
               href="{{route('documents.signatures.index', ['mis_documentos'])}}">
                Mis solicitudes creadas
            </a>
        </li>
    </ul>

    @if($tab == 'pendientes')
        <h4>Pendientes por firmar</h4>

        <table class="table table-striped table-sm table-bordered">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Fecha de Solicitud</th>
                <th scope="col">Responsable</th>
                <th scope="col">Tipo</th>
                <th scope="col">Materia de Resolución</th>
                <th scope="col">Descripción</th>
                <th scope="col">Firmar</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            {{--            @foreach($pendingSignatures as $signature)--}}
            @foreach($pendingSignaturesFlows as $pendingSignaturesFlow)
                <tr>
                    <td>{{ $pendingSignaturesFlow->signature->id}}</td>
                    <td>{{ $pendingSignaturesFlow->signature->request_date->format('Y-m-d') }}</td>
                    <td>{{ $pendingSignaturesFlow->signature->responsable->getFullNameAttribute() }}</td>
                    <td>{{ $pendingSignaturesFlow->type }}</td>
                    <td>{{ $pendingSignaturesFlow->signature->subject }}</td>
                    <td>{{ $pendingSignaturesFlow->signature->description }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                data-target="#exampleModalCenter{{$pendingSignaturesFlow->id}}"
                                title="Firmar documento">
                            <i class="fas fa-file-signature"></i>
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                data-target="#rejectSignature{{$pendingSignaturesFlow->id}}" title="Rechazar documento">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </td>
                    <td>
                        <button id="btnFlowsModal" type="button" class="btn btn-sm btn-outline-primary"
                                onclick="getSignatureFlowsModal({{$pendingSignaturesFlow->signature->id}})"
                                title="Ver circuito de firmas"
                        ><i class="fas fa-search"></i>
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('documents.signatures.showPdf', $pendingSignaturesFlow->signaturesFile->id) }}"
                           class="btn btn-sm btn-outline-secondary" target="_blank" title="Ver documento">
                            <span class="fas fa-file" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
                {{--Modal rechazo--}}
                <div class="modal fade" id="rejectSignature{{$pendingSignaturesFlow->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Rechazar Firma</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" class="form-horizontal"
                                  action="{{route('documents.signatures.rejectSignature', $pendingSignaturesFlow->id)}}"
                                  enctype="multipart/form-data">
                                <div class="modal-body">
                                @csrf <!-- input hidden contra ataques CSRF -->
                                    @method('POST')
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="forobservacion">Observación</label>
                                            <input type="text" class="form-control form-control-sm" id="forobservacion"
                                                   name="observacion" maxlength="255" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
                                    </button>

                                    <button class="btn btn-danger" type="submit">
                                        <i class="fas fa-edit"></i> Rechazar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{--**************************** El pop up up up del OTP**************************************************************--}}
                <div class="modal fade" id="exampleModalCenter{{$pendingSignaturesFlow->id}}" tabindex="-1"
                     role="dialog"
                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Nro. OTP</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" class="form-horizontal"
                                  action="{{route('signPdfFlow', $pendingSignaturesFlow->id)}}"
                                  enctype="multipart/form-data">
                                <div class="modal-body">
                                @csrf <!-- input hidden contra ataques CSRF -->
                                    @method('POST')
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="forotp">Ingrese número OTP.</label>
                                            <input type="text" class="form-control form-control-sm" id="forotp"
                                                   name="otp" maxlength="6" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
                                    </button>

                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-edit"></i> Firmar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            </tbody>
        </table>

        <h4>Firmados</h4>

        <table class="table table-striped table-sm table-bordered">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Fecha de Solicitud</th>
                <th scope="col">Responsable</th>
                <th scope="col">Tipo</th>
                <th scope="col">Materia de Resolución</th>
                <th scope="col">Descripción</th>
                <th scope="col">Estado Solicitud</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($signedSignaturesFlows as $signedSignaturesFlow)
                <tr>
                    <td>{{ $signedSignaturesFlow->signature->id }}</td>
                    <td>{{ Carbon\Carbon::parse($signedSignaturesFlow->signature->request_date)->format('Y-m-d') }}</td>
                    <td>{{ $signedSignaturesFlow->signature->responsable->getFullNameAttribute() }}</td>
                    <td>{{$signedSignaturesFlow->type}}</td>
                    <td>{{ $signedSignaturesFlow->signature->subject }}</td>
                    <td>{{ $signedSignaturesFlow->signature->description }}</td>
                    <td>
                        @if($signedSignaturesFlow->status === 1)
                            <p class="text-success">Aceptada</p>
                        @elseif($signedSignaturesFlow->status === 0)
                            <p class="text-danger">Rechazada</p>
                        @else Pendiente @endif
                    </td>
                    <td>
                        <button id="btnFlowsModal" type="button" class="btn btn-sm btn-outline-primary"
                                onclick="getSignatureFlowsModal({{$signedSignaturesFlow->signature->id}})"
                                title="Ver circuito de firmas"
                        ><i class="fas fa-search"></i>
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('documents.signatures.showPdf', $signedSignaturesFlow->signaturesFile->id) }}"
                           class="btn btn-sm btn-outline-secondary" target="_blank" title="Ver documento">
                            <span class="fas fa-file" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif

    @if($tab == 'mis_documentos')
        <h4>Mis Solicitudes</h4>
        <table class="table table-striped table-sm table-bordered">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Materia de Resolución</th>
                <th scope="col">Descripción</th>
                <th scope="col">Fecha de Solicitud</th>
                <th scope="col">Estado Solicitud</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($mySignatures as $signature)
                <tr>
                    <td>{{ $signature->id }}</td>
                    <td>{{ $signature->subject }}</td>
                    <td>{{ $signature->description }}</td>
                    <td>{{ Carbon\Carbon::parse($signature->request_date)->format('Y-m-d') }}</td>
                    <td>
                        @if($signature->signaturesFlows->count() === $signature->signaturesFlows->where('status', 1)->count())
                            <p class="text-success">Aceptada</p>
                        @elseif($signature->signaturesFlows->where('status', '===' , 0)->count() > 0)
                            <p class="text-danger">Rechazo</p>
                        @else Pendiente</p>  @endif
                    </td>
                    <td>
                        <button id="btnFlowsModal" type="button" class="btn btn-sm btn-outline-primary"
                                onclick="getSignatureFlowsModal({{$signature->id}})" title="Ver circuito de firmas"
                        ><i class="fas fa-search"></i>
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('documents.signatures.edit', $signature) }}"
                           class="btn btn-sm btn-outline-secondary" title="Editar solicitud">
                            <span class="fas fa-edit" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td>
                        <a  class="btn btn-sm btn-outline-danger" title="Eliminar solicitud"
                            @if($signature->responsable_id != Auth::id()) disabled @endif
                            data-toggle = "modal"
                            data-target="#deleteSignature{{$signature->id}}">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                {{--Modal eliminar--}}
                <div class="modal fade" id="deleteSignature{{$signature->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">¿Desea eliminar la solicitud?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" class="form-horizontal"
                                  action="{{route('documents.signatures.destroy', $signature)}}"
                                  enctype="multipart/form-data">
                                @csrf <!-- input hidden contra ataques CSRF -->
                                    @method('DELETE')

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
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
    @endif

    {{--Modal flujo de firmas--}}
    <div class="modal fade" id="flowModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Flujo Firmas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        function getSignatureFlowsModal(idSignature) {
            axios.get('/documents/signatures/signatureFlows/' + idSignature, {responseType: 'html'})
                .then(function (response) {
                    const contentdiv = document.getElementById("flowsModalBody");
                    contentdiv.innerHTML = response.data;
                })
                .then(function () {
                    $("#flowModal").modal();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        }
    </script>
@endsection
