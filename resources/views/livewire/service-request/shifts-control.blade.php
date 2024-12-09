<div>
  <div class="card" id="control_turnos">
    <div class="card-header">
      Control de Turnos
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <div class="form-row">
          <fieldset class="form-group col-3">
              <label for="for_shift_start_date">Entrada</label>
              <input type="date" class="form-control" wire:model.live="shift_start_date" id="shift_start_date" min="2021-01-01" max="{{Carbon\Carbon::now()->toDateString()}}">
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_start_hour">Hora</label>
              <input type="time" class="form-control" wire:model.live="start_hour" id="start_hour">
          </fieldset>
          <fieldset class="form-group col-3">
              <label for="for_shift_end_date">Salida</label>
              <input type="date" class="form-control" wire:model.live="shift_end_date" id="shift_end_date" min="2021-01-01" max="{{Carbon\Carbon::now()->toDateString()}}">
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_end_hour">Hora</label>
              <input type="time" class="form-control" wire:model.live="end_hour" id="end_hour">
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_observation">Observación</label>
              <input type="text" class="form-control" wire:model.live="observation" id="observation">
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_label"><br/></label>

              @can('Service Request: fulfillments rrhh')
                <button type="button" class="btn btn-primary form-control add-row" wire:click="save()">Ingresar</button>
              @endcan

              @can('Service Request: fulfillments responsable')
                @if($fulfillment->responsable_approbation == null)
                  <button type="button" class="btn btn-primary form-control add-row" wire:click="save()">Ingresar</button>
                @endif
              @endcan

          </fieldset>
        </div>

        <div class="alert alert-info" role="alert">
          {{$msg}}
        </div>

        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Horas</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
              @foreach($fulfillment->shiftControls->sortBy('start_date') as $key => $shiftControl)
                <tr>
                  <td>{{$shiftControl->start_date->format('Y-m-d H:i')}}
                    @if($shiftControl->start_date->diffInHours($shiftControl->start_date->addDay()) != 24.0)
                      <span class="badge badge-danger">(Cambio de hora)</span>
                    @endif
                  </td>
                  <td>@if($shiftControl->end_date){{$shiftControl->end_date->format('Y-m-d H:i')}}@endif</td>
                  <td>
                    @if($shiftControl->end_date)
                      {{ $this->formatHours($shiftControl->start_date->diffInMinutes($shiftControl->end_date)) }}
                    @endif
                  </td>
                  <td>{{$shiftControl->observation}}</td>
                  <td>
                    @can('Service Request: fulfillments rrhh')
                    <button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de eliminar la información?');" wire:click="delete({{$shiftControl}})">
                    <span class="fas fa-trash-alt" aria-hidden="true"></span>
                    </button>
                    @endcan

                    @can('Service Request: fulfillments responsable')
                      @if($fulfillment->responsable_approbation == null)
                      <button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de eliminar la información?');" wire:click="delete({{$shiftControl}})">
                      <span class="fas fa-trash-alt" aria-hidden="true"></span>
                      </button>
                      @endif
                    @endcan

                  </td>
                </tr>
              @endforeach
            </tbody>
        </table>

      </li>
    </ul>
  </div>

  <div wire:loading wire:target="save">
      <span class="text-muted small">Procesando...</span>
  </div>
</div>
