<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <form class="form-horizontal" wire:submit.prevent="submit">
        <div class="form-row">
            <fieldset class="form-group col-sm-4">
                <label for="year">Año</label>
                <select class="form-control" id="for_year" name="year" wire:model.debounce.500ms="selectedYear"
                    required>
                    <option value="">Selección...</option>
                    @foreach (range(now()->year, 2022) as $period)
                        <option value="{{ $period }}">{{ $period }}</option>
                    @endforeach
                </select>
                @error('selectedYear')
                    <span class="error">{{ $message }}</span>
                @enderror
            </fieldset>
        </div>

        <div wire:loading wire:target="selectedYear">Cargando...</div>

        @if ($programs)
            <div class="row" wire:loading.remove>
                <div class="col">
                    <p class="font-weight-lighter">Total de Registros: <b>{{ $programs->count() }}</b></p>
                </div>
            </div>
        @endif



        <div class="table-responsive" wire:loading.remove>
            <table class="table table-sm table-bordered table-striped table-hover small">
                <thead>
                    <tr class="text-center">
                        <th>Nombre</th>
                        <th>Presupuesto</th>
                        <th>Presupuesto solicitado</th>
                        <th>Montos totales por compras registradas</th>
                        <th>Montos totales por DTE pagadas</th>
                    </tr>
                </thead>
                <tfoot>
                    @foreach ($programs as $program)
                        <tr>
                            <th>{{ $program->name  }} - Folio Sigfe {{ $program->folio  }} - Subtítulo {{$program->Subtitle->name}}</th>
                            <td>${{ money($program->totalBudgets) }}</td>
                            <td>${{ money($program->total_expense) }}</td>
                            <td>${{ money($program->totalCompras)}}</td>
                            <td>${{ money($program->totalDtes) }}</td>
                            
                        </tr>
                    @endforeach
                </tfoot>
            </table>
        </div>

    </form>
</div>
