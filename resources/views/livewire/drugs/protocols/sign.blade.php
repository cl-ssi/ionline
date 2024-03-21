<div>
    @if($protocol->approval)
        @if($protocol->approval->status == true)
        <!-- Si está firmado -->
            <a
                class="btn btn-sm btn-outline-danger"
                target="_blank"
                    href="{{ route('documents.signed.approval.pdf', $protocol->approval) }}"
            >
                <i class="fas fa-fw fa-file-pdf"></i>
            </a>
        @else
            <!-- Si no está firmado -->
            <button class="btn btn-sm btn-outline-secondary" disabled title="Pendiente de firmar">
                <i class="fas fa-fw fa-clock"></i>
            </button>
        @endif
    @else
        <button class="btn btn-sm btn-primary" wire:click="sendToSign">
            <i class="fas fa-signature"></i> Enviar a firma digital
        </button>
    @endif
</div>
