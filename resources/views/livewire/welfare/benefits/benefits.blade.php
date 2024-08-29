<div>
    @include('welfare.nav')

    <h4>
        Categorías <button wire:click="showCreateForm" class="btn btn-primary btn-sm ml-2">Crear</button>
    </h4>

    @if($showCreate)
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="newBenefitName">Nombre de la categoría:</label>
                <input wire:model.live="newBenefitName" type="text" class="form-select" id="newBenefitName">
            </div>
            <div class="form-group">
                <label for="newBenefitObservations">Observaciones:</label>
                <textarea wire:model.live="newBenefitObservations" class="form-select" id="newBenefitObservations"></textarea>
            </div>
            <button wire:click="saveBenefit" class="btn btn-success">Guardar</button>
        </div>
    </div>
    <br>
    @endif

    <table class="table table-bordered table-sm" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($benefits as $benefit)
                <tr>
                    <td>{{ $benefit->id }}</td>
                    <td>{{ $benefit->name }}</td>
                    <td>{{ substr($benefit->observation, 0, 50) }}</td>
                    <td>
                    <!-- Botón para editar -->
                    <button wire:click="editBenefit({{ $benefit->id }})" class="btn btn-primary btn-sm">Editar</button>
                    <!-- Botón para eliminar -->
                    <!-- <button wire:click="deleteBenefit({{ $benefit->id }})" class="btn btn-danger btn-sm">Eliminar</button> -->
                    <button onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?') || event.stopImmediatePropagation()" wire:click="deleteBenefit({{ $benefit->id }})" class="btn btn-danger btn-sm">Eliminar</button>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
