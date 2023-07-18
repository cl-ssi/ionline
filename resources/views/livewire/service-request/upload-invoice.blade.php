<div class="form-row">
    <div class="col-3">
        <b>Monto a ingresar:</b> ${{ money($fulfillment->total_to_pay) }}
    </div>
    @if($has_invoice_file)
        <div class="col-1"></div>
        <div class="col-1">
            <a class="btn btn-outline-danger" wire:click="delete">
                <i class="fas fa-trash"></i>
            </a>
        </div>
        <div class="col-3">
            <a href="{{route('rrhh.service-request.fulfillment.download_invoice', [$fulfillment, time()]) }}"
                target="_blank" class="btn btn-outline-info form-control"> <i class="fas fa-dollar-sign"></i> Boleta </a>
            </a>
        </div>
        <div class="col-3">
            @if($fulfillment->voiceUploader)
                {{ $fulfillment->voiceUploader->shortName }} <br> {{ $fulfillment->has_invoice_file_at }}
            @endif
        </div>
    @else
        @if($fulfillment->serviceRequest->has_resolution_file)
        <div class="col-2"></div>
        <div class="col-5">
            <div class="custom-file">
                <input type="file" class="custom-file-input" wire:model="invoiceFile">
                <label class="custom-file-label" for="customFileLangHTML" data-browse="Examinar">{{ optional($invoiceFile)->getClientOriginalName() }}</label>
                @error('invoiceFile') <span class="error">{{ $message }}</span> @enderror
                <small id="emailHelp" class="form-text text-muted">
                Fecha de boleta mensual: último día del mes.<br>
                Fecha de boleta extra: debe ser igual o posterior a la resolución. 
            </small>
            </div>
        </div>
        <div class="col-1">
            <div wire:loading wire:target="invoiceFile">
                <strong><i class="fas fa-circle-notch fa-spin fa-2x"></i></strong>
            </div>
        </div>
        <div class="col-1">
            <button type="button" wire:click="save()" class="btn btn-outline-primary">
                <i class="fas fa-save"></i>
            </button>
        </div>

        @else
        <div class="col">
            No es posible cargar boleta, falta cargar la resolución firmada.
        </div>
        @endif
    @endif
</div>
