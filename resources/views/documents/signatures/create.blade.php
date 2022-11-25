@extends('layouts.app')

@section('title', 'Solicitud de firma y distribución')

@section('content')

    <h3>Nueva solicitud de firmas y distribución</h3>

        <form method="POST" action="{{ route('documents.signatures.store') }}" enctype="multipart/form-data" onsubmit="disableButton(this)">
        @csrf

        @if(isset($documentId))
            <input type="hidden" name="document_id" value="{{$documentId}}">
        @endif

        @if(isset($signature->agreement_id))
            <input type="hidden" name="agreement_id" value="{{$signature->agreement_id}}">
            <input type="hidden" name="signature_type" value="{{$signature->type}}">
        @endif

        @if(isset($signature->addendum_id))
            <input type="hidden" name="addendum_id" value="{{$signature->addendum_id}}">
            <input type="hidden" name="signature_type" value="{{$signature->type}}">
        @endif

        @if(isset($xAxis) && isset($yAxis))
            <input type="hidden" name='custom_x_axis' value="{{$xAxis}}">
            <input type="hidden" name='custom_y_axis' value="{{$yAxis}}">
        @endif

        <div class="card">
            <h5 class="card-header">
                Solicitud
            </h5>
            <div class="card-body">
                <div class="form-row">
                    <fieldset class="form-group col-3">
                        <label for="for_request_date">Fecha Documento</label>
                        <input type="date" class="form-control" id="for_request_date" name="request_date"
                            value="{{isset($signature) ? $signature->request_date->format('Y-m-d') : old('request_date')}}" required>
                    </fieldset>
                </div>

                <div class="form-row">
                    @livewire('signatures.document-types')
                    
                    <fieldset class="form-group col">
                        <label for="for_subject">Materia o tema del documento</label>
                        <input type="text" class="form-control" id="for_subject" name="subject"
                            value="{{isset($signature) ? $signature->subject : old('subject')}}" required>
                    </fieldset>
                </div>

                <div class="form-row">
                    <fieldset class="form-group col">
                        <label for="for_description">Descripción del documento</label>
                        <input type="text" class="form-control" id="for_description" name="description"
                            value="{{isset($signature) ? $signature->description : old('description')}}" required>
                    </fieldset>
                </div>

                <div class="form-row">
                    <fieldset class="form-group col">
                        @if(isset($signature) && $signature->signaturesFileDocument->file != null)
                            <button name="id" class="btn btn-link" form="showPdf" formtarget="_blank">
                                <i class="fas fa-paperclip"></i> Documento
                            </button>
                            <input type="hidden" name="file_base_64" value="{{  $signature->signaturesFileDocument->file }}">
                            <input type="hidden" name="file_base_64" value="{{  $signature->signaturesFileDocument->file}}"
                                form="showPdf">
                            <input type="hidden" name="md5_file" value="{{$signature->signaturesFileDocument->md5_file}}">
                        @else
                            <label for="for_document">Documento a distribuir (pdf)</label>
                            <input type="file" class="form-control" id="for_document" name="document" accept="application/pdf" required>
                        @endif
                    </fieldset>

                    <fieldset class="form-group col">
                        <label for="for_annexed">Anexos</label>
                        <input type="file" class="form-control" id="for_annexed" name="annexed[]" multiple>
                    </fieldset>
                </div>

                <div class="form-row">
                    <fieldset class="form-group col">
                        <label for="for_url">Link o Url asociado</label>
                        <input type="url" class="form-control" id="for_url" name="url"
                            value="{{isset($signature) ? $signature->url : old('url')}}" >
                    </fieldset>
                </div>
            </div>
        </div>

        @if(isset($signature) && isset($signature->type))
            @if($signature->type == 'visators')
                <div class="card mt-4">
                    <h5 class="card-header">
                        Visadores
                    </h5>
                    <div class="card-body">
                        @livewire('signatures.visators', ['signature' => $signature])
                    </div>
                </div>
            @else
                <div class="card mt-4">
                    <h5 class="card-header">
                        Firmante
                    </h5>
                    <div class="card-body">
                        @livewire('signatures.signer', ['signaturesFlowSigner' => $signature->signaturesFlowSigner])
                    </div>
                </div>
            @endif
        @else

            <div class="card mt-4">
                <h5 class="card-header">
                    Visadores
                </h5>
                <div class="card-body">
                    @livewire('signatures.visators')
                </div>
            </div>


            <div class="card mt-4">
                <h5 class="card-header">
                    Firmante
                </h5>
                <div class="card-body mt-4">
                    @livewire('signatures.signer')
                </div>
            </div>
        @endif

        <div class="card mt-4">
            <h5 class="card-header">
                Distribución
            </h5>
            <div class="card-body">
        
                <div class="form-row mt-4">
                    <fieldset class="form-group col">
                        <label for="for_distribution">Distribución del documento (separados por coma)</label>
                        <textarea class="form-control red-tooltip" id="for_distribution" name="distribution"
                                rows="6">{{  isset($signature) ?  str_replace(PHP_EOL, ",", $signature->distribution)  : old('distribution')}}</textarea>
                    </fieldset>

                    <fieldset class="form-group col">
                        <label for="for_recipients">Destinatarios del documento (separados por coma)</label>
                        <textarea type="text" class="form-control red-tooltip" id="for_recipients" name="recipients"
                                  rows="6"> {{ isset($signature) ?  str_replace(PHP_EOL, ",", $signature->recipients)  : old('recipients')  }} </textarea>
                    </fieldset>
                </div>
            </div>
        </div>

        <button type="submit" id="submitBtn" class="btn btn-primary mt-2" onclick="disableButton(this)"> <i class="fa fa-file"></i> Crear Solicitud</button>
    </form>

    <form method="POST" id="showPdf" name="showPdf" action="{{ route('documents.signatures.showPdfFromFile')}}">
        @csrf

    </form>

@endsection

@section('custom_js')

    <script type="text/javascript">
        function disableButton(form) {
            form.submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Creando...';
            form.submitBtn.disabled = true;
            return true;
        }

        $('#for_document').bind('change', function() {
            //Validación de tamaño
            if((this.files[0].size / 1024 / 1024) > 3){
                alert('No puede cargar un pdf de mas de 3 MB.');
                $('#for_document').val('');
            }

            //Validación de extensión pdf
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

    </script>

@endsection
