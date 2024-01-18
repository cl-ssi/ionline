<div>
    @if($purchasePlans->count() > 0)
        @if($index == 'report: ppl-items')
        <div class="row">
            <div class="col">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $purchasePlans->total() }}</b></p>
            </div>
            {{--<div class="col">
                <a class="btn btn-success btn-sm mb-1 float-right" onclick="tableExcel('reporte_plan_compras_{{Carbon\Carbon::now()}}')"><i class="fas fa-file-excel"></i> Exportar formularios</a></h6>
            </div>--}}
        </div>
        <div class="table-responsive">
            <table id="contenedor" class="table table-bordered table-sm small">
                <thead>
                    <tr class="text-center align-top table-secondary">
                        <th rowspan="2">ID</th>
                        <th rowspan="2">Fecha Creación</th>
                        <th rowspan="2">Periodo</th>
                        <th rowspan="2">Asunto</th>
                        <th rowspan="2">Descripción</th>
                        <th rowspan="2">Propósito</th>
                        <th rowspan="2">Responsable</th>
                        <th rowspan="2">Cargo</th>
                        <th rowspan="2">Teléfono</th>
                        <th rowspan="2">Correo electrónico</th>
                        <th rowspan="2">Unidad Organizacional</th>
                        <th rowspan="2">Creado por</th>
                        <th rowspan="2">Programa</th>
                        <th rowspan="2">Items</th>
                        <th rowspan="2">Presupuesto</th>
                        <th rowspan="2">Estado</th>
                        <!-- ITEMS -->
                        <th rowspan="2">N° Item</th>
                        <th rowspan="2">ID</th>
                        <!-- <th rowspan="2">Item Presupuestario</th> -->
                        <th rowspan="2">Artículo</th>
                        <th rowspan="2">UM</th>
                        <th rowspan="2">Especificaciones Técnicas</th>
                        <th rowspan="2">Cantidad</th>
                        <th rowspan="2">Valor U.</th>
                        <th rowspan="2">Impuestos</th>
                        <th rowspan="2">Total Item</th>
                        <th colspan="12">Cantidad programadas por meses</th>                       
                    </tr>
                    <tr class="text-center align-top table-secondary">
                        <th>Ene</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Abr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Ago</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dic</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($purchasePlans as $purchasePlan)
                    @foreach($purchasePlan->purchasePlanItems as $item)
                        <tr>
                            <td rowspan="2">{{ $purchasePlan->id }}</td>
                            <td rowspan="2">{{ $purchasePlan->created_at->format('d-m-Y H:i:s') }}</td>
                            <td rowspan="2">{{ $purchasePlan->period }}</td>
                            <td rowspan="2">{{ $purchasePlan->subject }}</td>
                            <td rowspan="2">{{ $purchasePlan->description }}</td>
                            <td rowspan="2">{{ $purchasePlan->purpose }}</td>
                            <td rowspan="2">{{ $purchasePlan->userResponsible->FullName }}</td>
                            <td rowspan="2">{{ $purchasePlan->position }}</td>
                            <td rowspan="2">{{ $purchasePlan->telephone }}</td>
                            <td rowspan="2">{{ $purchasePlan->email }}</td>
                            <td rowspan="2">{{ $purchasePlan->organizationalUnit->name }} ({{$purchasePlan->organizationalUnit->establishment->name}})</td>
                            <td rowspan="2">{{ $purchasePlan->userCreator->TinnyName }}</td>
                            <td rowspan="2">{{ $purchasePlan->program }}</td>
                            <td rowspan="2" class="text-center">{{ $purchasePlan->purchasePlanItems->count() }}</td>
                            <td rowspan="2" class="text-end">{{ $purchasePlan->symbol_currency }}{{ number_format($purchasePlan->estimated_expense,$purchasePlan->precision_currency,",",".") }}</td>
                            <td rowspan="2">{{ $purchasePlan->getStatus() }}</td>
                            <td rowspan="2" class="text-center">{{ $loop->iteration }}</td>
                            <td rowspan="2" class="text-end">{{ $item->id ?? '' }}</td>
                            {{--<td rowspan="2" class="text-end" nowrap>{{ $item->budgetItem ? $item->budgetItem->fullName() : '' }}</td>--}}
                            <td rowspan="2">{{ optional($item->unspscProduct)->code }} {{ optional($item->unspscProduct)->name }}</td>
                            <td rowspan="2" class="text-center">{{ $item->unit_of_measurement }}</td>
                            <td rowspan="2">{{ $item->specification }}</td>
                            <td rowspan="2" class="text-center">{{ $item->quantity }}</td>
                            <td rowspan="2" class="text-end">{{ str_replace(',00', '', number_format($item->unit_value, 2,",",".")) }}</td>
                            <td rowspan="2" class="text-center">{{ $item->tax }}</td>
                            <td rowspan="2" class="text-end">{{ number_format($item->expense, $item->precision_currency,",",".") }}</td>
                        </tr>
                        <tr>
                            <td>{{$item->january}}</td>
                            <td>{{$item->february}}</td>
                            <td>{{$item->march}}</td>
                            <td>{{$item->april}}</td>
                            <td>{{$item->may}}</td>
                            <td>{{$item->june}}</td>
                            <td>{{$item->july}}</td>
                            <td>{{$item->august}}</td>
                            <td>{{$item->september}}</td>
                            <td>{{$item->october}}</td>
                            <td>{{$item->november}}</td>
                            <td>{{$item->december}}</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $purchasePlans->appends(request()->query())->links() }}
        @else
        <div class="table-responsive">
            <table class="table table-bordered table-sm small">
                <thead>
                    <tr class="text-center align-top table-secondary">
                        <th width="6%">ID</th>
                        <th width="7%">
                            Fecha Creación
                            <span class="badge bg-info text-dark">Periodo</span>
                        </th>
                        <th width="">Asunto</th>
                        <th width="">Responsable</th>
                        <th width="">Programa</th>
                        <th width="120px">Estado</th>
                        <th width="85px"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($purchasePlans as $purchasePlan)
                    <tr>
                        <th class="text-center">
                            {{ $purchasePlan->id }}<br>
                        </th>
                        <td>
                            {{ $purchasePlan->created_at->format('d-m-Y H:i:s') }}
                            <span class="badge bg-info text-dark">{{ $purchasePlan->period }}</span><br>
                        </td>
                        <td>{{ $purchasePlan->subject }}</td>
                        <td>
                            <b>{{ $purchasePlan->userResponsible->FullName }}</b><br>
                            {{ $purchasePlan->organizationalUnit->name }} ({{$purchasePlan->organizationalUnit->establishment->name}})<br><br>
                            
                            creado por: <b>{{ $purchasePlan->userCreator->TinnyName }}</b>
                        </td>
                        <td>{{ $purchasePlan->program }}</td>
                        <td class="text-center">
                            @if($purchasePlan->status == 'save')
                                <i class="fas fa-save fa-2x"></i>
                            @else
                                @foreach($purchasePlan->approvals as $approval)
                                    @switch($approval->StatusInWords)
                                        @case('Pendiente')
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </span>
                                            @break
                                        @case('Aprobado')
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: green;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                <i class="fas fa-check-circle fa-2x"></i>
                                            </span>
                                            @break
                                        @case('Rechazado')
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: tomato;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                <i class="fas fa-ban-circle fa-2x"></i>
                                            </span>
                                            @break
                                    @endswitch
                                @endforeach
                            @endif

                            <br>

                            @switch($purchasePlan->status)
                                @case('save')
                                    <span class="badge bg-primary badge-sm">Guardado</span>
                                    @break
                                @case('sent')
                                    <span class="badge bg-secondary badge-sm">Enviado</span>
                                    @break
                                @default
                                    ''
                            @endswitch
                        </td>
                        <td class="text-left">
                            <a href="{{ route('purchase_plan.show', $purchasePlan) }}"
                                class="btn btn-outline-secondary btn-sm mb-1"><i class="fas fa-eye"></i></a>
                            @if($purchasePlan->canEdit())
                            <a href="{{ route('purchase_plan.edit', $purchasePlan->id) }}"
                                class="btn btn-outline-secondary btn-sm mb-1"><i class="fas fa-edit"></i> </a>
                            @endif
                            @if($purchasePlan->canDelete())
                            <button type="button" class="btn btn-outline-secondary btn-sm mb-1 text-danger"
                                onclick="confirm('¿Está seguro que desea borrar el plan de compra ID {{ $purchasePlan->id }}?') || event.stopImmediatePropagation()"
                                wire:click="delete({{ $purchasePlan }})"><i class="fas fa-trash"></i>
                            </button>
                            @endif                        
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $purchasePlans->appends(request()->query())->links() }}
        @endif
    @else
        <div class="alert alert-info" role="alert">
            Estimado Usuario: No se encuentran <b>Plan de Compras</b> bajo los parametros consultados.
        </div>
    @endif
</div>

@section('custom_js')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.18.0/dist/xlsx.full.min.js"></script>
<script>
    function tableExcel(filename, type, fn, dl) {
          var elt = document.getElementById('contenedor');
          var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS", raw: false });
          return dl ?
            XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
        }
</script>
@endsection