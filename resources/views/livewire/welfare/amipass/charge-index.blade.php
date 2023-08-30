<div>
    @if($records->count() > 0)
    <table class="table table-sm table-bordered table-hover" style="font-size: 12px;">
        <thead>
            <tr>
                <th width="95px" scope="col">Rut</th>
                <th scope="col">Funcionario</th>
                <th scope="col">Lugar desempeño</th>
                <th scope="col">Fecha registro</th>
                <th scope="col">Total real cargado</th>
                <th scope="col">Días de ausentismos</th>
                <th scope="col">Días hábiles del mes</th>
                <th scope="col">Días a cargar</th>
                <th scope="col">Valor día</th>
                <th scope="col">Valor que debía cargarse</th>
                <th scope="col">Diferencia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
            <tr>
                <td>{{ $record->rut }}-{{ $record->dv }}</td>
                <td>{{ $record->nombre }}</td>
                <td>{{ $record->lugar_desempeño }}</td>
                <td>{{ Str::after($record->fecha, '-') }}</td>
                <td class="text-right">{{ number_format($record->total_real_cargado, 0, ",", ".") ?? '-' }}</td>
                <td class="text-right">{{ $record->dias_ausentismo ?? '-' }}</td>
                <td class="text-right">{{ $record->dias_habiles_mes ?? '-' }}</td>
                <td class="text-right">{{ $record->dias_a_cargar ?? '-' }}</td>
                <td class="text-right">{{ number_format($record->valor_dia, 0, ",", ".") ?? '-' }}</td>
                <td class="text-right">{{ number_format($record->valor_debia_cargarse, 0, ",", ".") ?? '-' }}</td>
                <td class="{{$record->diferencia_color}} text-right">{{ number_format($record->diferencia, 0, ",", ".") ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="12" class="text-center">No presenta registros de cargas efectivas en Amipass</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="font-weight-bold text-right">
                <td colspan="4" class="text-right">Totales $</td>
                <td>{{number_format($records->sum('total_real_cargado'), 0, ",", ".")}}</td>
                <td>{{$records->sum('dias_ausentismo')}}</td>
                <td>{{$records->sum('dias_habiles_mes')}}</td>
                <td>{{$records->sum('dias_a_cargar')}}</td>
                <td></td>
                <td>{{number_format($records->sum('valor_debia_cargarse'), 0, ",", ".")}}</td>
                <td class="{{ $records->sum('diferencia') > 0 ? 'text-success' : 'text-danger' }}">{{number_format($records->sum('diferencia'), 0, ",", ".")}}</td>
            </tr>
        </tfoot>
    </table>
    {{ $records->links() }}

    <div class="alert alert-info" role="alert">
        A la fecha presenta un saldo {{$records->sum('diferencia') > 0 ? 'a favor' : 'en contra' }} de ${{number_format(abs($records->sum('diferencia')), 0, ",", ".")}} entre todas las cargas autorizadas el cual será regularizada en la(s) próxima(s) carga(s) programada(s).
    </div>
    @else
    <fieldset>No presenta registros de cargas efectivas en Amipass</fieldset>
    @endif
    
    {{--
    @if($record->rrhh_at)
                            {{ $record->rrhh_at }}
                        @elseif($record->status === 1)
                            <button type="button" class="btn btn-sm btn-success" wire:click="setOk({{$record}})">
                                <i class="fas fa-check"></i> 
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" wire:click="reject({{$record}})">
                                <i class="fas fa-ban"></i>
                            </button>
                        @endif
                        --}}
</div>
