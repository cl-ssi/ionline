<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-info-circle"></i> Esto es un borrador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <object type="application/pdf" 
                    data="{{ route('allowances.sign.create_view_document', $allowance) }}" 
                    width="100%" 
                    height="400" 
                    style="height: 85vh;">
                </object>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm float-right" data-dismiss="modal">Cerrar</button>

                @php 
                    $idModelModal = $allowance->id;
                    /* $routePdfSignModal = "/request_forms/create_form_document/$idModelModal/$has_increase_expense"; */
                    $routePdfSignModal = "/allowances/sign/$idModelModal/create_form_document";
                    $routeCallbackSignModal = 'allowances.sign.callbackSign';
                    /* dd($routePdfSignModal, $routeCallbackSignModal) */
                @endphp

                @include('documents.signatures.partials.sign_file')

                <button type="button" data-toggle="modal" class="btn btn-primary btn-sm float-right"
                    title="Firma Digital"
                    data-target="#signPdfModal{{$idModelModal}}" title="Firmar">
                    Firmar Form. <i class="fas fa-signature"></i>
                </button>
            </div>
        </div>
    </div>
</div>