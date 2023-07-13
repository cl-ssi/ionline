<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
    @endif
    <h5 class="card-title">Información adicional Recursos Humanos</h5>

    <div class="form-row mb-3">
        <div class="col-md-2">
            <label for="validationCustom01">Nº resolución</label>
            <input type="text" class="form-control" id="validationCustom01" value="{{$serviceRequest->resolution_number}}">
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
        <div class="col-md-2">
            <label for="validationCustom02">Fecha Resolución</label>
            <input type="date" class="form-control" id="validationCustom02" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
        </div>
        <div class="col-md-2">
            <label for="validationCustom03">Monto mensualizado</label>
            <input type="text" class="form-control" id="validationCustom03" value="{{$serviceRequest->net_amount}}">
        </div>
        <div class="col-md-2">
            <label for="validationCustom03">Bruto/Valor Hora</label>
            <input type="text" class="form-control" id="validationCustom03" value="{{$serviceRequest->gross_amount}}">
        </div>
        <div class="col-md-1">
            <label for="validationCustom04">SirH</label>
            <select class="custom-select" id="validationCustom04" required>
                <option value="1"  @if($serviceRequest->sirh_contract_registration == '1') selected @endif>Sí</option>
                <option value="0"  @if($serviceRequest->sirh_contract_registration == '0') selected @endif>No</option>
            </select>
        </div>
    </div>
</div>
