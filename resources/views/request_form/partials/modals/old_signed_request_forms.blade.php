<!-- Modal -->
<div class="modal fade" id="history-fr-{{$requestForm->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Versiones anteriores FR N° {{$requestForm->folio}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    @php($purchaser_observations = $requestForm->eventRequestForms->where('event_type', 'budget_event')->where('status', 'approved')->pluck('purchaser_observation')->toArray())
                    @php(array_pop($purchaser_observations))
                    @foreach($requestForm->signedOldRequestForms as $key => $signedOldRequestForm)
                    <a href="{{ route('request_forms.signedOldRequestFormPDF', $signedOldRequestForm) }}" class="list-group-item list-group-item-action py-2" target="_blank">
                        <i class="fas fa-handshake"></i> <i>{{ isset($purchaser_observations[$key]) ? $purchaser_observations[$key] : 'Formulario inicial' }}</i> -
                        <i class="fas fa-calendar-day"></i> {{ $signedOldRequestForm->created_at->format('d-m-Y H:i') }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>