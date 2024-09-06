<div>

    @section('title', 'Lista de Cuentas Contables')

    @include('inventory.nav', [
        'establishment' => auth()->user()->organizationalUnit->establishment
    ])


    @if ($formActive)
        <h3>{{ $accountingCode->id ? 'Editar' : 'Crear' }} Cuenta contable</h3>

        <div class="row g-2">
            <fieldset class="col-12 col-md-2">
                <label for="for-id">Código*</label>
                <input type="text" wire:model="accountingCode.id" class="form-control">
                @error('accountingCode.id') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>

            <fieldset class="col-12 col-md-4">
                <label for="for-date">Descripción*</label>
                <input type="text" wire:model="accountingCode.description" class="form-control">
                @error('accountingCode.description') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>
        </div>

        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="button" class="btn btn-success" wire:click="save()">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col">
                <h3 class="mb-3">Listado de Cuentas Contables</h3>
            </div>
            <div class="col text-end">
                <button class="btn btn-success text-end" wire:click="showForm()">
                    <i class="bi bi-plus-circle"></i> Nueva Cuenta Contable
                </button>
            </div>
        </div>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th width="50px">Editar</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th width="50px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($accountingCodes as $accountingCode)
                    <tr>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                wire:click="showForm({{$accountingCode}})">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </td>
                        <td>{{ $accountingCode->id }}</td>
                        <td>{{ $accountingCode->description }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="confirm('¿Está seguro que desea borrar la cuenta contable {{ $accountingCode->description }}?') || event.stopImmediatePropagation()"
                                wire:click="delete({{$accountingCode}})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $accountingCodes->links() }}
    @endif

</div>
