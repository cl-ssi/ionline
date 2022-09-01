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
                placeholder="Buscar por materia o descripción" name="search" readonly>

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

    <button class="btn btn-primary mb-2" id="massSign" onclick="getMassSignModalContent()" 
        disabled title="Seleccione solicitudes pendientes para firmar de forma masiva.">
        <i class="fas fa-file-signature"></i>Firmar
    </button>

    <div class="table-responsive">
        <table class="table table-striped table-sm table-bordered small">
            <thead>
                <tr>
                    <th scope="col">Sel.</th>
                    <th scope="col">Id</th>
                    <th scope="col">Fecha de Solicitud</th>
                    <th scope="col">Creador</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Materia de Resolución</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Firmar</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">
                        <div class="mx-4"></div>
                    </th>

                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingSignaturesFlows as $pendingSignaturesFlow)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="for_selected_flows"
                                name="selected_flows[]" value="{{$pendingSignaturesFlow->id}}">
                        </div>
                    </td>
                    <td>{{ $pendingSignaturesFlow->signature->id}}</td>
                    <td>{{ $pendingSignaturesFlow->signature->request_date->format('Y-m-d') }}</td>
                    <td>{{ $pendingSignaturesFlow->signature->responsable->getTinnyNameAttribute() }}
                        <p class="font-weight-light"><small><b>Firmante Asignado: </b> {{$pendingSignaturesFlow->signerName }}</small><br>
                        @if($pendingSignaturesFlow->userSigner->absent == 1)
                            <small><b>Firma Subrrogada por</b>: {{ Auth::user()->getTinnyNameAttribute() }}</small>
                        @endif
                        </p>
                    </td>
                    <td>{{ $pendingSignaturesFlow->type }}</td>
                    <td>{{ $pendingSignaturesFlow->signature->subject }}</td>
                    <td>{{ $pendingSignaturesFlow->signature->description }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary"
                            onclick="getSignModalContent({{$pendingSignaturesFlow->id}})" title="Firmar documento">
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
                            title="Ver circuito de firmas"><i class="fas fa-search"></i>
                        </button>
                    </td>
                    <td>
                        {{-- <a href="{{ route('documents.signatures.showPdf',--}}

        {{--                            [$pendingSignaturesFlow->signaturesFile->id, time()]--}}


        {{--                        ) }}" --}} {{-- class="btn btn-sm btn-outline-secondary" target="_blank"
                            title="Ver documento">--}}
                            {{-- <span class="fas fa-file" aria-hidden="true"></span>--}}
                            {{-- </a>--}}

                        <a href="https://storage.googleapis.com/{{env('APP_ENV') === 'production' ? 'saludiquique-storage' : 'saludiquique-dev'}}/{{ $pendingSignaturesFlow->signaturesFile->signed_file ?? $pendingSignaturesFlow->signaturesFile->file }}"
                            class="btn btn-sm btn-outline-secondary" target="_blank" title="Ver documento">
                            <span class="fas fa-file" aria-hidden="true"></span>
                        </a>

                    </td>
                    <td>
                        @foreach($pendingSignaturesFlow->signature->signaturesFiles->where('file_type', 'anexo') as $anexo)
                        <a href="{{route('documents.signatures.showPdfAnexo', $anexo)}}" target="_blank"><i
                                class="fas fa-paperclip" title="anexo"></i>&nbsp
                        </a>
                        @endforeach
                    </td>
                    <td>
                        @if($pendingSignaturesFlow->signature->url)
                            <a href="{{$pendingSignaturesFlow->signature->url}}" target="_blank"> <i class="fa fa-link"></i> </a>
                        @endif
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
                                enctype="multipart/form-data" id="rejectForm{{$pendingSignaturesFlow->id}}" >
                                <div class="modal-body">
                                    @csrf
                                    <!-- input hidden contra ataques CSRF -->
                                    @method('POST')
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="forobservacion">Observación</label>
                                            <input type="text" class="form-control form-control-sm" id="forobservacion"
                                                name="observacion" maxlength="255" autocomplete="off" form="rejectForm{{$pendingSignaturesFlow->id}}"
                                                required />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
                                    </button>

                                    <button form="rejectForm{{$pendingSignaturesFlow->id}}" class="btn btn-danger" type="submit">
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
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Fecha de Solicitud</th>
                    <th scope="col">Creador</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Materia de Resolución</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Estado Solicitud</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">
                        <div class="mx-4"></div>
                    </th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($signedSignaturesFlows as $signedSignaturesFlow)
                <tr>
                    <td>{{ $signedSignaturesFlow->signature->id ??'' }}</td>
                    <td>{{ $signedSignaturesFlow->signature?
                        Carbon\Carbon::parse($signedSignaturesFlow->signature->request_date)->format('Y-m-d'):'' }}</td>
                    <td>{{ $signedSignaturesFlow->signature?
                        $signedSignaturesFlow->signature->responsable->getTinnyNameAttribute():'' }}
                        <p class="font-weight-light"><small><b>Firmante Asignado: </b> {{$signedSignaturesFlow->signerName }}</small><br>
                        @if($signedSignaturesFlow->userSigner->absent == 1)
                            <small><b>Firma Subrrogada por</b>: {{ Auth::user()->getTinnyNameAttribute() }}</small>
                        @endif
                    </td>
                    <td>{{$signedSignaturesFlow->signature? $signedSignaturesFlow->type :''}}</td>
                    <td>{{ $signedSignaturesFlow->signature->subject??'' }}</td>
                    <td>{{ $signedSignaturesFlow->signature->description??'' }}</td>
                    <td>
                        @if($signedSignaturesFlow->status === 1)
                        <p class="text-success">Aceptada</p>
                        @elseif($signedSignaturesFlow->status === 0 or $signedSignaturesFlow->signature->rejected_at != null)
                        <p class="text-danger">Rechazada</p>
                        @else Pendiente @endif
                    </td>
                    <td>
                        @if($signedSignaturesFlow->signature)
                        <button id="btnFlowsModal" type="button" class="btn btn-sm btn-outline-primary"
                            onclick="getSignatureFlowsModal({{$signedSignaturesFlow->signature->id}})"
                            title="Ver circuito de firmas"><i class="fas fa-search"></i>
                        </button>
                        @endif
                    </td>
                    <td>
                        <!-- <a href="{{ route('documents.signatures.showPdf',
                                [$signedSignaturesFlow->signaturesFile->id, time()]
                                )
                                }}"
                                class="btn btn-sm btn-outline-secondary" target="_blank" title="Ver documento">
                                    <span class="fas fa-file" aria-hidden="true"></span>
                                </a> -->

                        <a href="https://storage.googleapis.com/{{env('APP_ENV') === 'production' ? 'saludiquique-storage' : 'saludiquique-dev'}}/{{$signedSignaturesFlow->signaturesFile->signed_file ?? $signedSignaturesFlow->signaturesFile->file}}"
                            class="btn btn-sm btn-outline-secondary" target="_blank" title="Ver documento">
                            <span class="fas fa-file" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td>@if($signedSignaturesFlow->signature)
                        @foreach($signedSignaturesFlow->signature->signaturesFiles->where('file_type', 'anexo') as $anexo)

                        <a href="{{route('documents.signatures.showPdfAnexo', $anexo)}}" target="_blank"><i
                                class="fas fa-paperclip" title="anexo"></i>&nbsp
                        </a>
                        @endforeach
                        @endif
                    </td>
                    <td>
                        @if($signedSignaturesFlow->signature && $signedSignaturesFlow->signature->url)
                            <a href="{{$signedSignaturesFlow->signature->url}}" target="_blank"> <i class="fa fa-link"></i> </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $signedSignaturesFlows->links() }}

@endif

@if($tab == 'mis_documentos')
    <h4>Mis Solicitudes</h4>
    <div class="table-responsive">
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
                        @else Pendiente</p> @endif
                    </td>
                    <td>

                        <a href="https://storage.googleapis.com/{{env('APP_ENV') === 'production' ? 'saludiquique-storage' : 'saludiquique-dev'}}/{{$signature->signaturesFileDocument->signed_file ?? $signature->signaturesFileDocument->file}}"
                            class="btn btn-sm btn-outline-secondary" target="_blank" title="Ver documento">
                            <span class="fas fa-file" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td>
                        <button id="btnFlowsModal" type="button" class="btn btn-sm btn-outline-primary"
                            onclick="getSignatureFlowsModal({{$signature->id}})" title="Ver circuito de firmas"><i
                                class="fas fa-search"></i>
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('documents.signatures.edit', $signature) }}" class="btn btn-sm btn-outline-secondary"
                            title="Editar solicitud">
                            <span class="fas fa-edit" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-outline-danger" title="Eliminar solicitud" @if($signature->responsable_id !=
                            Auth::id()) disabled @endif
                            data-toggle="modal"
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
                                action="{{route('documents.signatures.destroy', $signature)}}" enctype="multipart/form-data">
                                @csrf
                                <!-- input hidden contra ataques CSRF -->
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
    </div>

    {{ $mySignatures->links() }}
@endif

{{--**************************** El pop up up up del
OTP**************************************************************--}}
<div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div id="signModalContent">
            </div>
        </div>

    </div>
</div>

{{--Modal flujo de firmas--}}
<div class="modal fade" id="flowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
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
        function getSignModalContent(idPendingSignaturesFlow) {
            axios.get('/documents/signatures/signModal/' + idPendingSignaturesFlow, {responseType: 'html'})
                .then(function (response) {
                    const contentdiv = document.getElementById("signModalContent");
                    console.log(response.data);
                    contentdiv.innerHTML = response.data;
                })
                .then(function () {
                    $("#signModal").modal();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        }
        function getMassSignModalContent() {
            idPendingSignaturesFlows = []
            $("input:checkbox[id=for_selected_flows]:checked").each(function(){
                idPendingSignaturesFlows.push($(this).val());
            });

            console.log(idPendingSignaturesFlows);

            axios.get('/documents/signatures/massSignModal/' + idPendingSignaturesFlows, {responseType: 'html'})
                .then(function (response) {
                    const contentdiv = document.getElementById("signModalContent");
                    console.log(response.data);
                    contentdiv.innerHTML = response.data;
                })
                .then(function () {
                    $("#signModal").modal();
                })
                .catch(function (error) {
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
        jQuery(function(){
            var max = 10;
            var checkboxes = $('input[type="checkbox"]');
            checkboxes.change(function(){
                var current = checkboxes.filter(':checked').length;
                checkboxes.filter(':not(:checked)').prop('disabled', current >= max);

                if(current == 0){
                    document.getElementById('massSign').disabled = true;
                }else {
                    document.getElementById('massSign').disabled = false;
                }

            });
        });


</script>
@endsection