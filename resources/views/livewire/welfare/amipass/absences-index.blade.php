<div>
<div class="row">
        <div class="col">
            <h3 class="mb-3">Ausentismos</h3>
        </div>
        <!-- <div class="col-3 text-right">
            <a href="{{ route('rrhh.attendance.reason.mgr') }}" class="btn btn-info"> <i class="fas fa-cog"></i> Mantenedor de Motivos </a>
        </div> -->
    </div>
    @if($records->count() > 0)
</div>
    <table class="table table-sm table-bordered table-hover">
        <thead>
            <tr>
                <th width="95px" scope="col">Rut</th>
                <th scope="col">Funcionario</th>
                <th scope="col">Ley</th>
                <th scope="col">Nombre unidad</th>
                <th scope="col">Mes ausentismo</th>
                <th scope="col">Fecha inicio ausentismo</th>
                <th scope="col">Fecha termino ausentismo</th>
                <th scope="col">Fecha termino ausentismo al 30-08-2023</th>
                <th scope="col">Ausentismo calculado al 30-08-2023</th>
                <th scope="col">Total días ausentismo</th>
                <th scope="col">Ausentismo en el periodo</th>
                <th scope="col">Tipo de ausentismo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
            <tr>
                <td>{{ $record->rut }}-{{ $record->dv }}</td>
                <td>{{ $record->nombre }}</td>
                <td>{{ $record->ley }}</td>
                <td>{{ $record->nombre_unidad }}</td>
                <td>{{ $record->mes_ausentismo }}</td>
                <td>{{ $record->fecha_inicio->format('d-m-Y') }}</td>
                <td>{{ $record->fecha_termino->format('d-m-Y') }}</td>
                <td>{{ $record->fecha_termino_2->format('d-m-Y') }}</td>
                <td>{{ $record->ausentismo_calculado ?? '-' }}</td>
                <td>{{ $record->total_dias_ausentismo ?? '-' }}</td>
                <td>{{ $record->ausentismos_en_periodo ?? '-' }}</td>
                <td>{{ $record->tipo_ausentismo }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="12" class="text-center">No presenta registros de ausentismos al 30-08-2023</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $records->links() }}
    @else
    <fieldset>No presenta registros de ausentismos al 30-08-2023</fieldset>
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
