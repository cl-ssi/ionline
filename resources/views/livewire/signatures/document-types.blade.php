<div>
    <label for="for_document_type">Tipo de Documento*</label>
    <select class="form-control" name="type_id" required wire:model.live='type_id' wire:change='changeDocumentType' required>
        <option value=""></option>
        @foreach($types as $id => $type)
        <option value="{{ $id }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
