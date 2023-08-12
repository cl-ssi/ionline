<div class="card mb-3 border-danger">
    <div class="card-body">
        <h5 class="card-title">Recursos Humanos</h5>
        <div class="form-row mb-3">
            <div class="col-md-2">
                <label for="validationCustom03">Total de horas a pagar</label>
                <input type="text" class="form-control" id="validationCustom03" value="{{ $fulfillment->total_hours_paid }}">
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
            </div>
            <div class="col-md-2">
                <label for="validationCustom03">Total a pagar</label>
                <input type="text" class="form-control" id="validationCustom03" value="{{ $fulfillment->total_to_pay }}">
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-check form-check">
                    <input type="hidden" name="illness_leave" value="0">
                    <input class="form-check-input" type="checkbox" name="illness_leave" value="1" {{ ( $fulfillment->illness_leave== '1' ) ? 'checked="checked"' : null }}>
                    <label class="form-check-label" for="for_illness_leave">Licencias</label>
                </div>
                <div class="form-check form-check">
                    <input type="hidden" name="leave_of_absence" value="0">
                    <input class="form-check-input" type="checkbox" id="permisos" name="leave_of_absence" value="1" {{ ( $fulfillment->leave_of_absence== '1' ) ? 'checked="checked"' : null }}>
                    <label class="form-check-label" for="permisos">Permisos</label>
                </div>
                <div class="form-check form-check">
                    <input type="hidden" name="assistance" value="0">
                    <input class="form-check-input" type="checkbox" name="assistance" value="1" {{ ( $fulfillment->assistance== '1' ) ? 'checked="checked"' : null }}>
                    <label class="form-check-label" for="asistencia">Asistencia</label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-3">
                @can('Service Request: fulfillments rrhh')
                    <button class="btn btn-outline-secondary" @disabled($fulfillment->rrhh_approbation) type="submit">Guardar</button>
                @endcan
            </div>
            <div class="col align-text-bottom">
                @if($fulfillment->rrhh_approbation_date)
                    {{ $fulfillment->rrhh_approbation_date }} - {{ $fulfillment->rrhhUser->shortName }}
                @else
                    <span class="text-danger">Pendiente de aprobación</span>
                @endif
            </div>
            <div class="col-3 text-right">
                @can('Service Request: fulfillments rrhh')
                    <button class="btn btn-outline-danger" @disabled($fulfillment->rrhh_approbation) type="submit">Rechazar</button>
                    <button class="btn btn-success" @disabled($fulfillment->rrhh_approbation) type="submit">Confirmar</button>
                @endcan
            </div>
        </div>
    </div>
</div>