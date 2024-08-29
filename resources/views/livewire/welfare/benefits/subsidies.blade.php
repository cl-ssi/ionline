<div>
    @include('welfare.nav')

    <h4>
        Beneficios <button wire:click="showCreateForm" class="btn btn-primary btn-sm ml-2">Crear</button>
    </h4>

    @if($showCreate)
    <div class="row mt-3 showCreate">
        <div class="col-md-6">
            <div class="form-group">
                <label for="selectedBenefitId">Categoría:</label>
                <select wire:model.live="selectedBenefitId" class="form-select" id="selectedBenefitId">
                    <option value="">Seleccionar categoría</option>
                    @foreach($benefits as $benefit)
                        <option value="{{ $benefit->id }}">{{ $benefit->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="newSubsidyName">Nombre del Subsidio:</label>
                <input wire:model.live="newSubsidyName" type="text" class="form-control" id="newSubsidyName">
                @error('newSubsidyName') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="value">Descripción:</label>
                <!-- <input wire:model.live="description" type="text" class="form-control" id="description"> -->
                <textarea wire:model.live="description" id="description" class="form-control" cols="30" rows="5"></textarea>
                @error('description') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="value">Tope anual:</label>
                        <input wire:model.live="annual_cap" type="number" class="form-control" id="annual_cap">
                        @error('annual_cap') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="value">Tipo de pago:</label>
                        <select wire:model.live="payment_in_installments" class="form-select" id="payment_in_installments" required>
                            <option value="1">Con cuotas</option>
                            <option value="0">Sin cuotas</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="recipient">Beneficiario:</label>
                        <input wire:model.live="recipient" type="text" class="form-control" id="recipient">
                        @error('recipient') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="value">Estado:</label>
                        <select wire:model.live="status" class="form-select" id="status" required>
                            <option value="1">Activo</option>
                            <option value="0">Desactivado</option>
                        </select>
                    </div>
                </div>
            </div>  
        </div>

        <!-- Botón "Crear" -->
        <br>
        <h4>
            Documentos <button wire:click="showCreateDocumentForm" class="btn btn-primary btn-sm">Crear</button>
        </h4>

        <!-- Formulario de creación de documento -->
        @if($showCreateDocumentForm)
            <div class="row mt-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="newDocumentName">Nombre del Documento:</label>
                        <input wire:model.live="newDocumentName" type="text" class="form-control" id="newDocumentName">
                        @error('newDocumentName') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="newDocumentName"><br></label>
                    <!-- Botón "Guardar" -->
                    <button wire:click="saveDocument" class="btn btn-success form-control">Guardar</button>
                </div>
            </div>
        @endif

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
                <th>Beneficio</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Tope anual</th>
                <th>Tipo de pago</th>
                <th>Beneficiario</th>
                <th>Docu/Reqs</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subsidies as $subsidy)
                @if($subsidy->status)<tr>
                @else <tr class="table-danger"> @endif
                    <td>{{ $subsidy->id }}</td>
                    <td>{{ $subsidy->name }}</td>
                    <td>@if($subsidy->benefit) {{ $subsidy->benefit->name }} @endif</td>
                    <td>{{ $subsidy->description }}</td>
                    <td>{{ $subsidy->annual_cap }}</td>
                    <td>
                        @if($subsidy->payment_in_installments == 1) Con cuotas @else Sin cuotas @endif
                    </td>
                    <td>{{ $subsidy->recipient }}</td>
                    <td>{{ $subsidy->documents->count() }}</td>
                    <td>
                        <!-- Botón para editar -->
                        <button wire:click="editSubsidy({{ $subsidy->id }})" class="btn btn-primary btn-sm">Editar</button>
                        <!-- Botón para eliminar -->
                        <!-- <button wire:click="deleteSubsidy({{ $subsidy->id }})" class="btn btn-danger btn-sm">Eliminar</button> -->
                        <button onclick="return confirm('¿Estás seguro de que deseas eliminar este beneficio?') || event.stopImmediatePropagation()" wire:click="deleteSubsidy({{ $subsidy->id }})" class="btn btn-danger btn-sm">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>