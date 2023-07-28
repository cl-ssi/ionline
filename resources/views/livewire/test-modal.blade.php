<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" wire:click="show">
        Firmar
    </button>

    @if($showModal)
        <!-- Modal -->
        <div class="modal {{ $showModal }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" wire:click="dismiss" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <embed src="{{ $file_url }}" width="100%" height="700">
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="OTP">
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary" wire:click="sign">Firmar</button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    @endif
</div>
