<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-info-circle"></i> Esto es un borrador</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <object type="application/pdf" data="{{ route('request_forms.create_view_document', $requestForm) }}" width="100%" height="400" style="height: 85vh;"><a href="{{-- route('request_forms.supply.fund_to_be_settled.download', $detail->pivot->fundToBeSettled->id) --}}" target="_blank">
                        <i class="fas fa-file"></i> Ver documento</a></object>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm float-right" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->

        {{--modal firmador--}}
        @php $idModelModal = $requestForm->id;
            $routePdfSignModal = "/request_forms/create_form_document/$idModelModal/";
            $routeCallbackSignModal = 'request_forms.callbackSign';
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
