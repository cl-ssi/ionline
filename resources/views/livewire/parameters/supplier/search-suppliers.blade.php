<div>
    <div class="card card-body small">
        <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>
        <div class="form-row">
            <fieldset class="form-group col-12 col-md-3">
                <label for="for_name">Nombres / Identificación</label>
                <input class="form-control" type="text" name="name_search" autocomplete="off" style="text-transform: uppercase;"
                    placeholder="RUN (sin DV) / NOMBRE" wire:model.live.debounce.500ms="selectedName">
            </fieldset>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p class="font-weight-lighter">Total de Registros: <b>{{ $suppliers->total() }}</b></p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered small">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Nombre</th>
                    <th width="9%">Run</th>
                    <th>Dirección</th>
                    <th>Región</th>
                    <th>Comuna</th>
                    <th>Teléfono</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $key => $supplier)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ number_format($supplier->run, 0, ",", ".") }}-{{ $supplier->dv }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>{{ $supplier->region->name ?? '' }}</td>
                    <td>{{ $supplier->commune->name ?? '' }}</td>
                    <td>{{ $supplier->telephone }}</td>
                    <td>
                        <a href="{{ route('parameters.suppliers.edit', $supplier) }}" class="btn btn-outline-secondary btn-sm" >
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $suppliers->links() }}
    <div>
</div>
