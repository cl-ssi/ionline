<div>
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
    @endif

    @if($serviceRequest->working_day_type == "DIURNO PASADO A TURNO")
        <h4>Inasistencias</h4>
        @livewire('service-request.fulfillment-absences', ['fulfillment' => $serviceRequest->Fulfillments->first()])
    @endif

    @livewire('service-request.show-total-hours', ['fulfillment' => $serviceRequest->fulfillments->first()])
    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <a type="button" class="btn btn-outline-primary" href="{{ route('rrhh.service-request.fulfillment.certificate-pdf',$serviceRequest->Fulfillments->first()) }}" target="_blank"> Ver certificado <i class="fas fa-file"></i> </a>

            @if($serviceRequest->Fulfillments->first()->signatures_file_id)
                <a class="btn btn-info" href="{{ route('rrhh.service-request.fulfillment.signed-certificate-pdf',[$serviceRequest->Fulfillments->first(), time()]) }}" target="_blank" title="Certificado">
                    Certificado firmado<i class="fas fa-signature"></i>
                </a>
                @can('Service Request: delete signed certificate')
                    <a class="btn btn-outline-danger" wire:click="deleteSignedCertificate({{ $serviceRequest->Fulfillments->first() }})" title="Borrar Aprobación Responsable" onclick="return confirm('¿Está seguro que desea eliminar el certificado de cumplimiento firmado?') || event.stopImmediatePropagation()">
                        <i class="fas fa-trash"></i> Certificado
                    </a>
                @endcan
            @else
                {{--modal firmador--}}
                @php $idModelModal = $serviceRequest->Fulfillments->first()->id;
                    $routePdfSignModal = "/rrhh/service-request/fulfillment/certificate-pdf/$idModelModal/".auth()->id();
                    $routeCallbackSignModal = 'documents.callbackFirma';
                @endphp

                @include('documents.signatures.partials.sign_file')
                <button type="button" data-toggle="modal" class="btn btn-outline-info" data-target="#signPdfModal{{$idModelModal}}" title="Firmar">Firmar certificado <i class="fas fa-signature"></i></button>
            @endif
        </fieldset>

        <fieldset class="form-group col-6 col-md-6 text-right">

        </fieldset>
    </div>

    @php $fulfillment = $serviceRequest->Fulfillments->first(); @endphp
    <!--archivos adjuntos-->
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Adjuntar archivos al cumplimiento (opcional)</h6>

            @if($fulfillment->attachments->count() > 0)
            <table class="table table-sm small table-bordered">
                <thead class="text-center">

                    <tr class="table-secondary">
                        <th width="160">Fecha de Carga</th>
                        <th>Nombre</th>
                        <th>Archivo</th>
                        <th width="100"></th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fulfillment->attachments as $attachment)
                    <tr>
                        <td>{{ $attachment->updated_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $attachment->name ?? '' }}</td>
                        <td class="text-center">
                            @if(pathinfo($attachment->file, PATHINFO_EXTENSION) == 'pdf')
                            <i class="fas fa-file-pdf fa-2x"></i>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('rrhh.service-request.fulfillment.attachment.show', $attachment) }}" class="btn btn-outline-secondary btn-sm" title="Ir" target="_blank"> <i class="far fa-eye"></i></a>
                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('rrhh.service-request.fulfillment.attachment.download', $attachment) }}" target="_blank"><i class="fas fa-download"></i>
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-danger btn-sm" 
                            wire:click="deleteAttachment({{$attachment}})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            <div>
                @livewire('service-request.attachments-fulfillments', ['var' => $fulfillment->id])
            </div>
        </div>
    </div>
    <!--fin archivos adjuntos-->
    <br>
    <div class="alert alert-warning border-dark" role="alert">
        Para horas extra, se exige solo al jefe de unidad la firma electrónica del certificado de cumplimiento.
    </div>

    <!-- <br>
    <div class="form-row">
        <div class="col-3">
            
        </div>
        <div class="col align-text-bottom">
            @if($fulfillment->responsable_approbation_date)
                @if($fulfillment->responsable_approbation) 
                    <span class="badge badge-pill badge-success">Confirmado</span>
                @else 
                    <span class="badge badge-pill badge-danger">Rechazado</span>
                @endif - 
                {{ $fulfillment->responsable_approbation_date }} - {{ $fulfillment->responsableUser->shortName }}

                @can('Service Request: delete signed certificate')
                    <a class="btn btn-outline-danger btn-sm" wire:click="deleteResponsableVb({{ $fulfillment }})" title="Borrar Aprobación Responsable" onclick="return confirm('¿Está seguro que desea eliminar las aprobaciones del cumplimiento?, deberá contactar a responsable para que vuelva a dar VB') || event.stopImmediatePropagation()">
                        <i class="fas fa-trash"></i>
                    </a>
                @endcan
            @else
                <span class="text-danger">Pendiente de aprobación</span>
            @endif
        </div>
        <div class="col-3 text-right">

        </div>
    </div>
    <br> -->
    
</div>
