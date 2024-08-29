<div class="card mt-3 small">

    {{--@include('layouts.bt4.partials.flash_message')--}}

    <div style="{{ $edit ? '' : 'display:none' }}">

        <div class="card-body">

            <div class="form-row">
                <fieldset class="form-group col-6">
                    <label>Descripción</label>
                    <input type="text" class="form-control" wire:model.live="description">
                </fieldset>

                <fieldset class="form-group col-3">
                    <label>Porcentaje</label>
                    <input type="number" class="form-control" wire:model.live="percentage">
                </fieldset>

                <fieldset class="form-group col-3">
                    <label>Valor</label>
                    <input type="number" class="form-control" wire:model.live="amount">
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-3">
                    <label>Fecha de transferencia</label>
                    <input type="date" class="form-control" wire:model.live="transfer_at">
                </fieldset>

                <fieldset class="form-group col-3">
                    <label>N° voucher</label>
                    <input type="text" class="form-control" wire:model.live="voucher_number">
                </fieldset>
            </div>
            
            <button type="button" class="btn btn-primary mt-1 mb-4" wire:click="save()">Guardar</button>
            <button type="button" class="btn btn-secondary mt-1 mb-4" wire:click="cancel()">Cancelar</button>

        </div>
        <hr>
    </div>

    <div class="card-body">
        <h5>Cuotas 
            <button class="btn btn-sm btn-outline-primary float-right" wire:click="edit()" >
                <i class="fas fa-plus"></i> Agregar nuevo
            </button>
        </h5>

        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Descripción</th>
                    <th>Porcentaje</th>
                    <th class="text-right">Monto $</th>
                    <th class="text-center">Fecha Transferencia</th>
                    <th>Comprobante</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($program->quotas_minsal as $key=>$quota)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{ $quota->description }}</td>
                    <td>{{ $quota->percentage }}{{ $quota->percentage ? '%' : '' }}</td>
                    <td class="text-right">@numero($quota->amount)</td>
                    <td class="text-center">{{ $quota->transfer_at ? $quota->transfer_at->format('d-m-Y') : '' }}</td>
                    <td>{{ $quota->voucher_number }}</td>
                    <td class="text-right">
                        <button class="btn btn-sm btn-outline-danger" wire:click="delete({{$quota}})">
                        <i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
