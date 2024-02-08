@extends('layouts.bt4.app')

@section('title', 'Solicitud de firma y distribución')

@section('content')

    <h3>Nueva solicitud de firmas y distribución</h3>

    <form method="POST" action="{{ route('documents.signatures.store') }}" enctype="multipart/form-data"
        onsubmit="disableButton(this)">
        @csrf

        @if (isset($documentId))
            <input type="hidden" name="document_id" value="{{ $documentId }}">
        @endif

        @if (isset($signature->agreement_id))
            <input type="hidden" name="agreement_id" value="{{ $signature->agreement_id }}">
            <input type="hidden" name="signature_type" value="{{ $signature->type }}">
        @endif

        @if (isset($signature->addendum_id))
            <input type="hidden" name="addendum_id" value="{{ $signature->addendum_id }}">
            <input type="hidden" name="signature_type" value="{{ $signature->type }}">
        @endif

        @if (isset($signature->continuity_resol_id))
            <input type="hidden" name="continuity_resol_id" value="{{ $signature->continuity_resol_id }}">
            <input type="hidden" name="signature_type" value="{{ $signature->type }}">
        @endif

        @if (isset($signature->budget_availability_id))
            <input type="hidden" name="budget_availability_id" value="{{ $signature->budget_availability_id }}">
            <input type="hidden" name="signature_type" value="{{ $signature->type }}">
        @endif

        @if (isset($xAxis) && isset($yAxis))
            <input type="hidden" name='custom_x_axis' value="{{ $xAxis }}">
            <input type="hidden" name='custom_y_axis' value="{{ $yAxis }}">
        @endif

        <div class="card">
            <h5 class="card-header">
                Solicitud
            </h5>
            <div class="card-body">
                <div class="form-row">
                    <fieldset class="form-group col-6 col-md-2">
                        <label for="for_request_date">Fecha Documento*</label>
                        <input type="date" class="form-control" id="for_request_date" name="request_date"
                            value="{{ isset($signature) ? $signature->request_date->format('Y-m-d') : old('request_date') }}"
                            max="{{ date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-d')))) }}" required>
                    </fieldset>

                    <fieldset class="form-group col-6 col-md-2">
                        @livewire('signatures.document-types', ['type_id' => $signature->type_id ?? null])
                    </fieldset>

                    <fieldset class="form-group col-1">
                        <label for="for_reserved">&nbsp;</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="reserved" id="for_reserved">
                                <label class="form-check-label" for="for_reserved">Reserv.</label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-group col-12 col-md-7">
                        <label for="for_subject">Materia o tema del documento*</label>
                        <input type="text" class="form-control" id="for_subject" name="subject"
                            value="{{ isset($signature) ? $signature->subject : old('subject') }}" required>
                    </fieldset>
                </div>

                <div class="form-row">
                    <fieldset class="form-group col-12 col-md-12">
                        <label for="for_description">Descripción del documento</label>
                        <input type="text" class="form-control" id="for_description" name="description"
                            value="{{ isset($signature) ? $signature->description : old('description') }}" required>
                    </fieldset>
                </div>

                <div class="form-row">
                    <fieldset class="form-group col-12 col-md-6">
                        @if (isset($signature) && $signature->signaturesFileDocument->file != null)
                            <button name="id" class="btn btn-link" form="showPdf" formtarget="_blank">
                                <i class="fas fa-paperclip"></i> Documento
                            </button>
                            <input type="hidden" name="file_base_64"
                                value="{{ $signature->signaturesFileDocument->file }}">
                            <input type="hidden" name="file_base_64"
                                value="{{ $signature->signaturesFileDocument->file }}" form="showPdf">
                            <input type="hidden" name="md5_file"
                                value="{{ $signature->signaturesFileDocument->md5_file }}">
                        @else
                            <label for="for_document">Documento a distribuir (pdf)</label>
                            <input type="file" class="form-control" id="for_document" name="document"
                                accept="application/pdf" required>
                        @endif
                    </fieldset>

                    <fieldset class="form-group col-12 col-md-6">
                        <label for="for_annexed">Anexos</label>
                        <input type="file" class="form-control" id="for_annexed" name="annexed[]" multiple>
                    </fieldset>
                </div>

                <div class="form-row">
                    <fieldset class="form-group col-12 col-md-12">
                        <label for="for_url">Link o Url asociado</label>
                        <input type="url" class="form-control" id="for_url" name="url"
                            value="{{ isset($signature) ? $signature->url : old('url') }}">
                    </fieldset>
                </div>
            </div>
        </div>

        @if (isset($signature) && isset($signature->type))
            {{-- @if ($signature->type == 'visators') --}}
            <div class="card mt-4">
                <h5 class="card-header">
                    Visadores
                </h5>
                <div class="card-body">
                    @livewire('signatures.visators', ['signature' => $signature])
                </div>
            </div>
            {{-- @else  --}}
            <div class="card mt-4">
                <h5 class="card-header">
                    Firmante
                </h5>
                {{-- <div class="card-body">
                    @livewire('signatures.signer', ['signaturesFlowSigner' => $signature->signaturesFlowSigner])
                </div> --}}
                <div class="card-body mt-4">
                    <div class="form-row">
                        <div class="col-12 col-md-8">
                            {{-- @livewire('signatures.signer') --}}
                            <label for="forOrganizationalUnit">Establecimiento / Unidad Organizacional</label>
                            @livewire('select-organizational-unit', [
                                'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
                                'organizational_unit_id' => $signature->ou_id ?? null,
                                'selected_id' => 'ou_id_signer',
                                'emitToListener' => 'getOuId',
                                'required' => false,
                            ], key('signature-'.$signature->id))
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="forUsers">Usuarios</label>
                            @livewire('rrhh.ou-users',[
                                'ou_id' => $signature->ou_id ?? null,
                                'required' => false,
                            ], key('select-organizational-unit-'.$signature->id))
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
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
                    <div class="form-row">
                        <div class="col-12 col-md-8">
                            {{-- @livewire('signatures.signer') --}}
                            <label for="forOrganizationalUnit">Establecimiento / Unidad Organizacional</label>
                            @livewire('select-organizational-unit', [
                                'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
                                'selected_id' => 'ou_id_signer',
                                'emitToListener' => 'getOuId',
                                'required' => false,
                            ])
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="forUsers">Usuarios</label>
                            @livewire('rrhh.ou-users',[
                                'required' => false,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="card mt-4">
            <h5 class="card-header">
                Distribución
            </h5>
            <div class="card-body">

                <div class="form-row mt-4">
                    <fieldset class="form-group col-12 col-md-6">
                        <label for="for_distribution">Distribución del documento (separados por coma)</label>
                        <textarea class="form-control red-tooltip" id="for_distribution" name="distribution" rows="6">{{ isset($signature) ? str_replace(PHP_EOL, ',', $signature->distribution) : old('distribution') }}</textarea>
                    </fieldset>

                    <fieldset class="form-group col-12 col-md-6">
                        <label for="for_recipients">Destinatarios del documento (separados por coma)</label>
                        <textarea type="text" class="form-control red-tooltip" id="for_recipients" name="recipients" rows="6"placeholder="En caso que en distribución esté el correo del director/a director.ssi@redsalud.gob.cl este entrará automáticamente como parte">{{ isset($signature) ? str_replace(PHP_EOL, ',', $signature->recipients) : old('recipients') }}</textarea>
                    </fieldset>
                </div>
            </div>
        </div>

        <button type="submit" id="submitBtn" class="btn btn-primary mt-2" onclick="disableButton(this)"> <i
                class="fa fa-file"></i> Crear Solicitud</button>
    </form>

    <form method="POST" id="showPdf" name="showPdf" action="{{ route('documents.signatures.showPdfFromFile') }}">
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
            if ((this.files[0].size / 1024 / 1024) > 3) {
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

            if (hasInvalidFiles) {
                $('#for_document').val('');
                alert("Debe seleccionar un archivo pdf.");
            }

        });

        $('#for_annexed').bind('change', function() {
            if ((this.files[0].size / 1024 / 1024) > 45) {
                alert('No puede cargar un anexo de mas de 45 MB.');
                $('#for_annexed').val('');
                return false;
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


@endsection
