<div class="mt-3 mb-3">
    <h6>
        <i class="fas fa-fw fa-receipt"></i> Documentos necesarios para pago
    </h6>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th class="text-right">
                    <button type="button" class="btn btn-sm btn-success" wire:click="showForm"> <i class="fas fa-plus"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requestForm->paymentDocs as $doc)
                <tr>
                    <td>{{ $doc->name }}</td>
                    <td>{{ $doc->description }}</td>
                    <td class="text-right">
                        <button type="button" class="btn btn-sm btn-danger" wire:click="delete({{ $doc->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach

            @if ($form)
                <tr>
                    <td>
                        <input type="text" class="form-control" wire:model="name">
                    </td>
                    <td>
                        <input type="text" class="form-control" wire:model="description">
                    </td>
                    <td class="text-right">
                        <button type="button" class="btn btn-sm btn-primary" wire:click="save">
                            <i class="fas fa-save"></i>
                        </button>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
