@if($showModal)
    <!-- Modal -->
    <div class="modal {{ $showModal }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h6 class="modal-title">
                        Aprobará como
                        <i class="fas fa-fw {{ $approvalSelected->sent_to_ou_id ? 'fa-chess-king' : 'fa-user' }}"></i>
                        @if($approvalSelected->sent_to_ou_id)
                            de {{ $approvalSelected->sentToOu->name }}
                        @else
                            {{ auth()->user()->tinnyName }}
                        @endif
                    </h6>

                    <button 
                        type="button" 
                        class="btn-close" 
                        data-bs-dismiss="modal" 
                        aria-label="Close"
                        wire:click="dismiss">
                    </button>

                </div>
                <div class="modal-body">
                    <object
                        @if($approvalSelected->digital_signature && $approvalSelected->status)
                            data="{{ $approvalSelected->filename_link }}"
                        @else
                            data="{{ route($approvalSelected->document_route_name, json_decode($approvalSelected->document_route_params, true)) }}"
                        @endif
                        type="application/pdf"
                        width="100%"
                        height="700px"
                    >

                        <p>No se puede mostrar el PDF.
                            <a
                                target="_blank"
                                @if($approvalSelected->digital_signature && $approvalSelected->status)
                                    href="{{ $approvalSelected->filename_link }}"
                                @else
                                    href="{{ route($approvalSelected->document_route_name, json_decode($approvalSelected->document_route_params, true)) }}"
                                @endif
                            >Descargar
                            </a>.
                        </p>
                    </object>
                </div>
                <div class="modal-footer">
                    <div class="row">

                        @if( is_null($approvalSelected->status) )
                        <div class="col-8">
                            <div class="input-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Motivo rechazo"
                                    aria-label="Motivo de rechazo"
                                    aria-describedby="button-addon"
                                    wire:model.defer="approver_observation"
                                    value="{{ $approvalSelected->approver_observation }}"
                                >
                                <button
                                    class="btn btn-danger"
                                    type="button"
                                    id="button-addon"
                                    wire:click="approveOrReject({{ $approvalSelected }}, false)"
                                >
                                    <i class="fas fa-thumbs-down"></i>
                                </button>
                            </div>
                        </div>
                        @else
                            <div class="text-{{ $approvalSelected->color }}">
                                El documento se encuentra {{ $approvalSelected->status ? 'Aprobado' : 'Rechazado' }}
                                <i> <small>{{ $approvalSelected->approver_observation }}</small> </i>
                            </div>
                        @endif

                        @if( is_null($approvalSelected->status) )
                            <div class="col-4">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="OTP"
                                        aria-label="OTP"
                                        aria-describedby="button-addon"
                                        wire:model.defer="otp"
                                        @disabled( !$approvalSelected->digital_signature)
                                    >
                                    <button
                                        class="btn btn-success"
                                        wire:loading.attr="disabled"
                                        wire:click="approveOrReject([{{ $approvalSelected->id }}], true)"
                                    >
                                        <span
                                            wire:loading.remove
                                            wire:target="otp"
                                        >
                                            <i class="fas fa-thumbs-up"></i>
                                        </span>

                                        <span
                                            class="spinner-border spinner-border-sm"
                                            role="status"
                                            wire:loading
                                            wire:target="otp"
                                            aria-hidden="true"
                                        >
                                        </span>
                                    </button>

                                </div>
                                <div class="invalid-feedback">
                                    @if(isset($message))
                                        <small id="otp" class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                <!-- End Footer -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
@endif