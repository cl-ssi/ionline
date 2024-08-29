<!-- Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-info-circle"></i> Esto es un borrador</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <object type="application/pdf" data="{{ route('request_forms.create_view_document', [$requestForm, $eventType == 'budget_event' ? 1 : 0]) }}" width="100%" height="400" style="height: 85vh;"><a href="{{-- route('request_forms.supply.fund_to_be_settled.download', $detail->pivot->fundToBeSettled->id) --}}" target="_blank">
                        <i class="fas fa-file"></i> Ver documento</a></object>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm float-right" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->

        {{--modal firmador--}}
        @php 
            $idModelModal = $requestForm->id;
            $routePdfSignModal = "/request_forms/create_form_document/$idModelModal/".($eventType == 'budget_event' ? 1 : 0);
            $routeCallbackSignModal = $eventType == 'budget_event' ? 'request_forms.callbackSignNewBudget' : 'request_forms.callbackSign';
        @endphp

        @include('documents.signatures.partials.sign_file')
        
        {{--@if(auth()->user()->OrganizationalUnit->establishment_id == App\Models\Parameters\Parameter::where('parameter', 'SSTarapaca')->first()->value)
        <input type="file" wire:model="docSigned" name="docSigned" id="docSigned" wire:click="resetError">
        <div wire:loading wire:target="docSigned">Cargando archivo...</div>
        @error('docSigned') <span class="error text-danger">{{ $message }}</span> @enderror
        <button type="button" wire:click="acceptRequestFormByFinance" class="btn btn-primary btn-sm float-right" wire:loading.attr="disabled">Autorizar</button>
        @else--}}
        <button type="button" data-toggle="modal" class="btn btn-primary btn-sm float-right"
            title="Firma Digital"
            data-target="#signPdfModal{{$idModelModal}}" title="Firmar">
              Firmar Form. <i class="fas fa-signature"></i>
        </button>
        {{--@endif--}}
      </div>
    </div>
  </div>
</div>
