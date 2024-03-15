<div>
    @include('welfare.nav')

    <h4>
        Subsidios <button wire:click="showCreateForm" class="btn btn-primary btn-sm ml-2">Crear</button>
    </h4>

    @if($showCreate)
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="selectedBenefitId">Beneficio:</label>
                <select wire:model="selectedBenefitId" class="form-control" id="selectedBenefitId">
                    <option value="">Seleccionar Beneficio</option>
                    @foreach($benefits as $benefit)
                        <option value="{{ $benefit->id }}">{{ $benefit->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="newSubsidyName">Nombre del Subsidio:</label>
                <input wire:model="newSubsidyName" type="text" class="form-control" id="newSubsidyName">
            </div>
            <div class="form-group">
                <label for="percentage">Porcentaje:</label>
                <input wire:model="percentage" type="text" class="form-control" id="percentage">
            </div>
            <div class="form-group">
                <label for="type">Tipo:</label>
                <input wire:model="type" type="text" class="form-control" id="type">
            </div>
            <div class="form-group">
                <label for="value">Valor:</label>
                <input wire:model="value" type="text" class="form-control" id="value">
            </div>
            <div class="form-group">
                <label for="recipient">Beneficiario:</label>
                <input wire:model="recipient" type="text" class="form-control" id="recipient">
            </div>
            <br>    
            <button wire:click="saveSubsidy" class="btn btn-success">Guardar</button>
        </div>
    </div>
    <br>
    @endif

    <table class="table table-bordered table-sm" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>Id</th>
                <th>Subsidio</th>
                <th>Beneficio</th>
                <th>Porcentaje</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Beneficiario</th>
                <th>Docu/Reqs</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subsidies as $subsidy)
                <tr>
                    <td>{{ $subsidy->id }}</td>
                    <td>{{ $subsidy->name }}</td>
                    <td>{{ $subsidy->benefit->name }}</td>
                    <td>{{ $subsidy->percentage }}</td>
                    <td>{{ $subsidy->type }}</td>
                    <td>{{ $subsidy->value }}</td>
                    <td>{{ $subsidy->recipient }}</td>
                    <td>{{ $subsidy->documents->count() }}</td>
                    <td>
                        <!-- Botón para editar -->
                        <button wire:click="editSubsidy({{ $subsidy->id }})" class="btn btn-primary btn-sm">Editar</button>
                        <!-- Botón para eliminar -->
                        <button wire:click="deleteSubsidy({{ $subsidy->id }})" class="btn btn-danger btn-sm">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>