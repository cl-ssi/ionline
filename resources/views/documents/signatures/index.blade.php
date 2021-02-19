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
                <th scope="col">U.Organizacional</th>
                <th scope="col">Responsable</th>
                <th scope="col">Estado Solicitud</th>
                <th scope="col">Ultimo Usuario</th>
                <th scope="col">Materia de Resolución</th>
                <th scope="col">Firmar</th>
                <th scope="col">Doc</th>
            </tr>
            </thead>
            <tbody>
            {{--            @foreach($pendingSignatures as $signature)--}}
            @foreach($pendingSignaturesFlows as $pendingSignaturesFlow)
                <tr>
                    <td>{{ $pendingSignaturesFlow->signature->id}}</td>
                    <td>{{ $pendingSignaturesFlow->signature->request_date->format('Y-m-d') }}</td>
                    <td>{{ $pendingSignaturesFlow->signature->organizationalUnit->name }}</td>
                    <td>{{ $pendingSignaturesFlow->signature->responsable->getFullNameAttribute() }}</td>
                    <td>
                        @if($pendingSignaturesFlow->status === 1)
                            Aceptada
                        @elseif($pendingSignaturesFlow->status === 0)
                            Rechazada
                        @else Pendiente @endif
                    </td>
                    <td>{{ $pendingSignaturesFlow->employee }}</td>
                    <td>{{ $pendingSignaturesFlow->signature->subject }}</td>
                    <td>
                        <a href="{{ route('signPdf', $pendingSignaturesFlow->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            <span class="fas fa-edit" aria-hidden="true"></span>
                        </a>


                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                data-target="#exampleModalCenter">
                            <i class="fas fa-edit"></i>
                        </button>

                    </td>

                    <td>
                        <a href="{{ route('documents.showPdfDocumento', $pendingSignaturesFlow->id) }}"
                           class="btn btn-sm btn-outline-secondary">
                            <span class="fas fa-file" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach

            @if($pendingSignaturesFlows->count() > 0)
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
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
                                  action="{{route('signPdf', $pendingSignaturesFlow->signaturesFile->id)}}"
                                  enctype="multipart/form-data">
                                <div class="modal-body">
                                @csrf <!-- input hidden contra ataques CSRF -->
                                    @method('POST')
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="forotp">Ingrese número OTP.</label>
                                            <input type="text" class="form-control form-control-sm" id="forotp"
                                                   name="otp"
                                                   maxlength="6" required/>
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
            @endif
            </tbody>
        </table>

        <h4>Firmados</h4>

        <table class="table table-striped table-sm table-bordered">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Fecha de Solicitud</th>
                <th scope="col">U.Organizacional</th>
                <th scope="col">Responsable</th>
                <th scope="col">Estado Solicitud</th>
                <th scope="col">Ultimo Usuario</th>
                <th scope="col">Materia de Resolución</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($signedSignatures as $signature)
                <tr>
                    <td>{{ $signature->id }}</td>
                    <td>{{ Carbon\Carbon::parse($signature->request_date)->format('Y-m-d') }}</td>
                    <td>{{ $signature->organizationalUnit->name }}</td>
                    <td>{{ $signature->responsable->getFullNameAttribute() }}</td>
                    <td>
                        @if($signature->signaturesFiles->first()->signaturesFlows->whereNotNull('user_id')->first()->status === 1)
                            Aceptada
                        @elseif($signature->signaturesFiles->first()->signaturesFlows->whereNotNull('user_id')->first()->status === 0)
                            Rechazada
                        @else Pendiente @endif
                    </td>
                    <td>{{$signature->signaturesFiles->first()->signaturesFlows->whereNotNull('user_id')->first()->employee}}</td>
                    <td>{{ $signature->subject }}</td>
                    <td>
                        <a href="{{ route('documents.showPdfDocumento', $signature) }}"
                           class="btn btn-sm btn-outline-secondary">
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
                <th scope="col">Fecha de Solicitud</th>
                <th scope="col">U.Organizacional</th>
                <th scope="col">Estado Solicitud</th>
                <th scope="col">Ultimo Usuario</th>
                <th scope="col">Materia de Resolución</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($mySignatures as $signature)
                <tr>
                    <td>{{ $signature->id }}</td>
                    <td>{{ Carbon\Carbon::parse($signature->request_date)->format('Y-m-d') }}</td>
                    <td>{{ $signature->organizationalUnit->name }}</td>
                    <td>
                        @if($signature->signaturesFiles->first()->signaturesFlows->whereNotNull('user_id')->first()->status === 1)
                            Aceptada
                        @elseif($signature->signaturesFiles->first()->signaturesFlows->whereNotNull('user_id')->first()->status === 0)
                            Rechazada
                        @else Pendiente @endif
                    </td>
                    <td>{{$signature->signaturesFiles->first()->signaturesFlows->whereNotNull('user_id')->first()->employee}}</td>
                    <td>{{ $signature->subject }}</td>
                    <td>
                        <a href="{{ route('documents.signatures.edit', $signature) }}"
                           class="btn btn-sm btn-outline-secondary">
                            <span class="fas fa-edit" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

@endsection

@section('custom_js')

@endsection
