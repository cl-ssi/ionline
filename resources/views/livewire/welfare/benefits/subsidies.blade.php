<div>
    @include('welfare.nav')

    <h4>
        Subsidios <button wire:click="showCreateForm" class="btn btn-primary btn-sm ml-2">Crear</button>
    </h4>

    @if($showCreate)
    <div class="row mt-3 showCreate">
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
                @error('newSubsidyName') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="value">Descripción:</label>
                <input wire:model="description" type="text" class="form-control" id="description">
                @error('description') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="value">Tope anual:</label>
                <input wire:model="annual_cap" type="number" class="form-control" id="annual_cap">
                @error('annual_cap') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="recipient">Beneficiario:</label>
                <input wire:model="recipient" type="text" class="form-control" id="recipient">
                @error('recipient') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
            <br>    
        </div>

        <h4>Documentos</h4>

        <div class="col-md-12">
        <table class="table table-bordered table-sm" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Subsidio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if($documents)
                    @foreach($documents as $document)
                        <tr>
                            <td>{{ $document->id }}</td>
                            <td>{{ $document->name }}</td>
                            <td>
                                <!-- Botón para eliminar -->
                                <button wire:click="deleteDocument({{ $document->id }})" class="btn btn-danger btn-sm">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        </div>

        <br>

        <div class="col-md-6">
        <div wire:loading wire:target="saveSubsidy">
                <i class="fas fa-spinner fa-spin"></i> Guardando...
        </div>
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
                <th>Descripción</th>
                <th>Tope anual</th>
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
                    <td>{{ $subsidy->description }}</td>
                    <td>{{ $subsidy->annual_cap }}</td>
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