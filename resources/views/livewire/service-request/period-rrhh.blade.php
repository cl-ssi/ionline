<div class="card mb-3 border-danger">
    <div class="card-body">
        <h5 class="card-title">Recursos Humanos</h5>
        <div class="form-row mb-3">
            <div class="col-md-2">
                <label for="for_total_hours_to_pay">Total de horas a pagar</label>
                <input type="text" class="form-control" wire:model="fulfillment.total_hours_to_pay">
                @error('fulfillment.total_hours_to_pay') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <label for="for_total_to_pay">Total a pagar</label>
                <input type="text" class="form-control" wire:model="fulfillment.total_to_pay">
                @error('fulfillment.total_to_pay') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <div class="form-check form-check">
                    <!-- <input type="hidden" name="illness_leave" value="0"> -->
                    <input class="form-check-input" type="checkbox" wire:model="fulfillment.illness_leave">
                    <label class="form-check-label" for="for_illness_leave">Licencias</label>
                </div>
                <div class="form-check form-check">
                    <!-- <input type="hidden" name="leave_of_absence" value="0"> -->
                    <input class="form-check-input" type="checkbox" wire:model="fulfillment.leave_of_absence">
                    <label class="form-check-label" for="permisos">Permisos</label>
                </div>
                <div class="form-check form-check">
                    <!-- <input type="hidden" name="assistance" value="0"> -->
                    <input class="form-check-input" type="checkbox" wire:model="fulfillment.assistance">
                    <label class="form-check-label" for="asistencia">Asistencia</label>
                </div>
            </div>
        </div>
        <!-- solo se pueden confirmar periodos mensuales, y horas médicas/turnos de reemplazo -->
        @if($fulfillment->serviceRequest->program_contract_type == "Mensual" || 
            ($fulfillment->serviceRequest->program_contract_type == "Horas" && 
            ($fulfillment->serviceRequest->working_day_type == "HORA MÉDICA" || $fulfillment->serviceRequest->working_day_type == "TURNO DE REEMPLAZO"))
            )
            <div class="form-row">
                <div class="col-3">
                    <button class="btn btn-primary" wire:click="save()" @disabled(!auth()->user()->can('Service Request: fulfillments rrhh') || $fulfillment->rrhh_approbation) type="submit">Guardar</button>
                </div>
                <div class="col align-text-bottom">
                    @if($fulfillment->rrhh_approbation_date)
                        @if($fulfillment->rrhh_approbation) 
                            <span class="badge badge-pill badge-success">Confirmado</span>
                        @else 
                            <span class="badge badge-pill badge-danger">Rechazado</span>
                        @endif - 
                        {{ $fulfillment->rrhh_approbation_date }} - {{ $fulfillment->rrhhUser->shortName }}
                    @else
                        <span class="text-danger">Pendiente de aprobación</span>
                    @endif
                </div>
                <div class="col-3 text-right">
                    <button class="btn btn-danger" wire:click="refuseFulfillment({{$fulfillment}})" @disabled(!auth()->user()->can('Service Request: fulfillments rrhh') || $fulfillment->rrhh_approbation) type="submit">Rechazar</button>
                    <button class="btn btn-success" wire:click="confirmFulfillment({{$fulfillment}})" @disabled(!auth()->user()->can('Service Request: fulfillments rrhh') || $fulfillment->rrhh_approbation) type="submit">Confirmar</button>
                </div>
            </div>
        @endif
    </div>
    @include('layouts.bt4.partials.flash_message_custom',[
        'name' => 'period-rrhh',  // debe ser único
        'type' => 'primary' // optional: 'primary' (default), 'danger', 'warning', 'success', 'info'
    ])
</div>