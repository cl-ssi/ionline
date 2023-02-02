<div>
    <label for="for_document_type">Tipo de Documento</label>
    <select class="form-control" name="document_type" required wire:model='type_id' wire:change='changeDocumentType'>
        <option>Seleccione tipo</option>
        @foreach($types as $id => $type)
        <option value="{{ $id }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
