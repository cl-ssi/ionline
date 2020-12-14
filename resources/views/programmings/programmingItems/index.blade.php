@extends('layouts.app')

@section('title', 'Lista de Items')

@section('content')

@include('programmings/nav')



<a href="{{ route('programmingitems.create',['programming_id' => Request::get('programming_id')]) }}" class="btn btn-info mb-4 float-right btn-sm">Agregar Item</a>
<h4 class="mb-3"> Programación - Horas Directas - {{$programming->establishment ?? '' }} {{$programming->year ?? '' }} </h4>

<form method="GET" class="form-horizontal small " action="{{ route('programmingitems.index') }}" enctype="multipart/form-data">

    <div class="form-row">
        <div class="form-group col-md-3">
            <input type="hidden" class="form-control" id="tracer" name="programming_id" value="{{Request::get('programming_id')}}" placeholder="Nro. Trazadora" >
            <!-- <input type="number" class="form-control" id="tracer" name="tracer_number" value="" placeholder="Nro. Trazadora" > -->
      
            <select name="tracer_number[]" id="tracer_number" class="form-control selectpicker " data-live-search="true" multiple>
                @foreach($activityItems as $activityItem)
                    <option value="{{ $activityItem->int_code }}">{{$activityItem->int_code}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-default mb-4">Filtrar</button>
    </div>

</form>

<ul class="list-inline">
    <li class="list-inline-item">
        <button onclick="tableExcel('xlsx')" class="btn btn-success mb-1 float-left btn-sm">Exportar Excel</button>
    </li>
    <li class="list-inline-item">
        <a href="{{ route('programming.reportObservation',['programming_id' => Request::get('programming_id')]) }}" class="btn btn-dark mb-1 float-right btn-sm">
        Observaciones 
            @foreach($reviewIndicators as $reviewIndicator)
            <span 
                @if($reviewIndicator->indicator == 'Pendiente')
                    class="badge badge-danger"
                @elseif($reviewIndicator->indicator == 'Revisión')
                    class="badge badge-warning"
                @elseif($reviewIndicator->indicator == 'Aceptada')
                    class="badge badge-primary"
                @endif>
            
            {{ $reviewIndicator->qty }}</span>  
            @endforeach
        </a>
    </li>
</ul>


<ul class="list-inline">
            <li class="list-inline-item"><i class="fas fa-square text-danger "></i> No Aceptado</li>
            <li class="list-inline-item"><i class="fas fa-square text-success "></i> Rectificado</li>
            <li class="list-inline-item"><i class="fas fa-square text-warning "></i> Regularmente Aceptado</li>
            <li class="list-inline-item"><i class="fas fa-square text-primary "></i> Aceptado</li>
        </ul>
<!-- ACTIVIDADES DIRECTAS -->
<table id="tblData" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive  ">
    <thead>
        <tr class="small " style="font-size:50%;">
            @can('ProgrammingItem: evaluate')<th class="text-center align-middle" > Evaluación</th>@endcan
            @can('ProgrammingItem: edit')<th class="text-center align-middle" >Editar</th>@endcan
            <th class="text-center align-middle">T</th>
            <th class="text-center align-middle">Nº Trazadora</th>
            <th class="text-center align-middle">CICLO</th>
            <th class="text-center align-middle">ACCIÓN</th>
            <!--<th class="text-center align-middle">PROGRAMA MINISTERIAL</th>-->
            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
            <th class="text-center align-middle">DEF. POB. OBJETIVO</th>
            <th class="text-center align-middle">FUENTE POBLACIÓN</th>
            <th class="text-center align-middle">N° POB. OBJETIVO</th>
            <th class="text-center align-middle">PREVALENCIA O TASA</th>
            <th class="text-center align-middle">FUENTE DE PREVALENCIA O TASA</th>
            <th class="text-center align-middle">% COBERTURA</th>
            <th class="text-center align-middle">Poblacion a Atender</th>
            <th class="text-center align-middle">CONCENTRACIÓN</th>
            <th class="text-center align-middle">TOTAL ACTIVIDADES</th>
            <th class="text-center align-middle">FUNCIONARIO  QUE OTORGA LA PRESTACIÓN</th>
            <th class="text-center align-middle">Rendimiento de la Actividad</th>
            <th class="text-center align-middle">Horas Año Requeridas</th>
            <th class="text-center align-middle">Horas Dia requeridas</th>
            <th class="text-center align-middle">Jornadas Directas Año</th>
            <th class="text-center align-middle">Jornadas Horas Directas Diarias</th>
            <th class="text-center align-middle">Fuente Informacion </th>
            <th class="text-center align-middle">FINANCIADA POR PRAP</th>
            @can('ProgrammingItem: duplicate')<th class="text-center align-middle">DUPLICAR</th>@endcan
            @can('ProgrammingItem: delete')<th class="text-left align-middle" >ELIMINAR</th>@endcan

        </tr>
    </thead>
    <tbody style="font-size:65%;">
        @foreach($programmingItems as $programmingitem)
        <tr class="small">
        @can('ProgrammingItem: evaluate')
            <td class="text-center align-middle" >
                <a href="{{ route('reviewItems.index', ['programmingItem_id' => $programmingitem->id]) }}" class="btn btb-flat btn-sm btn-light">
                    @if($programmingitem->qty_reviews || $programmingitem->qty_rectify_reviews || $programmingitem->qty_regular_reviews || $programmingitem->qty_accept_reviews)
                    <i class="fas fa-clipboard-check text-secondary"></i>
                    <span class="badge badge-danger opacity-1 ml-2 ">{{ $programmingitem->qty_reviews}}</span>

                    <span class="badge badge-success ml-2 ">{{ $programmingitem->qty_rectify_reviews}}</span>

                    <span class="badge badge-warning ml-2 ">{{ $programmingitem->qty_regular_reviews}}</span>

                    <span class="badge badge-primary ml-2 ">{{ $programmingitem->qty_accept_reviews}}</span>
                    @else
                    <i class="fas fa-clipboard-check "></i>
                    <span class="badge badge-secondary ml-2 ">0</span>
                    @endif
                </a>
            </td>
        @endcan
        @can('ProgrammingItem: edit')
            <td class="text-center align-middle" ><a href="{{ route('programmingitems.show', $programmingitem->id) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-edit"></i></a></td>
        @endcan
            <td class="text-center align-middle">{{ $programmingitem->tracer }}</td>
            <td class="text-center align-middle">{{ $programmingitem->tracer_code }}</td>
            <td class="text-center align-middle">{{ $programmingitem->cycle }}</td>
            <td class="text-center align-middle">{{ $programmingitem->action_type }}</td>
            <!--<td class="text-center align-middle">{{ $programmingitem->ministerial_program }}</td>-->
            <td class="text-center align-middle">{{ $programmingitem->activity_name }}</td>
            <td class="text-center align-middle">{{ $programmingitem->def_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingitem->source_population }}</td>
            <td class="text-center align-middle">{{ $programmingitem->cant_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingitem->prevalence_rate }}</td>
            <td class="text-center align-middle">{{ $programmingitem->source_prevalence }}</td>
            <td class="text-center align-middle">{{ $programmingitem->coverture }}</td>
            <td class="text-center align-middle">{{ $programmingitem->population_attend }}</td>
            <td class="text-center align-middle">{{ $programmingitem->concentration }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activity_total }}</td>
            <td class="text-center align-middle">{{ $programmingitem->professional }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activity_performance }}</td>
            <td class="text-center align-middle">{{ $programmingitem->hours_required_year }}</td>
            <td class="text-center align-middle">{{ $programmingitem->hours_required_day }}</td>
            <td class="text-center align-middle">{{ $programmingitem->direct_work_year }}</td>
            <td class="text-center align-middle">{{ $programmingitem->direct_work_hour }}</td>
            <td class="text-center align-middle">{{ $programmingitem->information_source }}</td>
            <td class="text-center align-middle">{{ $programmingitem->prap_financed }}</td>
            @can('ProgrammingItem: duplicate')
            <td class="text-center align-middle">
                <form method="POST" action="{{ route('programmingitems.clone', $programmingitem->id) }}" class="small d-inline">
                    {{ method_field('POST') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-secondary small" onclick="return confirm('¿Desea duplicar el registro realmente?')">
                    <span class="fas fa-copy " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
            @can('ProgrammingItem: delete')
            <td class="text-center align-middle">
                <form method="POST" action="{{ route('programmingitems.destroy', $programmingitem->id) }}" class="small d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger small" onclick="return confirm('¿Desea eliminar el registro realmente?')">
                    <span class="fas fa-trash-alt " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>

<!-- ACTIVIDADES INDIRECTAS -->

<h4 class="mb-3"> Programación - Horas Indirectas</h4>

<button onclick="tableExcelIndirect('xlsx')" class="btn btn-success mb-4 float-left btn-sm">Exportar Excel</button>

<table id="tblDataIndirect" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive  ">
    <thead>
        <tr class="small " style="font-size:50%;">
            @can('ProgrammingItem: evaluate')<th class="text-left align-middle" > Evaluación</th>@endcan
            @can('ProgrammingItem: edit')<th class="text-left align-middle" >Editar</th>@endcan
            <th class="text-center align-middle">T</th>
            <th class="text-center align-middle">Nº Trazadora</th>
            <th class="text-center align-middle">CICLO</th>
            <th class="text-center align-middle">ACCIÓN</th>
            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
            <th class="text-center align-middle">DEF. POB. OBJETIVO</th>
            <th class="text-center align-middle">FUENTE POBLACIÓN</th>
            <th class="text-center align-middle">N° POB. OBJETIVO</th>
            <th class="text-center align-middle">PREVALENCIA O TASA</th>
            <th class="text-center align-middle">FUENTE DE PREVALENCIA O TASA</th>
            <th class="text-center align-middle">% COBERTURA</th>
            <th class="text-center align-middle">Poblacion a Atender</th>
            <th class="text-center align-middle">CONCENTRACIÓN</th>
            <th class="text-center align-middle">TOTAL ACTIVIDADES</th>
            <th class="text-center align-middle">FUNCIONARIO  QUE OTORGA LA PRESTACIÓN</th>
            <th class="text-center align-middle">Rendimiento de la Actividad</th>
            <th class="text-center align-middle">Horas Año Requeridas</th>
            <th class="text-center align-middle">Horas Dia requeridas</th>
            <th class="text-center align-middle">Jornadas Directas Año</th>
            <th class="text-center align-middle">Jornadas Horas Directas Diarias</th>
            <th class="text-center align-middle">Fuente Informacion </th>
            <th class="text-center align-middle">FINANCIADA POR PRAP</th>
            @can('ProgrammingItem: duplicate')<th class="text-center align-middle">DUPLICAR</th>@endcan
            @can('ProgrammingItem: delete')<th class="text-left align-middle" >ELIMINAR</th>@endcan

        </tr>
    </thead>
    <tbody style="font-size:65%;">
        @foreach($programmingItemIndirects as $programmingitemsIndirect)
        <tr class="small">
        @can('ProgrammingItem: evaluate')
            <td class="text-center align-middle" >
                <a href="{{ route('reviewItems.index', ['programmingItem_id' => $programmingitemsIndirect->id]) }}" class="btn btb-flat btn-sm btn-light">
                    @if($programmingitemsIndirect->qty_reviews > 0)
                    <i class="fas fa-clipboard-check text-danger"></i>
                    <span class="badge badge-danger ml-2 ">{{ $programmingitemsIndirect->qty_reviews}}</span>
                    @else
                    <i class="fas fa-clipboard-check "></i>
                    <span class="badge badge-secondary ml-2 ">0</span>
                    @endif
                </a>
            </td>
        @endcan
        @can('ProgrammingItem: edit')
            <td class="text-center align-middle" ><a href="{{ route('programmingitems.show', $programmingitemsIndirect->id) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-edit"></i></a></td>
        @endcan
            <td class="text-center align-middle">{{ $programmingitemsIndirect->tracer }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->tracer_code }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->cycle }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->action_type }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activity_name }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->def_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->source_population }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->cant_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->prevalence_rate }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->source_prevalence }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->coverture }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->population_attend }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->concentration }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activity_total }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->professional }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activity_performance }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->hours_required_year }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->hours_required_day }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->direct_work_year }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->direct_work_hour }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->information_source }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->prap_financed }}</td>
            @can('ProgrammingItem: duplicate')
            <td class="text-center align-middle">
                <form method="POST" action="{{ route('programmingitems.clone', $programmingitemsIndirect->id) }}" class="small d-inline">
                    {{ method_field('POST') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-secondary small" onclick="return confirm('¿Desea duplicar el registro realmente?')">
                    <span class="fas fa-copy " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
            @can('ProgrammingItem: delete')
            <td class="text-center align-middle">
                <form method="POST" action="{{ route('programmingitems.destroy', $programmingitemsIndirect->id) }}" class="small d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger small" onclick="return confirm('¿Desea eliminar el registro realmente?')">
                    <span class="fas fa-trash-alt " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>


<h4 class="mb-3"> Programación Talleres - Horas Directas</h4>

<button onclick="tableExcelTaller('xlsx')" class="btn btn-success mb-4 float-left btn-sm">Exportar Excel</button>

<table id="tblDataTaller" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive  ">
    <thead>
        <tr class="small " style="font-size:55%;">

            @can('ProgrammingItem: evaluate')<th class="text-left align-middle" > Evaluación</th>@endcan
            <th class="text-center align-middle">T</th>
            <th class="text-center align-middle">Nº Trazadora</th>
            <th class="text-center align-middle">TIPO</th>
            <th class="text-center align-middle">CICLO</th>
            <th class="text-center align-middle">ACCIÓN</th>
            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
            <th class="text-center align-middle">DEF. POB. OBJETIVO</th>
            <th class="text-center align-middle">FUENTE POBLACIÓN</th>
            <th class="text-center align-middle">N° POB. OBJETIVO</th>
            <th class="text-center align-middle">% COBERTURA</th>
            <th class="text-center align-middle">Poblacion a Atender</th>

            <th class="text-center align-middle">Nº Personas por Grupo</th>
            <th class="text-center align-middle">Nº Talleres</th>
            <th class="text-center align-middle">Nº Sesiones por Taller</th>

            <th class="text-center align-middle">TOTAL ACTIVIDADES</th>
            <th class="text-center align-middle">FUNCIONARIO  QUE OTORGA LA PRESTACIÓN</th>
            <th class="text-center align-middle">Duración de Sesión en Hora</th>
            <th class="text-center align-middle">Horas Año Requeridas</th>
            <th class="text-center align-middle">Horas Dia requeridas</th>
            <th class="text-center align-middle">Jornadas Directas Año</th>
            <th class="text-center align-middle">Jornadas Horas Directas Diarias</th>
            <th class="text-center align-middle">Fuente Informacion </th>
            <th class="text-center align-middle">FINANCIADA POR PRAP</th>
            @can('ProgrammingItem: duplicate')<th class="text-center align-middle">DUPLICAR</th>@endcan
            @can('ProgrammingItem: delete')<th class="text-left align-middle" >ELIMINAR</th>@endcan

        </tr>
    </thead>
    <tbody style="font-size:65%;">
        @foreach($programmingItemworkshops as $programmingItemworkshop)
        <tr class="small">
        @can('ProgrammingItem: evaluate')
            <td class="text-center align-middle" >
                <a href="{{ route('reviewItems.index', ['programmingItem_id' => $programmingItemworkshop->id]) }}" class="btn btb-flat btn-sm btn-light">
                    @if($programmingItemworkshop->qty_reviews > 0)
                    <i class="fas fa-clipboard-check text-danger"></i>
                    <span class="badge badge-danger ml-2 ">{{ $programmingItemworkshop->qty_reviews}}</span>
                    @else
                    <i class="fas fa-clipboard-check "></i>
                    <span class="badge badge-secondary ml-2 ">0</span>
                    @endif
                </a>
            </td>
        @endcan
            <td class="text-center align-middle">{{ $programmingItemworkshop->tracer }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->tracer_code }}</td>
            <td class="text-center align-middle">TALLER</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->cycle }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->action_type }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->activity_name }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->def_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->source_population }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->cant_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->coverture }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->population_attend }}</td>

            <td class="text-center align-middle">{{ $programmingItemworkshop->activity_group }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->workshop_number }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->workshop_session_number }}</td>


            <td class="text-center align-middle">{{ $programmingItemworkshop->activity_total }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->professional }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->activity_performance }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->hours_required_year }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->hours_required_day }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->direct_work_year }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->direct_work_hour }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->information_source }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->prap_financed }}</td>
            @can('ProgrammingItem: duplicate')
            <td class="text-center align-middle">
                <form method="POST" action="{{ route('programmingitems.clone', $programmingItemworkshop->id) }}" class="small d-inline">
                    {{ method_field('POST') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-secondary small" onclick="return confirm('¿Desea duplicar el registro realmente?')">
                    <span class="fas fa-copy " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
            @can('ProgrammingItem: delete')
            <td>
                <form method="POST" action="{{ route('programmingitems.destroy', $programmingItemworkshop->id) }}" class="small d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger small" onclick="return confirm('¿Desea eliminar el registro realmente?')">
                    <span class="fas fa-trash-alt " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>


@endsection

@section('custom_js')

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>  
<script>



    function tableExcel(type, fn, dl) {
          var elt = document.getElementById('tblData');
          const filename = 'Informe_HorasDirectas'
          var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
          return dl ?
            XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
        }
    
    function tableExcelIndirect(type, fn, dl) {
          var elt = document.getElementById('tblDataIndirect');
          const filename = 'Informe_HorasIndirectas'
          var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
          return dl ?
            XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
     }
    
    function tableExcelTaller(type, fn, dl) {
          var elt = document.getElementById('tblDataTaller');
          const filename = 'Informe_Taller'
          var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
          return dl ?
            XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
        }
</script>
@endsection
