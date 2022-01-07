<div>
  <!-- <form method="POST" action="{{ route('rrhh.service-request.fulfillment.item.store') }}" enctype="multipart/form-data"> -->
    <!-- @csrf -->
    <div class="form-row">
      <fieldset class="form-group col-12 col-md-4">
        <label for="for_type">Tipo</label>
        <select name="type" wire:model.lazy="type" class="form-control for_type" required>
          <option value=""></option>
          <option value="Inasistencia Injustificada">INASISTENCIA INJUSTIFICADA</option>
          <option value="Licencia médica">LICENCIA MÉDICA COVID</option>
          <option value="Licencia no covid">LICENCIA MÉDICA - NO COVID</option>
          <option value="Renuncia voluntaria">RENUNCIA VOLUNTARIA (EFECTIVA DESDE)</option>
          <option value="Abandono de funciones">ABANDONO DE FUNCIONES</option>
          <option value="Permiso">PERMISO ADMINISTRATIVO</option>
          <option value="Feriado">FERIADO</option>
          <option value="Término de contrato anticipado">TÉRMINO DE CONTRATO ANTICIPADO (EFECTIVA DESDE)</option>
          <option value="Atraso">ATRASO</option>
          <option value="Fuero maternal">FUERO MATERNAL</option>
        </select>
      </fieldset>
      <fieldset class="form-group col-12 col-md">
        <label for="for_observation">Observación</label>
        <input type="text" class="form-control" name="observation" wire:model.lazy="observation">
      </fieldset>
    </div>
    @php
    $ano = \Carbon\Carbon::now()->format('Y');
    $anopasado = $ano-1;
    @endphp
    <div class="form-row">
      <fieldset class="form-group col-6 col-md-3">
        <label for="for_start_date">Entrada</label>
        <input type="date" class="form-control start_date" name="start_date" {{$select_start_date}} wire:model.lazy="start_date" min="{{$anopasado}}-01-01" max="{{$ano}}-12-31"  required>
      </fieldset>
      <fieldset class="form-group col-6 col-md">
        <label for="for_start_hour">Hora</label>
        <input type="time" class="form-control start_hour" {{$select_start_hour}} name="start_hour" wire:model.lazy="start_hour" required>
      </fieldset>
      <fieldset class="form-group col-6 col-md-3">
        <label class="salida" id="id_salida">Salida</label>
        <input type="date" class="form-control end_date" name="end_date" {{$select_end_date}} wire:model.lazy="end_date" min="{{$anopasado}}-01-01" max="{{$ano}}-12-31" required>
      </fieldset>
      <fieldset class="form-group col-6 col-md">
        <label for="for_end_hour">Hora</label>
        <input type="time" class="form-control end_hour" name="end_hour" {{$select_end_hour}} wire:model.lazy="end_hour" required>
      </fieldset>

      @canany(['Service Request: fulfillments responsable','Service Request: fulfillments rrhh'])
        @if($fulfillment->responsable_approver_id == NULL)
        <fieldset class="form-group col">
          <label for="for_submit"><br/></label>
          <button type="submit" class="btn form-control btn-primary" wire:click="save()">Guardar</button>
        </fieldset>
        @else
        <fieldset class="form-group col">
          <label for="for_label"><br/></label>
          Ya está aprobada por el responsable
        </fieldset>
        @endif
      @endcan
    </div>
  <!-- </form> -->
  @if($msg)
  <div>
      <div class="alert alert-warning" role="alert">
          {{$msg}}
      </div>
  </div>
  @endif

  <table class="table table-sm">
    <thead>
      <tr>
        <th></th>
        <th>Tipo</th>
        <th>Inicio</th>
        <th>Término</th>
        <th>Observación</th>
      </tr>
    </thead>
    <tbody>
      @foreach($fulfillment->FulfillmentItems as $key => $FulfillmentItem)
      <tr>
        <td>
          @canany(['Service Request: fulfillments responsable','Service Request: fulfillments rrhh'])
          @if($fulfillment->responsable_approver_id == NULL)
          <!-- <form method="POST" action="{{ route('rrhh.service-request.fulfillment.item.destroy', $FulfillmentItem) }}" class="d-inline">
            @csrf
            @method('DELETE') -->
            <button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de eliminar la información?');" wire:click="delete({{$FulfillmentItem}})">
            <span class="fas fa-trash-alt" aria-hidden="true"></span>
            </button>
          <!-- </form> -->
          @endif
          @endcan
        </td>
        <td>{{$FulfillmentItem->type}}</td>
        <td>@if($FulfillmentItem->start_date){{$FulfillmentItem->start_date->format('Y-m-d H:i')}}@endif</td>
        <td>@if($FulfillmentItem->end_date){{$FulfillmentItem->end_date->format('Y-m-d H:i')}}@endif</td>
        <td>{{$FulfillmentItem->observation}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
