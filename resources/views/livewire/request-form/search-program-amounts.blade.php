<div>
    <form class="form-horizontal" wire:submit="submit">
        <div class="form-row">
            <fieldset class="form-group col-sm-6">
                <label for="year">Año</label>
                <select class="form-control" id="for_year" name="year" wire:model.live="selectedYear" required>
                    <option value="">Selección...</option>
                    @foreach(range(now()->year, 2022) as $period)
                    <option value="{{$period}}">{{$period}}</option>
                    @endforeach
                </select>
                @error('selectedYear') <span class="text-danger error small">{{ $message }}</span> @enderror
            </fieldset>

            <fieldset class="form-group col-6">
                <label for="for_program">Programa</label>
                @livewire('search-select-program',[
                        'emit_name' => 'searchedProgram',
                        'year'      => $selectedYear ?? null
                ])
                @error('selectedProgram') <span class="text-danger error small">{{ $message }}</span> @enderror
            </fieldset>
        </div>

        <div class="form-row float-right">
            <button 
                type="button"
                class="btn btn-primary"
                wire:click="search">
                <i class="fas fa-chart-pie"></i> Consultar
            </button>
        </div>
    </form>

    <!-- Mensaje de Cargando -->
    <div wire:loading wire:target="search">
        <p class="text-center">Cargando resultados...</p>
    </div>

    @if($requestForms)
    <div wire:loading.remove wire:target="search">
        <div class="row mt-5">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $requestForms->count() }}</b></p>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col">
                <h4>{{ $selectedProgram['name'] }}</h4>
                <h6>{{ $selectedProgram['period'] }}</h6>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover small">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Folio</th>
                        <th>Presupuesto solicitado</th>
                        <th>Montos totales por compras registradas</th>
                        <th>Montos totales por DTE pagadas</th>
                    </tr>
                </thead>
                <tbody>
                    @php($totalCompras = $totalDTEs = 0)
                    @forelse($requestForms as $requestForm)
                    <tr>
                        <td>{{ $requestForm->id }} <br>
                            @switch($requestForm->getStatus())
                                @case('Pendiente')
                                    <i class="fas fa-clock"></i>
                                @break

                                @case('Aprobado')
                                    <span style="color: green;">
                                    <i class="fas fa-check-circle" title="{{ $requestForm->getStatus() }}"></i>
                                    </span>
                                    @if($requestForm->purchasingProcess)
                                        <span class="badge badge-{{$requestForm->purchasingProcess->getColor()}}">{{$requestForm->purchasingProcess->getStatus()}}</span>
                                    @else
                                        <span class="badge badge-warning">En proceso</span>
                                    @endif
                                @break
                                @case('Rechazado')
                                    <a href="">
                                        <span style="color: Tomato;">
                                            <i class="fas fa-times-circle" title="{{ $requestForm->getStatus() }}"></i>
                                        </span>
                                    </a>
                                @break
                            @endswitch
                        </td>
                        <td>
                            <a href="{{ route('request_forms.show', $requestForm->id) }}" target="_blank">{{ $requestForm->folio }}</a>
                                @if($requestForm->father)
                                <br>(<a href="{{ route('request_forms.show', $requestForm->father->id) }}" target="_blank">{{ $requestForm->father->folio }}</a>)
                                @endif
                        </td>
                        <td class="text-right">
                            {{ $requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}
                        </td>
                        <td class="text-right">
                            @if($requestForm->purchasingProcess && ($requestForm->purchasingProcess->details->count() > 0 || $requestForm->purchasingProcess->detailsPassenger->count() > 0))
                            {{ $requestForm->symbol_currency}}{{ number_format($requestForm->purchasingProcess->getExpense(), $requestForm->precision_currency,",",".") }}
                            @php($totalCompras += $requestForm->purchasingProcess->getExpense())
                            @endif
                        </td>
                        <td class="text-right">
                            @if($requestForm->immediatePurchases->count() > 0)
                            {{ $requestForm->symbol_currency}}{{ number_format($requestForm->getTotalDtes(), $requestForm->precision_currency,",",".") }}
                            @php($totalDTEs += $requestForm->getTotalDtes())
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No se han registrado formularios aprobados</td>
                    </tr>
                    @endforelse
                </tbody>
                @if($requestForms && $requestForms->count() > 0)
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">Totales</th>
                        <th class="text-right">${{ number_format($requestForms->sum('estimated_expense'),0,",",".") }}</th>
                        <th class="text-right">${{ number_format($totalCompras,0,",",".") }}</th>
                        <th class="text-right">${{ number_format($totalDTEs,0,",",".") }}</th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
    @endif
</div>

@section('custom_js')

@endsection
