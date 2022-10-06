 <fieldset class="form-group col-3">
    <label for="for_document_type">Tipo de Documento</label>
    <select class="form-control document_type" name="document_type" required wire:model='selectedDocumentType' wire:change='changeDocumentType'>
        @php($docTypes = array('Carta', 'Circular', 'Convenios', 'Memorando', 'Oficio', 'Resoluciones', 'Acta', 'Protocolo', 'Reservado'))
        <option value="">Seleccione tipo</option>
        @foreach($docTypes as $docType)
            <option value="{{$docType}}"
                    @if(isset($signature) && $docType == $signature->document_type) selected @endif>{{$docType}}</option>
        @endforeach
    </select>
</fieldset>
