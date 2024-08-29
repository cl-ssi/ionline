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
                        <button type="button" class="btn btn-sm btn-success" wire:click="showForm" {{$requestForm->father?'disabled':''}} title="Solamente pueden agregar documentos los formularios padre"> <i
                                class="fas fa-plus"></i>
                        </button>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Boleta o Factura</td>
                <td></td>
                <td></td>
            </tr>
            @if ($requestForm->father)
                {{-- El RequestForm es hijo  Asi que solo debe ver y recorrer en el foreach del padre --}}
                @foreach ($requestForm->father->paymentDocs as $doc)
                    <tr>
                        <td>{{ $doc->name }}</td>
                        <td>{{ $doc->description }}</td>
                        <td class="text-right">
                        <button type="button" class="btn btn-sm btn-danger" disabled title="En caso de querer eliminar un documento ir al formulario padre">
                        <i class="fas fa-trash"></i>
                        </button>
                        </td>
                    </tr>
                @endforeach
            @else
                {{-- El RequestForm es padre  Asi que tiene todos los privilegios --}}
                @foreach ($requestForm->paymentDocs as $doc)
                    <tr>
                        <td>{{ $doc->name }}</td>
                        <td>{{ $doc->description }}</td>
                        <td class="text-right">
                            <button type="button" class="btn btn-sm btn-danger"
                                wire:click="delete({{ $doc->id }})" {{$requestForm->father?'disabled':''}}>
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach


            @endif




            @if ($form)
                <tr>
                    <td>
                        <input type="text" class="form-control" wire:model.live="name">
                    </td>
                    <td>
                        <input type="text" class="form-control" wire:model.live="description">
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
