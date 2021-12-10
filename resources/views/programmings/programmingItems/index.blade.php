@extends('layouts.app')

@section('title', 'Lista de Items')

@section('content')

@include('programmings/nav')


<a href="{{ route('programmingitems.create',['programming_id' => Request::get('programming_id')]) }}" class="btn btn-info mb-4 float-right btn-sm">Agregar Item</a>
<h4 class="mb-3"> Programación {{$programming->establishment->name ?? '' }} {{$programming->year ?? '' }} - <a href="{{ route('programming.reportObservation',['programming_id' => Request::get('programming_id')]) }}" class="btn btn-dark mb-1 btn-sm">
        Observaciones 
            <span class="badge badge-danger">{{$programming->countTotalReviewsBy('Not rectified') + $programming->pendingItems->count()}}</span>
            <span class="badge badge-warning">{{$programming->countTotalReviewsBy('Regularly rectified')}}</span>
            <span class="badge badge-primary">{{$programming->countTotalReviewsBy('Accepted rectified')}}</span>
        </a>
        @if($programming->pendingItems != null)
        <button type="button" class="btn btn-outline-warning btn-sm mb-1" data-toggle="modal" data-target="#exampleModal">
        <i class="fas fa-exclamation-triangle"></i> Actividades pendientes <span class="badge badge-warning">{{$programming->pendingItems->count()}}</span>
        </button> 
        @endif
</h4>

<!-- Modal -->
<div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actividades pendientes por programar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow:hidden;">
                    @can('ProgrammingItem: evaluate')
                    <form method="post" action="{{ route('pendingitems.store') }}">
                    @csrf
                    <input type="hidden" name="programming_id" value="{{$programming->id}}">
                    <div class="form-row">
                        <div class="form-group col-md-11">
                            <select style="font-size:60%;" name="pendingItemSelectedId" id="pendingItem" class="form-control selectpicker " data-live-search="true" title="Seleccione actividad" data-width="100%" required>
                                @foreach($pendingActivities as $activity)
                                    <option style="font-size:60%;" value="{{ $activity->id }}">
                                        {{ $activity->tracer }} - 
                                        {{ $activity->activity_name }} - 
                                        {{ $activity->def_target_population }} - 
                                        {{ $activity->professional }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </div>
                    </form>
                    @endcan
                    <table class="table center table-striped table-sm table-bordered table-condensed fixed_headers table-hover">
                        <thead class="small" style="font-size:60%;">
                            <th class="text-center align-middle">T</th>
                            <th class="text-center align-middle">Nº Trazadora</th>
                            <th class="text-center align-middle">CICLO</th>
                            <th class="text-center align-middle">ACCIÓN</th>
                            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
                            <th class="text-center align-middle">DEF. POB. OBJETIVO</th>
                            <th class="text-center align-middle">FUNCIONARIO  QUE OTORGA LA PRESTACIÓN</th>
                            <th class="text-center align-middle">SOLICITADO POR</th>
                            @can('ProgrammingItem: evaluate')<th class="text-center align-middle">ACCIONES</th>@endcan
                        </thead>
                        <tbody style="font-size:70%;">
                            @forelse($programming->pendingItems as $item)
                            <tr class="small">
                                <td class="text-center align-middle">{{ $item->tracer }}</td>
                                <td class="text-center align-middle">{{ $item->int_code }}</td>
                                <td class="text-center align-middle">{{ $item->vital_cycle }}</td>
                                <td class="text-center align-middle">{{ $item->action_type }}</td>
                                <td class="text-center align-middle">{{ $item->activity_name }}</td>
                                <td class="text-center align-middle">{{ $item->def_target_population }}</td>
                                <td class="text-center align-middle">{{ $item->professional }}</td>
                                <td class="text-center align-middle">{{ $item->pivot->requestedBy->fullName ?? '' }}</td>
                                @can('ProgrammingItem: evaluate')
                                <td class="text-center align-middle">
                                <form action="{{ route('pendingitems.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="programming_id" value="{{$programming->id}}">
                                    <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                        <i class="fas fa-trash fa-lg text-danger"></i>
                                    </button>
                                </form>
                                </td>
                                @endcan
                            </tr>
                            @empty
                            <td class="text-center align-middle" colspan="9"><br><br>No hay actividades pendientes<br><br><br></td>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<form method="GET" class="form-horizontal small " action="{{ route('programmingitems.index') }}" enctype="multipart/form-data">

    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="activity" class="sr-only">Nombre actividad</label>
            <input type="text" class="form-control" id="activity" name="activity" placeholder="Por nombre actividad" value="{{Request::get('activity')}}">
        </div>
        <div class="form-group col-md-2">
            <input type="hidden" class="form-control" id="tracer" name="programming_id" value="{{Request::get('programming_id')}}">
            <!-- <input type="number" class="form-control" id="tracer" name="tracer_number" value="" placeholder="Nro. Trazadora" > -->
      
            <select name="tracer_number[]" id="tracer_number" class="form-control selectpicker " data-live-search="true" multiple title="Por N° trazadora">
                @foreach($tracerNumbers as $tracer)
                    <option value="{{ $tracer }}">{{$tracer}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <select name="cycle" id="cycle" class="form-control selectpicker" title="Por ciclo vital">
                <option value=""></option>
                @php($cycle_types = array('INFANTIL', 'ADOLESCENTE', 'ADULTO', 'ADULTO MAYOR', 'TRANSVERSAL'))
                @foreach($cycle_types as $cycle_type)
                <option value="{{$cycle_type}}" @if($cycle_type == Request::get('cycle')) selected @endif>{{$cycle_type}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-light mb-4">Filtrar</button>
    </div>

</form>

<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-link active" id="nav-direct-tab" data-toggle="tab" href="#nav-direct" role="tab" aria-controls="nav-direct" aria-selected="true"><h6>Horas Directas</h6></a>
    <a class="nav-link" id="nav-indirect-tab" data-toggle="tab" href="#nav-indirect" role="tab" aria-controls="nav-indirect" aria-selected="false"><h6>Horas Indirectas</h6></a>
    <a class="nav-link" id="nav-workshop-tab" data-toggle="tab" href="#nav-workshop" role="tab" aria-controls="nav-workshop" aria-selected="false"><h6>Horas Directas Talleres</h6></a>
  </div>
</nav>  

<!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="direct-tab" data-toggle="tab" href="#direct" role="tab" aria-controls="direct" aria-selected="true"><h6>Horas Directas</h6></a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="indirect-tab" data-toggle="tab" href="#indirect" role="tab" aria-controls="indirect" aria-selected="false"><h6>Horas Indirectas</h6></a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="workshop-tab" data-toggle="tab" href="#workshop" role="tab" aria-controls="workshop" aria-selected="false"><h6>Horas Directas Talleres</h6></a>
    </li>
</ul> -->
</div> <!-- close div container -->
<br>
<div class="container-fluid">
<div class="tab-content" id="nav-tabContent">
    
<div class="tab-pane fade show active" id="nav-direct" role="tabpanel" aria-labelledby="nav-direct-tab">
<ul class="list-inline">
    <li class="list-inline-item"><i class="fas fa-square text-danger "></i> No Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-success "></i> Rectificado</li>
    <li class="list-inline-item"><i class="fas fa-square text-warning "></i> Regularmente Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-primary "></i> Aceptado</li>
    <li class="list-inline-item" style="float:right;"><button onclick="tableExcel('xlsx')" class="btn btn-success mb-1 float-left btn-sm">Exportar Excel</button></li>
</ul>
<!-- ACTIVIDADES DIRECTAS -->
<table id="tblData" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive">
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
        @php($directProgrammingItems = $programming->itemsBy('Direct', Request::has('activity') || Request::has('tracer_number')))
        @foreach($directProgrammingItems as $programmingitem)
        <tr class="small">
        @can('ProgrammingItem: evaluate')
            <td class="text-center align-middle" >
                <a href="{{ route('reviewItems.index', ['programmingItem_id' => $programmingitem->id]) }}" class="btn btb-flat btn-sm btn-light">
                    @if($programmingitem->reviewItems->count() != 0)
                        <i class="fas fa-clipboard-check text-secondary"></i>
                        @if($programmingitem->getCountReviewsBy('Not rectified') > 0)
                        <span class="badge badge-danger opacity-1 ml-2 ">{{ $programmingitem->getCountReviewsBy('Not rectified')}}</span>
                        @endif
                        @if($programmingitem->getCountReviewsBy('Rectified') > 0)
                        <span class="badge badge-success ml-2 ">{{ $programmingitem->getCountReviewsBy('Rectified')}}</span>
                        @endif
                        @if($programmingitem->getCountReviewsBy('Regularly rectified') > 0)
                        <span class="badge badge-warning ml-2 ">{{ $programmingitem->getCountReviewsBy('Regularly rectified')}}</span>
                        @endif
                        @if($programmingitem->getCountReviewsBy('Accepted rectified') > 0)
                        <span class="badge badge-primary ml-2 ">{{ $programmingitem->getCountReviewsBy('Accepted rectified')}}</span>
                        @endif
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
            <td class="text-center align-middle">{{ $programmingitem->activityItem->tracer ?? '' }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activityItem->int_code ?? '' }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activityItem && $programmingitem->activityItem->tracer == 'NO' ? $programmingitem->cycle : ($programmingitem->activityItem->vital_cycle ?? $programmingitem->cycle) }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activityItem && $programmingitem->activityItem->tracer == 'NO' ? $programmingitem->action_type : ($programmingitem->activityItem->activityItem->action_type ?? $programmingitem->action_type) }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activityItem->activity_name ?? $programmingitem->activity_name }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activityItem && $programmingitem->activityItem->tracer == 'NO' ? $programmingitem->def_target_population : ($programmingitem->activityItem->def_target_population ?? $programmingitem->def_target_population) }}</td>
            <td class="text-center align-middle">{{ $programmingitem->source_population }}</td>
            <td class="text-center align-middle">{{ $programmingitem->cant_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingitem->prevalence_rate }}</td>
            <td class="text-center align-middle">{{ $programmingitem->source_prevalence }}</td>
            <td class="text-center align-middle">{{ $programmingitem->coverture }}</td>
            <td class="text-center align-middle">{{ $programmingitem->population_attend }}</td>
            <td class="text-center align-middle">{{ $programmingitem->concentration }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activity_total }}</td>
            <td class="text-center align-middle">{{ $programmingitem->professionalHour->professional->name ?? '' }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activity_performance }}</td>
            <td class="text-center align-middle">{{ $programmingitem->hours_required_year }}</td>
            <td class="text-center align-middle">{{ $programmingitem->hours_required_day }}</td>
            <td class="text-center align-middle">{{ $programmingitem->direct_work_year }}</td>
            <td class="text-center align-middle">{{ $programmingitem->direct_work_hour }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activityItem->verification_rem ?? $programmingitem->information_source }}</td>
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
</div>

<div class="tab-pane fade" id="nav-indirect" role="tabpanel" aria-labelledby="nav-indirect-tab">
<ul class="list-inline">
    <li class="list-inline-item"><i class="fas fa-square text-danger "></i> No Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-success "></i> Rectificado</li>
    <li class="list-inline-item"><i class="fas fa-square text-warning "></i> Regularmente Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-primary "></i> Aceptado</li>
    <li class="list-inline-item" style="float:right;"><button onclick="tableExcelIndirect('xlsx')" class="btn btn-success mb-1 float-left btn-sm">Exportar Excel</button></li>
</ul>

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
    @php($indirectProgrammingItems = $programming->itemsBy('Indirect', Request::has('activity') || Request::has('tracer_number')))
        @foreach($indirectProgrammingItems as $programmingitemsIndirect)
        <tr class="small">
        @can('ProgrammingItem: evaluate')
            <td class="text-center align-middle" >
                <a href="{{ route('reviewItems.index', ['programmingItem_id' => $programmingitemsIndirect->id]) }}" class="btn btb-flat btn-sm btn-light">
                    @if($programmingitemsIndirect->getCountReviewsBy('Not rectified') > 0)
                    <i class="fas fa-clipboard-check text-danger"></i>
                    <span class="badge badge-danger ml-2 ">{{ $programmingitemsIndirect->getCountReviewsBy('Not rectified')}}</span>
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
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activityItem->tracer ?? '' }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activityItem->int_code ?? '' }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activityItem && $programmingitemsIndirect->activityItem->tracer == 'NO' ? $programmingitemsIndirect->cycle : ($programmingitemsIndirect->activityItem->vital_cycle ?? $programmingitemsIndirect->cycle) }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activityItem && $programmingitemsIndirect->activityItem->tracer == 'NO' ? $programmingitemsIndirect->action_type : ($programmingitemsIndirect->activityItem->activityItem->action_type ?? $programmingitemsIndirect->action_type) }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activityItem->activity_name ?? $programmingitemsIndirect->activity_name }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activityItem && $programmingitemsIndirect->activityItem->tracer == 'NO' ? $programmingitemsIndirect->def_target_population : ($programmingitemsIndirect->activityItem->def_target_population ?? $programmingitemsIndirect->def_target_population) }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->source_population }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->cant_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->prevalence_rate }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->source_prevalence }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->coverture }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->population_attend }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->concentration }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activity_total }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHour->professional->name ?? '' }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activity_performance }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->hours_required_year }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->hours_required_day }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->direct_work_year }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->direct_work_hour }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->activityItem->verification_rem ?? $programmingitemsIndirect->information_source }}</td>
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
</div>

<div class="tab-pane fade" id="nav-workshop" role="tabpanel" aria-labelledby="nav-workshop-tab">
<ul class="list-inline">
    <li class="list-inline-item"><i class="fas fa-square text-danger "></i> No Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-success "></i> Rectificado</li>
    <li class="list-inline-item"><i class="fas fa-square text-warning "></i> Regularmente Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-primary "></i> Aceptado</li>
    <li class="list-inline-item" style="float:right;"><button onclick="tableExcelTaller('xlsx')" class="btn btn-success mb-1 float-left btn-sm">Exportar Excel</button></li>
</ul>

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
    @php($workshopProgrammingItems = $programming->itemsBy('Workshop', Request::has('activity') || Request::has('tracer_number')))
        @foreach($workshopProgrammingItems as $programmingItemworkshop)
        <tr class="small">
        @can('ProgrammingItem: evaluate')
            <td class="text-center align-middle" >
                <a href="{{ route('reviewItems.index', ['programmingItem_id' => $programmingItemworkshop->id]) }}" class="btn btb-flat btn-sm btn-light">
                    @if($programmingItemworkshop->getCountReviewsBy('Not rectified') > 0)
                    <i class="fas fa-clipboard-check text-danger"></i>
                    <span class="badge badge-danger ml-2 ">{{ $programmingItemworkshop->getCountReviewsBy('Not rectified')}}</span>
                    @else
                    <i class="fas fa-clipboard-check "></i>
                    <span class="badge badge-secondary ml-2 ">0</span>
                    @endif
                </a>
            </td>
        @endcan
            <td class="text-center align-middle">{{ $programmingItemworkshop->activityItem->tracer ?? '' }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->activityItem->int_code ?? '' }}</td>
            <td class="text-center align-middle">TALLER</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->activityItem && $programmingItemworkshop->activityItem->tracer == 'NO' ? $programmingItemworkshop->cycle : ($programmingItemworkshop->activityItem->vital_cycle ?? $programmingItemworkshop->cycle) }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->activityItem && $programmingItemworkshop->activityItem->tracer == 'NO' ? $programmingItemworkshop->action_type : ($programmingItemworkshop->activityItem->action_type ?? $programmingItemworkshop->action_type) }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->activityItem->activity_name ?? $programmingItemworkshop->activity_name }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->activityItem && $programmingItemworkshop->activityItem->tracer == 'NO' ? $programmingItemworkshop->def_target_population : ($programmingItemworkshop->activityItem->def_target_population ?? $programmingItemworkshop->def_target_population) }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->source_population }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->cant_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->coverture }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->population_attend }}</td>

            <td class="text-center align-middle">{{ $programmingItemworkshop->activity_group }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->workshop_number }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->workshop_session_number }}</td>


            <td class="text-center align-middle">{{ $programmingItemworkshop->activity_total }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->professionalHour->professional->name ?? '' }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->activity_performance }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->hours_required_year }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->hours_required_day }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->direct_work_year }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->direct_work_hour }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->activityItem->verification_rem ?? $programmingItemworkshop->information_source }}</td>
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
            <td class="text-center align-middle">
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
</div>
</div>
</div>
@endsection

@section('custom_js')

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>  
<script>
    $('#exampleModal').on('shown', function(){
        $('.selectpicker').selectpicker('refresh');
    });
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
