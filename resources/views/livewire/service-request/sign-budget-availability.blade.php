    @if($serviceRequest->signed_budget_availability_cert_id)
        <a class="btn btn-info"
           title="Ver Certificado de Disponibilidad Presupuestaria firmado"
           href="{{ route('rrhh.service-request.signed-budget_availability-pdf',$serviceRequest) }}"
           target="_blank" title="Certificado">
            CDP Firmado
        </a>
    @else
        {{--modal firmador--}}
        @php $idModelModal = $serviceRequest->id;
					$routePdfSignModal = "/rrhh/service-request/fulfillment/certificate-pdf/$idModelModal/";
					$routeCallbackSignModal = 'rrhh.service-request.callbackFirmaBudgetAvailability';
        @endphp

        @include('documents.signatures.partials.sign_file')
        <button type="button" data-toggle="modal" class="btn btn-outline-info"
                title="Firmar Certificado de Disponibilidad Presupuestaria"
                data-target="#signPdfModal{{$idModelModal}}" title="Firmar">Firmar CDP <i
                class="fas fa-signature"></i></button>
    @endif
