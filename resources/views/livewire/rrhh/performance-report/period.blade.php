<div>
    @include('rrhh.performance_report.partials.nav')

    <h3 class="mb-3 mt-3">Periodos Informe de Desempeño</h3>
    
    <button type="button" class="btn btn-primary mb-3" wire:click="$toggle('showForm')">Crear Periodo</button>    
    @if($showForm)
        <form wire:submit="createPeriod">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="start_at" class="form-label">Mes de inicio</label>
                    <input type="month" class="form-control" id="start_at" wire:model.live="start_at" required autocomplete="off">
                    @error('start_at') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3">
                    <label for="end_at" class="form-label">Mes de término</label>
                    <input type="month" class="form-control" id="end_at" wire:model.live="end_at" required autocomplete="off">
                    @error('end_at') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3">
                    <label for="year" class="form-label">Año de Calificacion</label>
                    <select class="form-select" id="year" wire:model.live="year" required autocomplete="off">
                        @for ($i = now()->year; $i >= 2024; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                        <button type="submit" class="btn btn-primary me-2">Crear Periodo</button>
                        <button type="button" class="btn btn-secondary" wire:click="$toggle('showForm')">Cancelar</button>
                </div>
            </div>
        </form>
    @endif

    @if($showSuccessMessage)
        <div class="alert alert-success" role="alert">
            ¡El periodo se ha creado exitosamente!
        </div>
    @endif
    
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha de inicio</th>
                <th>Fecha de término</th>
                <th>Año</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($periods as $period)
            <tr>
                <td>{{ $period->name }}</td>
                <td>{{ $period->start_at?->format('d-m-Y') }}</td>
                <td>{{ $period->end_at?->format('d-m-Y') }}</td>
                <td>{{ $period->year }}</td>
                <td>
                    <button class="btn btn-sm btn-danger" wire:click="deletePeriod({{ $period->id }})">
                        <i class="fas fa-trash"></i> <!-- Icono de FontAwesome para eliminar -->
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>