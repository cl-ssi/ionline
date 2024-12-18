<div>
    <div class="card card-body small">
        <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>
        
        <div class="form-row">
            <fieldset class="form-group col-sm">
                <label for="regiones">Fecha de comienzo de Viático</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date_search" wire:model.live.debounce.500ms="selectedStartDate" required>
                    <input type="date" class="form-control" name="end_date_search" wire:model.live.debounce.500ms="selectedEndDate" required>
                </div>
            </fieldset>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-12 col-md-6">
            <p class="font-weight-lighter">Total de Registros: <b>{{ $allowances->total() }}</b></p>
        </div>
        <div class="col-12 col-md-6">
            <a class="btn btn-success btn-sm float-right @if($allowances->count() <= 0) disabled @endif"
                href="{{ route('allowances.reports.create_by_dates_excel', ['from' => $selectedStartDate, 'to' => $selectedEndDate]) }}">
                <i class="fas fa-file-excel"></i> Exportar
            </a>
        </div>
    </div>

    @if($allowances->count() > 0)
    
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead class="text-center small">
                    <tr>
                        <th>N°</th>
                        <th>Mes (Creación)</th>
                        <th style="width: 8%">Fecha</th>
                        <th>Nombre</th>
                        <th>Unidad organizacional</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Cantidad de días</th>
                        <th>Valor día</th>
                        <th>Valor medio día</th>
                        <th>Valor total</th>
                        <th>Lugar</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @foreach($allowances as $allowance)
                    <tr>
                        <td>
                            {{ ($allowance->correlative) ? $allowance->correlative : $allowance->id }}<br>
                            <span class="badge badge-{{ $allowance->StatusColor }}">{{ $allowance->StatusValue }}</span>
                        </td>
                        <td class="text-center">{{ $allowance->created_at->monthName }}</td>
                        <td class="text-center" style="width: 7%">{{ $allowance->created_at->format('d-m-Y') }}</td>
                        <td>{{ $allowance->userAllowance->fullName }}</td>
                        <td>
                            {{ $allowance->organizationalUnitAllowance->name }} <br><br>
                            <small><b>{{ $allowance->organizationalUnitAllowance->establishment->name }}</b></small>
                        </td>
                        <td class="text-center" style="width: 7%">{{ ($allowance->from) ? $allowance->from->format('d-m-Y') : '' }}</td>
                        <td class="text-center" style="width: 7%">{{ $allowance->to->format('d-m-Y') }}</td>
                        <td class="text-center">{{ number_format($allowance->total_days, 1, ",", ".") }}</td>
                        <td class="text-right">${{ ($allowance->total_days >= 1) ? number_format(($allowance->day_value * intval($allowance->total_days)), 0, ",", ".") : '0' }}</td>
                        <td class="text-right">${{ number_format($allowance->half_day_value, 0, ",", ".") }}</td>
                        <td class="text-right">${{ number_format($allowance->total_value, 0, ",", ".") }}</td>
                        <td>{{ $allowance->place }}</td>
                        <td>{{ $allowance->reason }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $allowances->links() }}
        </div>

    @else

        <div class="alert alert-info" role="alert">
            <b>Estimado usuario</b>: No se encuentran viáticos bajo los parámetros consultados.
        </div>

    @endif

    </div>
</div>
