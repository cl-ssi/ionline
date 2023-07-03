<div>
    <form class="form-horizontal" wire:submit.prevent="submit">
    <div class="form-row">
        <fieldset class="form-group col-sm-2">
            <label for="year">Año</label>
            <select class="form-control selectpicker show-tick" id="for_year" name="year" wire:model.debounce.500ms="selectedYear" required>
                <option value="">Selección...</option>
                @foreach(range(now()->year, 2022) as $period)
                <option value="{{$period}}">{{$period}}</option>
                @endforeach
            </select>
            @error('selectedYear') <span class="error">{{ $message }}</span> @enderror
        </fieldset>
        <fieldset class="form-group col-sm-7">
            <label for="program">Programa</label>
            <select class="form-control selectpicker" id="for_program" name="program" data-live-search="true" data-actions-box="true" wire:model.debounce.500ms="selectedProgram" required>
                <option style="font-size:70%;" value="">Selección...</option>
                @foreach($programs as $program)
                <option style="font-size:70%;" value="{{ $program->id }}">{{ $program->alias_finance }} - Folio {{ $program->folio }} - Subtítulo {{$program->Subtitle->name}}</option>
                @endforeach
            </select>
            @error('selectedProgram') <span class="error">{{ $message }}</span> @enderror
        </fieldset>
    </div>
    <!-- <button type="submit" class="btn btn-primary float-right"><i class="fas fa-chart-pie"></i> Consultar</button> -->
    </form>

    <div wire:loading wire:target="selectedProgram">Cargando...</div>

    @if($requestForms)
    <div class="row" wire:loading.remove>
        <div class="col">
            <p class="font-weight-lighter">Total de Registros: <b>{{ $requestForms->count() }}</b></p>
        </div>
        <!-- <div class="col">
            <a class="btn btn-success btn-sm mb-1 float-right" wire:click="export"><i class="fas fa-file-excel"></i> Exportar formularios</a></h6>
        </div> -->
    </div>

    <div class="table-responsive" wire:loading.remove>
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
    @endif
</div>

@section('custom_js')
<script>

document.addEventListener("DOMContentLoaded", () => {
    Livewire.hook('message.received', (message, component) => {
        $('select').selectpicker('destroy');
    })
});

window.addEventListener('contentChanged', event => {
    $('select').selectpicker();
});

</script>
@endsection
