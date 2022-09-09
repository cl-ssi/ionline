@extends('layouts.app')

@section('title', 'Lista de Items')

@section('custom_css')
<style>
.modal {
  padding: 0 !important;
}
.modal .modal-dialog {
  width: 100%;
  max-width: 100%;
  height: 100%;
  margin: 0;
}
.modal .modal-content {
  border: 0;
  border-radius: 0;
  max-height: 100%; 
  height: 100%;
}
.modal .modal-body {
  overflow-y: auto;
}

.modal-dialog.modal-dialog-scrollable { max-height: 100%; }

.modal-dialog.modal-dialog-scrollable .modal-content { max-height: 100%; }

</style>
@endsection

@section('content')

@include('programmings/nav')


<a href="{{ route('programmingitems.create',['programming_id' => Request::get('programming_id'), 'activity_type' => Request::get('activity_type')]) }}" class="btn btn-info mb-4 float-right btn-sm">Agregar Item</a>
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
                <div class="modal-body">
                    @can('ProgrammingItem: evaluate')
                    <form method="post" action="{{ route('pendingitems.store') }}">
                    @csrf
                    <input type="hidden" name="programming_id" value="{{$programming->id}}">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <select style="font-size:70%;" name="pendingItemSelectedId" id="pendingItem" class="form-control selectpicker " data-live-search="true" title="Seleccione actividad" data-width="100%" required>
                                @foreach($pendingActivities as $activity)
                                    <option style="font-size:70%;" value="{{ $activity->id }}">
                                        {{ Str::limit($activity->tracer.' - '.$activity->activity_name.' - '.$activity->def_target_population.' - '.$activity->professional, 300, '(...)') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3">
                            <textarea name="observation" class="form-control custom-control" rows="2" style="resize:none" placeholder="Ingrese observaciones (opcional)"></textarea>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary float-right">Agregar</button>
                            </div>
                        </div>
                    </div>
                    </form>
                    @endcan
                    <div class="table-responsive">
                    <table class="table center table-striped table-sm table-bordered table-condensed fixed_headers table-hover">
                        <thead class="small" style="font-size:60%;">
                            <th class="text-center align-middle">T</th>
                            <th class="text-center align-middle">Nº T</th>
                            <th class="text-center align-middle">CICLO</th>
                            <th class="text-center align-middle">ACCIÓN</th>
                            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
                            <th class="text-center align-middle">DEF. POB. OBJETIVO</th>
                            <th class="text-center align-middle">PROF. QUE OTORGA LA PRESTACIÓN</th>
                            <th class="text-center align-middle">OBSERVACIONES</th>
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
                                <td class="text-center align-middle w-25">
                                    <div class="editable-txt">{!! $item->pivot->observation !!} 
                                    @can('ProgrammingItem: evaluate')
                                    <button id="btn_{{$item->pivot->id}}" title="Editar observaciones" class="float-right edit-btn" style="border: none; background-color:transparent;">
                                        <i class="fas fa-edit fa-lg text-warning"></i>
                                    </button>
                                    @endcan
                                    </div>

                                    @can('ProgrammingItem: evaluate')
                                    <form id="form_{{$item->pivot->id}}" class="editable-form" action="{{ route('pendingitems.update', $item->pivot->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="observation" rows="2" class="w-100">{!! $item->pivot->observation !!}</textarea><br>
                                        <button type="reset" title="Cancelar" class="float-right edit-btn" style="border: none; background-color:transparent;">
                                            <i class="fas fa-times fa-lg text-danger"></i>
                                        </button> 
                                        <button type="submit" title="Guardar" class="float-right" style="border: none; background-color:transparent;">
                                            <i class="fas fa-check fa-lg text-success"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                                <td class="text-center align-middle">{{ $item->pivot->requestedBy->fullName ?? '' }}</td>
                                @can('ProgrammingItem: evaluate')
                                <td class="text-center align-middle">
                                <form action="{{ route('pendingitems.destroy', $item->pivot->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Eliminar actividad pendiente" style="border: none; background-color:transparent;">
                                        <i class="fas fa-trash fa-lg text-danger"></i>
                                    </button>
                                </form>
                                </td>
                                @endcan
                            </tr>
                            @empty
                            <td class="text-center align-middle" colspan="10"><br><br>No hay actividades pendientes<br><br><br></td>
                            @endforelse

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<form method="GET" class="form-horizontal small " action="{{ route('programmingitems.index') }}" enctype="multipart/form-data">
    <input type="hidden" name="activity_type" value="{{Request::get('activity_type')}}">
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
    @if(Request::get('activity_type') == NULL || Request::get('activity_type') == 'Directa')<a class="nav-link active" id="nav-direct-tab" data-toggle="tab" href="#nav-direct" role="tab" aria-controls="nav-direct" aria-selected="true"><h6>Horas Directas</h6></a>@endif
    @if(Request::get('activity_type') == NULL || Request::get('activity_type') == 'Indirecta')
        @if($programming->year >= 2022)
        <a class="nav-link active" id="nav-indirect-Esporádicas-tab" data-toggle="tab" href="#nav-indirect-Esporádicas" role="tab" aria-controls="nav-indirect-Esporádicas" aria-selected="true"><h6>Horas Indirectas - Actividades esporádicas</h6></a>
        <a class="nav-link" id="nav-indirect-Designación-tab" data-toggle="tab" href="#nav-indirect-Designación" role="tab" aria-controls="nav-indirect-Designación" aria-selected="false"><h6>Horas Indirectas - Designación de horas funcionarios/rol</h6></a>
        @else
        <a class="nav-link {{Request::get('activity_type') == 'Indirecta' ? 'active' : ''}}" id="nav-indirect-tab" data-toggle="tab" href="#nav-indirect" role="tab" aria-controls="nav-indirect" aria-selected="{{Request::get('activity_type') == 'Indirecta' ? 'true' : 'false'}}"><h6>Horas Indirectas</h6></a>
        @endif
    @endif
    @if(Request::get('activity_type') == NULL || Request::get('activity_type') == 'Directa')<a class="nav-link" id="nav-workshop-tab" data-toggle="tab" href="#nav-workshop" role="tab" aria-controls="nav-workshop" aria-selected="false"><h6>Horas Directas Talleres</h6></a>@endif
  </div>
</nav>  
</div> <!-- close div container -->
<br>
<div class="container-fluid">
<div class="tab-content" id="nav-tabContent">
    
<div class="tab-pane fade {{Request::get('activity_type') == NULL || Request::get('activity_type') == 'Directa' ? 'show active' : ''}}" id="nav-direct" role="tabpanel" aria-labelledby="nav-direct-tab">
<ul class="list-inline">
    <li class="list-inline-item"><i class="fas fa-square text-danger "></i> No Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-success "></i> Rectificado</li>
    <li class="list-inline-item"><i class="fas fa-square text-warning "></i> Regularmente Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-primary "></i> Aceptado</li>
    <li class="list-inline-item" style="float:right;"><button onclick="tableExcel('HorasDirectas')" class="btn btn-success mb-1 float-left btn-sm">Exportar Excel</button></li>
</ul>
<!-- ACTIVIDADES DIRECTAS -->
<table id="HorasDirectas" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive">
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
            <th class="text-center align-middle">Registrado por</th>
            @can('ProgrammingItem: duplicate')<th class="text-center align-middle">DUPLICAR</th>@endcan
            @can('ProgrammingItem: delete')<th class="text-left align-middle" >ELIMINAR</th>@endcan

        </tr>
    </thead>
    <tbody style="font-size:65%;">
        @php($directProgrammingItems = $programming->itemsBy('Direct', Request::has('activity') || Request::has('tracer_number')))
        @foreach($directProgrammingItems as $programmingitem)
        <tr class="small">
        @can('ProgrammingItem: evaluate')
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">
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
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}"><a href="{{ route('programmingitems.show', $programmingitem->id) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-edit"></i></a></td>
        @endcan
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->activityItem->tracer ?? '' }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->activityItem->int_code ?? '' }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->activityItem && $programmingitem->activityItem->tracer == 'NO' ? $programmingitem->cycle : ($programmingitem->activityItem->vital_cycle ?? $programmingitem->cycle) }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->activityItem && $programmingitem->activityItem->tracer == 'NO' ? $programmingitem->action_type : ($programmingitem->activityItem->activityItem->action_type ?? $programmingitem->action_type) }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->activityItem->activity_name ?? $programmingitem->activity_name }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->activityItem && $programmingitem->activityItem->tracer == 'NO' ? $programmingitem->def_target_population : ($programmingitem->activityItem->def_target_population ?? $programmingitem->def_target_population) }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->source_population }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->cant_target_population }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->prevalence_rate ?? 'No aplica' }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->source_prevalence }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->coverture }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->population_attend }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->concentration }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->activity_total }}</td>
            @if($programmingitem->professionalHours->count() > 0)
                <td class="text-center align-middle">{{ $programmingitem->professionalHours->first()->professional->name ?? '' }}</td>
                <td class="text-center align-middle">{{ $programmingitem->professionalHours->first()->pivot->activity_performance }}</td>
                <td class="text-center align-middle">{{ $programmingitem->professionalHours->first()->pivot->hours_required_year }}</td>
                <td class="text-center align-middle">{{ $programmingitem->professionalHours->first()->pivot->hours_required_day }}</td>
                <td class="text-center align-middle">{{ $programmingitem->professionalHours->first()->pivot->direct_work_year }}</td>
                <td class="text-center align-middle">{{ $programmingitem->professionalHours->first()->pivot->direct_work_hour }}</td>
            @else
                <td class="text-center align-middle">{{ $programmingitem->professionalHour->professional->name ?? '' }}</td>
                <td class="text-center align-middle">{{ $programmingitem->activity_performance }}</td>
                <td class="text-center align-middle">{{ $programmingitem->hours_required_year }}</td>
                <td class="text-center align-middle">{{ $programmingitem->hours_required_day }}</td>
                <td class="text-center align-middle">{{ $programmingitem->direct_work_year }}</td>
                <td class="text-center align-middle">{{ $programmingitem->direct_work_hour }}</td>
            @endif
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->activityItem->verification_rem ?? $programmingitem->information_source }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->prap_financed }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">{{ $programmingitem->user->tinny_name }}</td>
            @can('ProgrammingItem: duplicate')
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">
                <form method="POST" action="{{ route('programmingitems.clone', $programmingitem->id) }}" class="small d-inline">
                    {{ method_field('POST') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-secondary small" onclick="return confirm('¿Desea duplicar el registro realmente?')">
                    <span class="fas fa-copy " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
            @can('ProgrammingItem: delete')
            <td class="text-center align-middle" rowspan="{{ $programmingitem->rowspan() }}">
                <form method="POST" action="{{ route('programmingitems.destroy', $programmingitem->id) }}" class="small d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger small" onclick="return confirm('¿Desea eliminar el registro realmente?')">
                    <span class="fas fa-trash-alt " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
        </tr>
        @if($programmingitem->professionalHours->count() > 0)
            @foreach($programmingitem->professionalHours as $professionalHour)
                @if(!$loop->first)
                <tr class="small">
                    <td class="text-center align-middle">{{ $professionalHour->professional->name ?? '' }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->activity_performance }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->hours_required_year }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->hours_required_day }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->direct_work_year }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->direct_work_hour }}</td>
                </tr>
                @endif
            @endforeach
        @endif
        @endforeach
    </tbody>
</table>
</div>

@if($programming->year >= 2022)
@foreach(array('Esporádicas', 'Designación') as $activity_subtype)
<div class="tab-pane fade {{Request::get('activity_type') == 'Indirecta' && $loop->first ? 'show active' : ''}}" id="nav-indirect-{{$activity_subtype}}" role="tabpanel" aria-labelledby="nav-indirect-{{$activity_subtype}}-tab">
<ul class="list-inline">
    <li class="list-inline-item"><i class="fas fa-square text-danger "></i> No Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-success "></i> Rectificado</li>
    <li class="list-inline-item"><i class="fas fa-square text-warning "></i> Regularmente Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-primary "></i> Aceptado</li>
    <li class="list-inline-item" style="float:right;"><button onclick="tableExcel('HorasIndirectas{{$activity_subtype}}')" class="btn btn-success mb-1 float-left btn-sm">Exportar Excel</button></li>
</ul>

<table id="HorasIndirectas{{$activity_subtype}}" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive  ">
    <thead>
        <tr class="small " style="font-size:50%;">
            @can('ProgrammingItem: evaluate')<th class="text-left align-middle" > Evaluación</th>@endcan
            @can('ProgrammingItem: edit')<th class="text-left align-middle" >Editar</th>@endcan
            <th class="text-center align-middle">CATEGORÍA</th>
            <th class="text-center align-middle">NOMBRE DE ACTIVIDAD</th>
            <th class="text-center align-middle">N° VECES AL MES</th>
            <th class="text-center align-middle">N° MESES DEL AÑO</th>
            <th class="text-center align-middle">TOTAL ACTIVIDADES</th>
            <th class="text-center align-middle">ÁREA DE TRABAJO</th>
            <th class="text-center align-middle">ESPECIFICACIONES ÁREA DE TRABAJO</th>
            <th class="text-center align-middle">FUNCIONARIO QUE OTORGA LA PRESTACIÓN</th>
            <th class="text-center align-middle">Rendimiento de la Actividad</th>
            <th class="text-center align-middle">Horas/semanas designadas</th>
            <th class="text-center align-middle">Horas Año Requeridas</th>
            <th class="text-center align-middle">Horas Dia requeridas</th>
            <th class="text-center align-middle">Jornadas Directas Año</th>
            <th class="text-center align-middle">Jornadas Horas Directas Diarias</th>
            <th class="text-center align-middle">Fuente Informacion </th>
            <th class="text-center align-middle">FINANCIADA POR PRAP</th>
            <th class="text-center align-middle">Registrado por</th>
            @can('ProgrammingItem: duplicate')<th class="text-center align-middle">DUPLICAR</th>@endcan
            @can('ProgrammingItem: delete')<th class="text-left align-middle" >ELIMINAR</th>@endcan

        </tr>
    </thead>
    <tbody style="font-size:65%;">
    @php($indirectProgrammingItems = $programming->itemsIndirectBy($activity_subtype))
        @foreach($indirectProgrammingItems as $programmingitemsIndirect)
        <tr class="small">
        @can('ProgrammingItem: evaluate')
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">
                <a href="{{ route('reviewItems.index', ['programmingItem_id' => $programmingitemsIndirect->id]) }}" class="btn btb-flat btn-sm btn-light">
                    @if($programmingitemsIndirect->reviewItems->count() != 0)
                        <i class="fas fa-clipboard-check text-secondary"></i>
                        @if($programmingitemsIndirect->getCountReviewsBy('Not rectified') > 0)
                        <span class="badge badge-danger opacity-1 ml-2 ">{{ $programmingitemsIndirect->getCountReviewsBy('Not rectified')}}</span>
                        @endif
                        @if($programmingitemsIndirect->getCountReviewsBy('Rectified') > 0)
                        <span class="badge badge-success ml-2 ">{{ $programmingitemsIndirect->getCountReviewsBy('Rectified')}}</span>
                        @endif
                        @if($programmingitemsIndirect->getCountReviewsBy('Regularly rectified') > 0)
                        <span class="badge badge-warning ml-2 ">{{ $programmingitemsIndirect->getCountReviewsBy('Regularly rectified')}}</span>
                        @endif
                        @if($programmingitemsIndirect->getCountReviewsBy('Accepted rectified') > 0)
                        <span class="badge badge-primary ml-2 ">{{ $programmingitemsIndirect->getCountReviewsBy('Accepted rectified')}}</span>
                        @endif
                    @else
                    <i class="fas fa-clipboard-check "></i>
                    <span class="badge badge-secondary ml-2 ">0</span>
                    @endif
                </a>
            </td>
        @endcan
        @can('ProgrammingItem: edit')
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}"><a href="{{ route('programmingitems.show', $programmingitemsIndirect->id) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-edit"></i></a></td>
        @endcan
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->activity_category }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->activity_name }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->times_month }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->months_year }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->activity_total }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->work_area == 'Otro' ? $programmingitemsIndirect->another_work_area : $programmingitemsIndirect->work_area }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->work_area_specs }}</td>
            @if($programmingitemsIndirect->professionalHours->count() > 0)
            <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->professional->name ?? '' }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->pivot->activity_performance }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->pivot->designated_hours_weeks }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->pivot->hours_required_year }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->pivot->hours_required_day }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->pivot->direct_work_year }}</td>
            <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->pivot->direct_work_hour }}</td>
            @endif
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->information_source }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->prap_financed }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->user->tinny_name }}</td>
            @can('ProgrammingItem: duplicate')
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">
                <form method="POST" action="{{ route('programmingitems.clone', $programmingitemsIndirect->id) }}" class="small d-inline">
                    {{ method_field('POST') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-secondary small" onclick="return confirm('¿Desea duplicar el registro realmente?')">
                    <span class="fas fa-copy " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
            @can('ProgrammingItem: delete')
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">
                <form method="POST" action="{{ route('programmingitems.destroy', $programmingitemsIndirect->id) }}" class="small d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger small" onclick="return confirm('¿Desea eliminar el registro realmente?')">
                    <span class="fas fa-trash-alt " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
        </tr>
        @if($programmingitemsIndirect->professionalHours->count() > 0)
            @foreach($programmingitemsIndirect->professionalHours as $professionalHour)
                @if(!$loop->first)
                <tr class="small">
                    <td class="text-center align-middle">{{ $professionalHour->professional->name ?? '' }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->activity_performance }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->designated_hours_weeks }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->hours_required_year }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->hours_required_day }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->direct_work_year }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->direct_work_hour }}</td>
                </tr>
                @endif
            @endforeach
        @endif
        @endforeach
    </tbody>
</table>
</div>
@endforeach
@else
<div class="tab-pane fade {{Request::get('activity_type') == 'Indirecta' ? 'show active' : ''}}" id="nav-indirect" role="tabpanel" aria-labelledby="nav-indirect-tab">
<ul class="list-inline">
    <li class="list-inline-item"><i class="fas fa-square text-danger "></i> No Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-success "></i> Rectificado</li>
    <li class="list-inline-item"><i class="fas fa-square text-warning "></i> Regularmente Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-primary "></i> Aceptado</li>
    <li class="list-inline-item" style="float:right;"><button onclick="tableExcel('HorasIndirectas')" class="btn btn-success mb-1 float-left btn-sm">Exportar Excel</button></li>
</ul>

<table id="HorasIndirectas" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive  ">
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
            <th class="text-center align-middle">Registrado por</th>
            @can('ProgrammingItem: duplicate')<th class="text-center align-middle">DUPLICAR</th>@endcan
            @can('ProgrammingItem: delete')<th class="text-left align-middle" >ELIMINAR</th>@endcan

        </tr>
    </thead>
    <tbody style="font-size:65%;">
    @php($indirectProgrammingItems = $programming->itemsBy('Indirect', Request::has('activity') || Request::has('tracer_number')))
        @foreach($indirectProgrammingItems as $programmingitemsIndirect)
        <tr class="small">
        @can('ProgrammingItem: evaluate')
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">
                <a href="{{ route('reviewItems.index', ['programmingItem_id' => $programmingitemsIndirect->id]) }}" class="btn btb-flat btn-sm btn-light">
                    {{--@if($programmingitemsIndirect->getCountReviewsBy('Not rectified') > 0)
                    <i class="fas fa-clipboard-check text-danger"></i>
                    <span class="badge badge-danger ml-2 ">{{ $programmingitemsIndirect->getCountReviewsBy('Not rectified')}}</span>
                    @else
                    <i class="fas fa-clipboard-check "></i>
                    <span class="badge badge-secondary ml-2 ">0</span>
                    @endif--}}
                    @if($programmingitemsIndirect->reviewItems->count() != 0)
                        <i class="fas fa-clipboard-check text-secondary"></i>
                        @if($programmingitemsIndirect->getCountReviewsBy('Not rectified') > 0)
                        <span class="badge badge-danger opacity-1 ml-2 ">{{ $programmingitemsIndirect->getCountReviewsBy('Not rectified')}}</span>
                        @endif
                        @if($programmingitemsIndirect->getCountReviewsBy('Rectified') > 0)
                        <span class="badge badge-success ml-2 ">{{ $programmingitemsIndirect->getCountReviewsBy('Rectified')}}</span>
                        @endif
                        @if($programmingitemsIndirect->getCountReviewsBy('Regularly rectified') > 0)
                        <span class="badge badge-warning ml-2 ">{{ $programmingitemsIndirect->getCountReviewsBy('Regularly rectified')}}</span>
                        @endif
                        @if($programmingitemsIndirect->getCountReviewsBy('Accepted rectified') > 0)
                        <span class="badge badge-primary ml-2 ">{{ $programmingitemsIndirect->getCountReviewsBy('Accepted rectified')}}</span>
                        @endif
                    @else
                    <i class="fas fa-clipboard-check "></i>
                    <span class="badge badge-secondary ml-2 ">0</span>
                    @endif
                </a>
            </td>
        @endcan
        @can('ProgrammingItem: edit')
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}"><a href="{{ route('programmingitems.show', $programmingitemsIndirect->id) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-edit"></i></a></td>
        @endcan
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->activityItem->tracer ?? '' }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->activityItem->int_code ?? '' }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->activityItem && $programmingitemsIndirect->activityItem->tracer == 'NO' ? $programmingitemsIndirect->cycle : ($programmingitemsIndirect->activityItem->vital_cycle ?? $programmingitemsIndirect->cycle) }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->activityItem && $programmingitemsIndirect->activityItem->tracer == 'NO' ? $programmingitemsIndirect->action_type : ($programmingitemsIndirect->activityItem->activityItem->action_type ?? $programmingitemsIndirect->action_type) }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->activityItem->activity_name ?? $programmingitemsIndirect->activity_name }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->activityItem && $programmingitemsIndirect->activityItem->tracer == 'NO' ? $programmingitemsIndirect->def_target_population : ($programmingitemsIndirect->activityItem->def_target_population ?? $programmingitemsIndirect->def_target_population) }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->source_population }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->cant_target_population }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->prevalence_rate ?? 'No aplica' }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->source_prevalence }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->coverture }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->population_attend }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->concentration }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->activity_total }}</td>
            @if($programmingitemsIndirect->professionalHours->count() > 0)
                <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->professional->name ?? '' }}</td>
                <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->pivot->activity_performance }}</td>
                <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->pivot->hours_required_year }}</td>
                <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->pivot->hours_required_day }}</td>
                <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->pivot->direct_work_year }}</td>
                <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHours->first()->pivot->direct_work_hour }}</td>
            @else
                <td class="text-center align-middle">{{ $programmingitemsIndirect->professionalHour->professional->name ?? '' }}</td>
                <td class="text-center align-middle">{{ $programmingitemsIndirect->activity_performance }}</td>
                <td class="text-center align-middle">{{ $programmingitemsIndirect->hours_required_year }}</td>
                <td class="text-center align-middle">{{ $programmingitemsIndirect->hours_required_day }}</td>
                <td class="text-center align-middle">{{ $programmingitemsIndirect->direct_work_year }}</td>
                <td class="text-center align-middle">{{ $programmingitemsIndirect->direct_work_hour }}</td>
            @endif
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->activityItem->verification_rem ?? $programmingitemsIndirect->information_source }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->prap_financed }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">{{ $programmingitemsIndirect->user->tinny_name }}</td>
            @can('ProgrammingItem: duplicate')
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">
                <form method="POST" action="{{ route('programmingitems.clone', $programmingitemsIndirect->id) }}" class="small d-inline">
                    {{ method_field('POST') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-secondary small" onclick="return confirm('¿Desea duplicar el registro realmente?')">
                    <span class="fas fa-copy " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
            @can('ProgrammingItem: delete')
            <td class="text-center align-middle" rowspan="{{ $programmingitemsIndirect->rowspan() }}">
                <form method="POST" action="{{ route('programmingitems.destroy', $programmingitemsIndirect->id) }}" class="small d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger small" onclick="return confirm('¿Desea eliminar el registro realmente?')">
                    <span class="fas fa-trash-alt " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
        </tr>
        @if($programmingitemsIndirect->professionalHours->count() > 0)
            @foreach($programmingitemsIndirect->professionalHours as $professionalHour)
                @if(!$loop->first)
                <tr class="small">
                    <td class="text-center align-middle">{{ $professionalHour->professional->name ?? '' }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->activity_performance }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->hours_required_year }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->hours_required_day }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->direct_work_year }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->direct_work_hour }}</td>
                </tr>
                @endif
            @endforeach
        @endif
        @endforeach
    </tbody>
</table>
</div>
@endif

<div class="tab-pane fade" id="nav-workshop" role="tabpanel" aria-labelledby="nav-workshop-tab">
<ul class="list-inline">
    <li class="list-inline-item"><i class="fas fa-square text-danger "></i> No Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-success "></i> Rectificado</li>
    <li class="list-inline-item"><i class="fas fa-square text-warning "></i> Regularmente Aceptado</li>
    <li class="list-inline-item"><i class="fas fa-square text-primary "></i> Aceptado</li>
    <li class="list-inline-item" style="float:right;"><button onclick="tableExcel('HorasDirectasTaller')" class="btn btn-success mb-1 float-left btn-sm">Exportar Excel</button></li>
</ul>

<table id="HorasDirectasTaller" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive  ">
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
            <th class="text-center align-middle">Registrado por</th>
            @can('ProgrammingItem: duplicate')<th class="text-center align-middle">DUPLICAR</th>@endcan
            @can('ProgrammingItem: delete')<th class="text-left align-middle" >ELIMINAR</th>@endcan

        </tr>
    </thead>
    <tbody style="font-size:65%;">
    @php($workshopProgrammingItems = $programming->itemsBy('Workshop', Request::has('activity') || Request::has('tracer_number')))
        @foreach($workshopProgrammingItems as $programmingItemworkshop)
        <tr class="small">
        @can('ProgrammingItem: evaluate')
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">
                <a href="{{ route('reviewItems.index', ['programmingItem_id' => $programmingItemworkshop->id]) }}" class="btn btb-flat btn-sm btn-light">
                    {{--@if($programmingItemworkshop->getCountReviewsBy('Not rectified') > 0)
                    <i class="fas fa-clipboard-check text-danger"></i>
                    <span class="badge badge-danger ml-2 ">{{ $programmingItemworkshop->getCountReviewsBy('Not rectified')}}</span>
                    @else
                    <i class="fas fa-clipboard-check "></i>
                    <span class="badge badge-secondary ml-2 ">0</span>
                    @endif--}}
                    @if($programmingItemworkshop->reviewItems->count() != 0)
                        <i class="fas fa-clipboard-check text-secondary"></i>
                        @if($programmingItemworkshop->getCountReviewsBy('Not rectified') > 0)
                        <span class="badge badge-danger opacity-1 ml-2 ">{{ $programmingItemworkshop->getCountReviewsBy('Not rectified')}}</span>
                        @endif
                        @if($programmingItemworkshop->getCountReviewsBy('Rectified') > 0)
                        <span class="badge badge-success ml-2 ">{{ $programmingItemworkshop->getCountReviewsBy('Rectified')}}</span>
                        @endif
                        @if($programmingItemworkshop->getCountReviewsBy('Regularly rectified') > 0)
                        <span class="badge badge-warning ml-2 ">{{ $programmingItemworkshop->getCountReviewsBy('Regularly rectified')}}</span>
                        @endif
                        @if($programmingItemworkshop->getCountReviewsBy('Accepted rectified') > 0)
                        <span class="badge badge-primary ml-2 ">{{ $programmingItemworkshop->getCountReviewsBy('Accepted rectified')}}</span>
                        @endif
                    @else
                    <i class="fas fa-clipboard-check "></i>
                    <span class="badge badge-secondary ml-2 ">0</span>
                    @endif
                </a>
            </td>
        @endcan
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->activityItem->tracer ?? '' }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->activityItem->int_code ?? '' }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">TALLER</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->activityItem && $programmingItemworkshop->activityItem->tracer == 'NO' ? $programmingItemworkshop->cycle : ($programmingItemworkshop->activityItem->vital_cycle ?? $programmingItemworkshop->cycle) }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->activityItem && $programmingItemworkshop->activityItem->tracer == 'NO' ? $programmingItemworkshop->action_type : ($programmingItemworkshop->activityItem->action_type ?? $programmingItemworkshop->action_type) }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->activityItem->activity_name ?? $programmingItemworkshop->activity_name }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->activityItem && $programmingItemworkshop->activityItem->tracer == 'NO' ? $programmingItemworkshop->def_target_population : ($programmingItemworkshop->activityItem->def_target_population ?? $programmingItemworkshop->def_target_population) }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->source_population }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->cant_target_population }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->coverture }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->population_attend }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->activity_group }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->workshop_number }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->workshop_session_number }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->activity_total }}</td>
            @if($programmingItemworkshop->professionalHours->count() > 0)
                <td class="text-center align-middle">{{ $programmingItemworkshop->professionalHours->first()->professional->name ?? '' }}</td>
                <td class="text-center align-middle">{{ $programmingItemworkshop->professionalHours->first()->pivot->activity_performance }}</td>
                <td class="text-center align-middle">{{ $programmingItemworkshop->professionalHours->first()->pivot->hours_required_year }}</td>
                <td class="text-center align-middle">{{ $programmingItemworkshop->professionalHours->first()->pivot->hours_required_day }}</td>
                <td class="text-center align-middle">{{ $programmingItemworkshop->professionalHours->first()->pivot->direct_work_year }}</td>
                <td class="text-center align-middle">{{ $programmingItemworkshop->professionalHours->first()->pivot->direct_work_hour }}</td>
            @else
                <td class="text-center align-middle">{{ $programmingItemworkshop->professionalHour->professional->name ?? '' }}</td>
                <td class="text-center align-middle">{{ $programmingItemworkshop->activity_performance }}</td>
                <td class="text-center align-middle">{{ $programmingItemworkshop->hours_required_year }}</td>
                <td class="text-center align-middle">{{ $programmingItemworkshop->hours_required_day }}</td>
                <td class="text-center align-middle">{{ $programmingItemworkshop->direct_work_year }}</td>
                <td class="text-center align-middle">{{ $programmingItemworkshop->direct_work_hour }}</td>
            @endif
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->activityItem->verification_rem ?? $programmingItemworkshop->information_source }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->prap_financed }}</td>
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">{{ $programmingItemworkshop->user->tinny_name }}</td>
            @can('ProgrammingItem: duplicate')
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">
                <form method="POST" action="{{ route('programmingitems.clone', $programmingItemworkshop->id) }}" class="small d-inline">
                    {{ method_field('POST') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-secondary small" onclick="return confirm('¿Desea duplicar el registro realmente?')">
                    <span class="fas fa-copy " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
            @can('ProgrammingItem: delete')
            <td class="text-center align-middle" rowspan="{{ $programmingItemworkshop->rowspan() }}">
                <form method="POST" action="{{ route('programmingitems.destroy', $programmingItemworkshop->id) }}" class="small d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger small" onclick="return confirm('¿Desea eliminar el registro realmente?')">
                    <span class="fas fa-trash-alt " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
        </tr>
        @if($programmingItemworkshop->professionalHours->count() > 0)
            @foreach($programmingItemworkshop->professionalHours as $professionalHour)
                @if(!$loop->first)
                <tr class="small">
                    <td class="text-center align-middle">{{ $professionalHour->professional->name ?? '' }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->activity_performance }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->hours_required_year }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->hours_required_day }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->direct_work_year }}</td>
                    <td class="text-center align-middle">{{ $professionalHour->pivot->direct_work_hour }}</td>
                </tr>
                @endif
            @endforeach
        @endif
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>
@endsection

@section('custom_js')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.18.0/dist/xlsx.full.min.js"></script>  
<script>
    function tableExcel(table, type, fn, dl) {
        var elt = document.getElementById(`${table}`);
        var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
        return dl ?
        XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
        XLSX.writeFile(wb, `${table}.xlsx`)
    }
    
    $(document).ready(function(){
        $('.editable-form').hide();
        $('.edit-btn').click(function() {
            $(this).closest('td').find('.editable-form').toggle();
            $(this).closest('td').find('.editable-txt').toggle();
        });  
    });  
</script>
@endsection
