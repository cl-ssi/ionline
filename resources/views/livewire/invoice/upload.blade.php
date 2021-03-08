<div>
    <form wire:submit.prevent="save">

        {{--        <div class="custom-file">--}}
        {{--            <input type="file" wire:model="invoice" class="custom-file-input" id="customFile">--}}
        {{--            <label class="custom-file-label" for="customFile">Choose file</label>--}}
        {{--        </div>--}}

        <input type="file" wire:model="invoiceFile" required>
        @error('invoiceFile') <span class="error">{{ $message }}</span> @enderror
        @if($hasInvoiceFile)
        <button type="submit" class="btn btn-outline-primary">Actualizar Boleta</button>
        @else
        <button type="submit" class="btn btn-outline-primary">Guardar Boleta</button>
        @endif
    </form>

    @if($hasInvoiceFile)

        <a href="{{route('rrhh.fulfillments.downloadInvoice', $fulfillmentId)}}"
           target="_blank" data-toggle="tooltip" data-placement="top"
           data-original-title="">Boleta Cargada
        </a>
    @endif

    {{--    <div wire:loading wire:target="invoiceFile">Cargando...</div>--}}
    {{--    <script>--}}
    {{--        // Add the following code if you want the name of the file appear on select--}}
    {{--        $(".custom-file-input").on("change", function() {--}}
    {{--            var fileName = $(this).val().split("\\").pop();--}}
    {{--            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);--}}
    {{--        });--}}
    {{--    </script>--}}

</div>

