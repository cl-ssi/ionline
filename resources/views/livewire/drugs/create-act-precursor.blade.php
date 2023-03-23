<div>
    @section('title', 'Crear Acta de Precursores')

    @include('drugs.nav')

    <div class="row">
        <div class="col">
            <h3 class="mb-3">Crear Acta de Precursores</h3>
        </div>
        <div class="col text-right">
            <a href="{{ route('drugs.precursors') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
        </div>
    </div>

    @include('layouts.partials.flash_message')

    <div class="form-row">
        <fieldset class="form-group col-3">
            <label for="act-date">Fecha Acta</label>
            <input
                type="date"
                class="form-control @error('date') is-invalid @enderror"
                id="act-date"
                wire:model.defer="date"
                autocomplete="off"
            >
            @error('date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-4">
            <label for="run-receiving">RUN Persona Recibe</label>
            <input
                type="text"
                class="form-control @error('run_receiving') is-invalid @enderror"
                id="run-receiving"
                wire:model.defer="run_receiving"
                autocomplete="off"
            >
            @error('run_receiving')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="act-receiving">Nombre Persona Recibe</label>
            <input
                type="text"
                class="form-control @error('full_name_receiving') is-invalid @enderror"
                id="act-receiving"
                wire:model.defer="full_name_receiving"
                autocomplete="off"
            >
            @error('full_name_receiving')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="act-delivery">Persona Entrega</label>
            <input
                type="text"
                class="form-control"
                id="act-delivery"
                value="{{ $manager_name }}"
                disabled
                readonly
            >
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12">
            <label for="note">Notas</label>
            <input
                type="text"
                class="form-control @error('note') is-invalid @enderror"
                id="note"
                wire:model.defer="note"
                autocomplete="off"
            >
            @error('note')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="form-row">
        Seleccione precursores
        <br>

        <input type="hidden" class="@error('selected_precursors') is-invalid @enderror">
        @error('selected_precursors')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Acta</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th class="text-right" width="180px">Peso Neto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($precursors as $precursor)
                <tr>
                    <th class="text-center">
                        <div
                            class="form-check"
                        >
                            <input
                                class="form-check-input"
                                type="checkbox"
                                wire:model.debounce.1500ms="selected_precursors"
                                value={{ $precursor->id }}
                                id="option-{{ $precursor->id }}"
                            >
                            {{ $precursor->id }}
                        </div>
                    </th>
                    <td>{{ $precursor->reception->id }}</td>
                    <td>{{ $precursor->substance->name }}</td>
                    <td>{{ $precursor->description }}</td>
                    <td class="text-right">{{ money($precursor->net_weight)}} {{ $precursor->substance->unit }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">
                        No hay registros
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="form-row">
        <button class="btn btn-primary" wire:click="saveActPrecursor">
            Guardar
        </button>
    </div>
</div>
