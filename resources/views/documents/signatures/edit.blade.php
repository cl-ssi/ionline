@extends('layouts.bt4.app')

@section('title', 'Solicitud de firma y distribución')

@section('content')

<h3>Edición Solicitud de Firma</h3>

<form method="POST" action="{{ route('documents.signatures.update', $signature) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
        <h5 class="card-header">
            Solicitud
        </h5>
        <div class="card-body">

            <div class="form-row">
                <fieldset class="form-group col-2">
                    <label for="for_request_date">Fecha Documento</label>
                    <input type="date" class="form-control" id="for_request_date" name="request_date" required
                        value="{{ old('request_date', \Carbon\Carbon::parse($signature->request_date)->format('Y-m-d')) }}"
                    >
                </fieldset>
                
                <fieldset class="form-group col-2">
                    @livewire('signatures.document-types', ['type_id' => $signature->type_id])
                </fieldset>

                <fieldset class="form-group col-1">
                    <label for="for_reserved">&nbsp;</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="reserved" id="for_reserved" {{ $signature->reserved ? 'checked':'' }}>
                            <label class="form-check-label" for="for_reserved">Reserv.</label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group col-7">
                    <label for="for_subject">Materia o tema del documento</label>
                    <input type="text" class="form-control" id="for_subject" name="subject" required value="{{ old('subject', $signature->subject) }}">
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-12">
                    <label for="for_description">Descripción del documento</label>
                    <input type="text" class="form-control" id="for_description" name="description" value="{{ old('description', $signature->description) }}">
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col">
                    <label for="for_document">Documento a distribuir (pdf)</label>
                    <input type="file" class="form-control" id="for_document" accept="application/pdf" name="document">
                    <a href="{{route('documents.signatures.showPdf', [$signature->signaturesFileDocument, time()]
                        )}}" target="_blank" data-toggle="tooltip" data-placement="top" data-original-title="">Documento <i class="fas fa-paperclip"></i>&nbsp
                    </a>
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_annexed">Anexos</label>
                    <input type="file" class="form-control" id="for_annexed" name="annexed[]" multiple>

                    @foreach($signature->signaturesFiles->where('file_type', 'anexo') as $anexo)
                    <a href="{{route('documents.signatures.downloadAnexo', $anexo)}}" target="_blank" data-toggle="tooltip" data-placement="top" data-original-title="">Anexo <i {{--                        data-original-title="{{ $suspectCase->id . 'pdf' }}">Resultado <i--}} class="fas fa-paperclip"></i>&nbsp
                    </a>
                    @endforeach

                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col">
                    <label for="for_url">Link o Url asociado</label>
                    <input type="url" class="form-control" id="for_url" name="url" value="{{ old('url', $signature->url) }}">
                </fieldset>
            </div>
        </div>
    </div>

    
    <div class="card mt-4">
        <h5 class="card-header">
            Visadores
        </h5>
        <div class="card-body">
            @livewire('signatures.visators', ['signature' => $signature])            
        </div>
    </div>

    <div class="card mt-4">
        <h5 class="card-header">
            Firmante
        </h5>
        <div class="card-body">
            @livewire('signatures.signer', ['signaturesFlowSigner' => $signature->signaturesFlowSigner])     
        </div>
    </div>

    <div class="card mt-4">
        <h5 class="card-header">
            Distribución
        </h5>
        <div class="card-body">
            <div class="form-row">
                <fieldset class="form-group col">
                    <label for="for_distribution">Distribución del documento (separados por coma)</label>
                    <textarea class="form-control" id="for_distribution" name="distribution" rows="6">{{ old('distribution', $signature->distribution) }}</textarea>
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_recipients">Destinatarios del documento (separados por coma)</label>
                    <textarea class="form-control" id="for_recipients" name="recipients" rows="6">{{ old('recipients', $signature->recipients) }}</textarea>
                </fieldset>
            </div>
        </div>
    </div><br>

    @if($signature->hasSignedOrRejectedFlow)
    <button type="button" class="btn btn-primary" @if($signature->responsable_id != Auth::id()) disabled @endif
        data-toggle="modal" data-target="#editSignature">Guardar
    </button>

    <div class="modal fade" id="editSignature" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Editar solicitud</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <span>Esta solicitud ya tiene firmas o rechazo. Los usuarios que hayan firmado deberán firmar nuevamente.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
                    </button>

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-edit"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @else
    <button type="submit" class="btn btn-primary" @if($signature->responsable_id != Auth::id()) disabled @endif >Guardar
    </button>
    @endif

    <button type="submit" class="btn btn-danger float-right" @if($signature->responsable_id != Auth::id()) disabled
        @endif form="delete_form">Eliminar
    </button>

</form>

<form method="POST" id="delete_form" action="{{route('documents.signatures.destroy', $signature)}}" enctype="multipart/form-data">
    @csrf
    @method('DELETE')
</form>


@can('be god')
    @include('partials.audit', ['audits' => $signature->audits()] )

    @if($signature->signaturesFlowSigner)
        @include('partials.audit', ['audits' => $signature->signaturesFlowSigner->audits()] )
    @else
        <div class="alert alert-danger" role="alert">
            No tiene firmante
        </div>
    @endif
@endcan

@endsection

@section('custom_js')
    <script type="text/javascript">
        $('#for_document').bind('change', function() {
            //Validación de tamaño
            if((this.files[0].size / 1024 / 1024) > 3){
                alert('No puede cargar un pdf de mas de 3 MB.');
                $('#for_document').val('');
            }

            //Validación de pdf
            const allowedExtension = ".pdf";
            const allowedUpperExtension = ".PDF";
            let hasInvalidFiles = false;

            for (let i = 0; i < this.files.length; i++) {
                let file = this.files[i];

                if (!(file.name.endsWith(allowedExtension) || file.name.endsWith(allowedUpperExtension))) {
                    hasInvalidFiles = true;
                }
            }

            if(hasInvalidFiles) {
                $('#for_document').val('');
                alert("Debe seleccionar un archivo pdf.");
            }
        });

        $('#for_annexed').bind('change', function() {
            if((this.files[0].size / 1024 / 1024) > 45){
                alert('No puede cargar un anexo de mas de 45 MB.');
                $('#for_annexed').val('');
                return false;
            }
        });

    </script>
@endsection
