<!-- Modal -->
<div class="modal fade" id="exampleModal-{{ $event->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-comment"></i> Observación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p class="text-left"><i class="fas fa-calendar"></i> {{ $event->signature_date->format('d-m-Y H:i:s') }} por: {{ $event->signerUser->FullName }}</p>
          @if($event->StatusValue == 'Aprobado')
            <p class="text-left">
              <span style="color: green;">
                <i class="fas fa-check-circle text-left"></i> {{ $event->StatusValue }} <br>
              </span>
            <p>
          @else
            <p class="text-left">
              <span style="color: Tomato;">
                <i class="fas fa-times-circle"></i> {{ $event->StatusValue }} <br>
              </span>
            </p>
          @endif
          <p class="text-left font-italic"><i class="fas fa-comment"></i> "{{ $event->comment }}"</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
