<div>
    <div class="row">
        <div class="col-12">
            @if(Session::has('message'))
                <p class="alert alert-danger">{{ Session::get('message') }}</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="table-responsive">
                <table class="table table-bordered table-sm small">
                    <thead>
                        <tr>
                            <th width="25%" class="table-secondary text-end">Producto:</th>
                            <td class="text-start">{{ $item->unspscProduct->name }}</td>
                        </tr>
                        <tr>
                            <th width="25%" class="table-secondary text-end">Unidad:</th>
                            <td class="text-start">{{ $item->unit_of_measurement }}</td>
                        </tr>
                        <tr>
                            <th width="25%" class="table-secondary text-end">Especificaciones Técnicas:</th>
                            <td class="text-start">{{ $item->specification }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="col-2">
            <div class="card">
                <div class="card-header">
                    Solicitados
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $quantity }}</h5>
                </div>
            </div>
        </div>
        <div class="col-2">
            <div class="card">
                <div class="card-header">
                    Detalle
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        @if($quantityDetail >= 0)
                            {{ $quantityDetail }}
                        @else
                            0
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
    

    <div class="row g-3 align-items-center">
        <div class="col-3">
            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Enero" autocomplete="off" disabled>
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Febrero" autocomplete="off" disabled>
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Marzo" autocomplete="off" disabled>
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Abril" autocomplete="off" disabled>
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Mayo" autocomplete="off" disabled>
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Junio" autocomplete="off" disabled>
            </fieldset>
        </div>

        <div class="col-3">
            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="january">
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="february">
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="march">
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="april">
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="may">
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="june">
            </fieldset>
        </div>

        <div class="col-3">
            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Julio" autocomplete="off" disabled>
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Agosto" autocomplete="off" disabled>
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Septiembre" autocomplete="off" disabled>
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Octubre" autocomplete="off" disabled>
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Noviembre" autocomplete="off" disabled>
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="text" value="Diciembre" autocomplete="off" disabled>
            </fieldset>
        </div>

        <div class="col-3">
            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="july">
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="august">
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="september">
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="october">
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="november">
            </fieldset>

            <fieldset class="form-group">
                <label for="for_user_allowance_id"></label>
                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="december">
            </fieldset>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-sm float-end" wire:click="saveDetailMonth()" {{ $disabledSave }}>
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
</div>
