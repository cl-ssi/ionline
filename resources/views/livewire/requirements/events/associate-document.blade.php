<div class="col-12 col-md-5">
	<div class="form-row">
		<fieldset class="form-group col-12 col-md-6">
			<label for="for_doc_id">Asociar documentos</label>
			<div class="input-group @if($message) is-invalid @endif">

				<input type="number" class="form-control" id="for_doc_id" wire:model="doc_id" placeholder="número interno">
				
				<div class="input-group-append">
					<button type="button" class="btn btn-primary" wire:click="setDocument()">
						<i class="fas fa-plus"></i>
					</button>
				</div>
			</div>
			<div class="invalid-feedback">
				{{ $message }}
			</div>
		</fieldset>

		<fieldset class="form-group col-12 col-md-6">
			<label for="for_documents">&nbsp;</label>
			<input readonly class="form-control-plaintext" type='text' name="documents" wire:model='documents'>
		</fieldset>
	</div>
</div>
