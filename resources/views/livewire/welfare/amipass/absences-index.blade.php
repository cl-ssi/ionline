<div>
    <div class="row">
        <div class="group col-3">
            <label for="text11">Año</label>
            <select class="form-control" wire:model.live="year" id="">
                <option value=""></option>
                <option value="2023" >2023</option>
                <option value="2024" >2024</option>
                <option value="2025" >2025</option>
            </select>
        </div>
    </div><hr>

    @if($year == 2023)
        @if($records->count() > 0)
        <table class="table table-sm table-bordered table-hover" style="font-size: 12px;">
            <thead>
                <tr>
                    <!-- <th width="95px" scope="col">Rut</th> -->
                    <!-- <th scope="col">Funcionario</th> -->
                    <th scope="col">Ley</th>
                    <th scope="col">Nombre unidad</th>
                    <th scope="col">Mes ausentismo</th>
                    <th scope="col">Fecha inicio ausentismo</th>
                    <th scope="col">Fecha termino ausentismo</th>
                    <th scope="col">Fecha termino ausentismo al 30-09-2023</th>
                    <th scope="col">Ausentismo calculado al 30-09-2023</th>
                    <th scope="col">Total días ausentismo</th>
                    <th scope="col">Ausentismo en el periodo</th>
                    <th scope="col">Tipo de ausentismo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <!-- <td>{{ $record->rut }}-{{ $record->dv }}</td> -->
                    <!-- <td>{{ $record->nombre }}</td> -->
                    <td>{{ $record->ley }}</td>
                    <td>{{ $record->nombre_unidad }}</td>
                    <td class="text-center">{{ $record->mes_ausentismo }}</td>
                    <td>{{ $record->fecha_inicio->format('d-m-Y') }}</td>
                    <td>{{ $record->fecha_termino->format('d-m-Y') }}</td>
                    <td>{{ $record->fecha_termino_2->format('d-m-Y') }}</td>
                    <td class="text-center">{{ $record->ausentismo_calculado ?? '-' }}</td>
                    <td class="text-center">{{ $record->total_dias_ausentismo ?? '-' }}</td>
                    <td class="text-center">{{ $record->ausentismos_en_periodo ?? '-' }}</td>
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

    @else
        @if($records->count() > 0)
        <table class="table table-sm table-bordered table-hover" style="font-size: 12px;">
            <thead>
                <tr>
                    <!-- <th width="95px" scope="col">Rut</th> -->
                    <!-- <th scope="col">Funcionario</th> -->
                    <th scope="col">Ley</th>
                    <th scope="col">Nombre unidad</th>
                    <th scope="col">Mes ausentismo</th>
                    <th scope="col">Fecha inicio ausentismo</th>
                    <th scope="col">Fecha termino ausentismo</th>
                    <th scope="col">Total días ausentismo</th>
                    <th scope="col">Ausentismo en el periodo</th>
                    <th scope="col">Tipo de ausentismo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <!-- <td>{{ $record->rut }}-{{ $record->dv }}</td> -->
                    <!-- <td>{{ $record->nombre }}</td> -->
                    <td>{{ $record->ley }}</td>
                    <td>{{ $record->nombre_unidad }}</td>
                    <td class="text-center">{{ $record->finicio->format('m') }}</td>
                    <td>{{ $record->finicio->format('d-m-Y') }}</td>
                    <td>{{ $record->ftermino->format('d-m-Y') }}</td>
                    <td class="text-center">{{ $record->total_dias_ausentismo ?? '-' }}</td>
                    <td class="text-center">{{ $record->ausentismos_en_el_periodo ?? '-' }}</td>
                    <td>{{ $record->tipo_de_ausentismo }}</td>
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
        <fieldset>No presenta registros de ausentismos</fieldset>
        @endif
    @endif
</div>
