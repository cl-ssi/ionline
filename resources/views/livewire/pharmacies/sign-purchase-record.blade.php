<div>
    @if($purchase->signed_record_id)
        <a class="btn btn-success btn-sm"
           title="Ver Acta firmada."
           href="{{ route('pharmacies.products.signed_record_pdf',$purchase) }}"
           target="_blank" title="Certificado">
            <i
                class="fas fa-signature"></i>
        </a>
    @else
        {{--modal firmador--}}
        @php
            $idModelModal = $purchase->id;
            $routePdfSignModal = "/pharmacies/products/purchase/record-pdf/$idModelModal/";
            $routeCallbackSignModal = 'pharmacies.products.callbackFirmaRecord';            
        @endphp

        @include('documents.signatures.partials.sign_file')
        <button type="button" data-toggle="modal" class="btn btn-outline-secondary btn-sm"
                title="Firmar Acta de Compra"
                data-target="#signPdfModal{{$idModelModal}}" title="Firmar"> <i
                class="fas fa-signature"></i></button>
    @endif
</div>