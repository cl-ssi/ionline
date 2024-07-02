<div>
    @isset($fileId)
        <div class="row pb-2">
            <div class="col-8">
                <a wire:click="downloadPdfNoApproval()"
                    target="_self"
                    href="#"
                    class="link-primary">

                    {{$fileName}}
                </a>
            </div>
            <div class="col-3 offset-1">
                <i wire:click.prevent="downloadPdfNoApproval()"  wire:loading.attr="disabled" class="col link-primary fas fa-file-pdf text-danger" style="cursor:pointer"></i>
                <i wire:click="deletePdfNoApproval()" wire:loading.remove class="col link-primary fas fa-times-circle text-danger" style="cursor:pointer"></i>
                <i wire:loading class="col fas fa-spinner fa-spin text-danger"></i>
            </div>
        </div>
        <!-- <br> -->
    @endif
</div>
