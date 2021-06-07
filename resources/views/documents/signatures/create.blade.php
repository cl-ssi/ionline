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

        @if(isset($xAxis) && isset($yAxis)){
            <input type="hidden" name='custom_x_axis' value="{{$xAxis}}">
            <input type="hidden" name='custom_y_axis' value="{{$yAxis}}">
        @endif

        <div class="form-row">

            <fieldset class="form-group col-3">
                <label for="for_request_date">Fecha Documento</label>
                <input type="date" class="form-control" id="for_request_date" name="request_date"
                       value="{{isset($signature) ? $signature->request_date->format('Y-m-d') : ''}}" required>
            </fieldset>
        </div>

        <div class="form-row">

            <fieldset class="form-group col-3">
                <label for="for_document_type">Tipo de Documento</label>
                <select class="form-control" name="document_type" required>
                    @php($docTypes = array('Carta', 'Circular', 'Convenios', 'Memorando', 'Oficio', 'Resoluciones', 'Acta'))
                    <option value="">Seleccione tipo</option>
                    @foreach($docTypes as $docType)
                        <option value="{{$docType}}"
                                @if(isset($signature) && $docType == $signature->document_type) selected @endif>{{$docType}}</option>
                    @endforeach
                </select>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_subject">Materia o tema del documento</label>
                <input type="text" class="form-control" id="for_subject" name="subject"
                       value="{{isset($signature) ? $signature->subject : ''}}" required>
            </fieldset>

        </div>

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="for_description">Descripción del documento</label>
                <input type="text" class="form-control" id="for_description" name="description"
                       value="{{isset($signature) ? $signature->description : ''}}" required>
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
                    <label for="for_document">Documento a distribuir</label>
                    <input type="file" class="form-control" id="for_document" name="document" accept="application/pdf" required>
                @endif

            </fieldset>

            <fieldset class="form-group col">
                <label for="for_annexed">Anexos</label>
                <input type="file" class="form-control" id="for_annexed" name="annexed[]" multiple>
            </fieldset>
        </div>

        @if(isset($signature) && isset($signature->type))
            <hr>
            @if($signature->type == 'visators')
                @livewire('signatures.visators', ['signature' => $signature])
            @else
                @livewire('signatures.signer', ['signaturesFlowSigner' => $signature->signaturesFlowSigner])
            @endif
            <hr>
        @else
            <hr>
            @livewire('signatures.visators')
            <hr>
            @livewire('signatures.signer')
            <hr>
        @endif

        <div class="form-row">            

            <fieldset class="form-group col">
                <label for="for_distribution">Distribución del documento (separados por coma)</label>
                <textarea class="form-control red-tooltip" id="for_distribution" name="distribution"
                data-toggle="tooltip" data-placement="top" title="Se cambio de posición Destinatario y Distribución a como estaba en el sistema antiguamente, favor tenga cuidado de ver el apartado donde está digitando"
                placeholder="Se cambio de posición Destinatario y Distribución a como estaba en el sistema antiguamente, favor cerciorarse el apartado que está digitando"
                          rows="6">{{  isset($signature) ?  str_replace(PHP_EOL, ",", $signature->recipients)  : ''}}</textarea>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_recipients">Destinatarios del documento (separados por coma)</label>
                <textarea type="text" class="form-control red-tooltip" id="for_recipients" name="recipients" rows="6" 
                data-toggle="tooltip"  data-placement="top" title="Se cambio de posición Destinatario y Distribución a como estaba en el sistema antiguamente, favor cerciorarse el apartado que está digitando"
                placeholder="Se cambio de posición Destinatario y Distribución a como estaba en el sistema antiguamente, favor cerciorarse el apartado que está digitando"
                
                ></textarea>
            </fieldset>

        </div>

        <button type="submit" id="submitBtn" class="btn btn-primary" onclick="disableButton(this)">Crear</button>

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
    </script>

@endsection
