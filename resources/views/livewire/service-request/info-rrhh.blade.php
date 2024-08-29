<div>
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
            <input type="text" class="form-control" id="validationCustom01" wire:model="resolutionNumber">
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
        <div class="col-md-2">
            <label for="validationCustom02">Fecha Resolución</label>
            <input type="date" class="form-control" id="validationCustom02" wire:model="resolutionDate">
        </div>
        <div class="col-md-2">
            <label for="validationCustom03">Monto mensualizado</label>
            <input type="text" class="form-control" id="validationCustom03" wire:model="netAmount">
        </div>
        <div class="col-md-2">
            <label for="validationCustom03">Bruto/Valor Hora</label>
            <input type="text" class="form-control" id="validationCustom03" wire:model="grossAmount">
        </div>
        <div class="col-md-1">
            <label for="validationCustom04">SirH</label>
            <select class="custom-select" id="validationCustom04" required wire:model="sirhContractRegistration">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="col-1 text-right">
            <label for="validationCustom04">&nbsp;</label>
            <button class="btn btn-primary form-control" type="submit" wire:click="saveInfoRrhh">
                <i class="fas fa-save"></i>
            </button>
        </div>
    </div>
</div>
