@extends('layouts.bt4.app')

@section('title', 'Evaluación')

@section('content')

@include('programmings/nav')

<h4 class="mb-3">Evaluación de Activividad</h4>
<h6 class="mb-3">{{$programmingItem->programming->description ?? ''}}</h6>
<a href="{{ Session::has('items_url') ? Session::get('items_url') : url()->previous() }}" class="btn btb-flat btn-sm btn-dark" >
                    <i class="fas fa-arrow-left small"></i> 
                    <span class="small">Volver</span> 
    </a>
{{--@if(auth()->user()->can('ProgrammingItem: edit') && $programmingItem->programming->status == 'active')
<a target="_blank" href="{{ route('programmingitems.show', $programmingItem->id) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-edit"></i> Editar</a>
@endif--}}

@if(auth()->user()->can('ProgrammingItem: delete') && $programmingItem->programming->status == 'active')
    <form method="POST" action="{{ route('programmingitems.destroy', $programmingItem->id) }}" class="small d-inline">
        {{ method_field('DELETE') }} {{ csrf_field() }}
        <button class="btn btn-sm btn-outline-danger float-right " onclick="return confirm('¿Desea eliminar el registro realmente?')">
        <span class="fas fa-trash-alt " aria-hidden="true"></span> Eliminar
        </button>
    </form>
@endif
<!-- 
{{$programmingItem }} -->
<div class="card mt-3 small">
    <div class="card-body">
        @if($programmingItem->activity_type == 'Indirecta' && $programmingItem->activity_subtype)
        <table class="table-sm table  table-bordered">
            <thead  style="font-size:75%;">
                <tr>
                    <th class="text-center align-middle table-secondary">N° REG.</th>
                    <th class="text-center align-middle table-secondary">TIPO ACTIVIDAD</th>
                    <th class="text-center align-middle table-secondary">SUBTIPO ACTIVIDAD</th>
                    @if($programmingItem->activity_subtype == 'Esporádicas')
                    <th class="text-center align-middle table-secondary">CATEGORÍA</th>
                    <th class="text-center align-middle table-secondary">ACTIVIDAD</th>
                    <th class="text-center align-middle table-secondary">N° VECES AL MES</th>
                    <th class="text-center align-middle table-secondary">N° MESES DEL AÑO</th>
                    <th class="text-center align-middle table-secondary">TOTAL ACTIVIDAD</th>
                    @else <!-- Designación -->
                    <th class="text-center align-middle table-secondary">ÁREA DE TRABAJO</th>
                    <th class="text-center align-middle table-secondary">ESPECIFICACIONES ÁREA DE TRABAJO</th>
                    @endif
                </tr>
            </thead>
            <tbody  style="font-size:75%;">
                <tr>
                    <td class="text-center align-middle">{{$programmingItem->id}}</td>
                    <td class="text-center align-middle">{{$programmingItem->activity_type}}</td>
                    <td class="text-center align-middle font-weight-bold">{{$programmingItem->activity_subtype}}</td>
                    @if($programmingItem->activity_subtype == 'Esporádicas')
                    <td class="text-center align-middle">{{ $programmingItem->activity_category}}</td>
                    <td class="text-center align-middle">{{ $programmingItem->activity_name}}</td>
                    <td class="text-center align-middle">{{ $programmingItem->times_month}}</td>
                    <td class="text-center align-middle">{{ $programmingItem->months_year}}</td>
                    <td class="text-center align-middle">{{ $programmingItem->activity_total}}</td>
                    @else <!-- Designación -->
                    <td class="text-center align-middle">{{ $programmingItem->work_area == 'Otro' ? $programmingItem->another_work_area : $programmingItem->work_area }}</td>
                    <td class="text-center align-middle">{{ $programmingItem->work_area_specs }}</td>
                    @endif
                </tr>
            </tbody>
        </table>
        @else
        <table class="table-sm table  table-bordered  ">
            <thead  style="font-size:75%;">
                <tr>
                    <th class="text-center align-middle table-secondary">N° REG.</th>
                    <th class="text-center align-middle table-secondary">TRAZADORA</th>
                    <th class="text-center align-middle table-secondary">Nº TRAZADORA</th>
                    <th class="text-center align-middle table-secondary">CICLO</th>
                    <th class="text-center align-middle table-secondary">TIPO ACCIÓN</th>
                    <th class="text-center align-middle table-secondary">ACTIVIDAD</th>
                </tr>
            </thead>
            <tbody  style="font-size:75%;">
                <tr>
                    <td class="text-center align-middle">{{$programmingItem->id}}</td>
                    <td class="text-center align-middle">{{$programmingItem->activityItem->tracer ?? ''}}</td>
                    <td class="text-center align-middle font-weight-bold">{{$programmingItem->activityItem->int_code ?? ''}}</td>
                    <td class="text-center align-middle">{{ $programmingItem->activityItem && $programmingItem->activityItem->tracer == 'NO' ? $programmingItem->cycle : ($programmingItem->activityItem->vital_cycle ?? $programmingItem->cycle) }}</td>
                    <td class="text-center align-middle">{{ $programmingItem->activityItem && $programmingItem->activityItem->tracer == 'NO' ? $programmingItem->action_type : ($programmingItem->activityItem->activityItem->action_type ?? $programmingItem->action_type) }}</td>
                    <td class="text-center align-middle">{{ $programmingItem->activityItem->activity_name ?? $programmingItem->activity_name }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table-sm table  table-bordered  ">
            <thead  style="font-size:75%;">
                <tr>
                    <th class="text-center align-middle table-secondary">POBLACIÓN OBJETIVO</th>
                    <th class="text-center align-middle table-secondary">FUENTE POBLACIÓN</th>
                    <th class="text-center align-middle table-secondary">Nº POBLACIÓN</th>
                    <th class="text-center align-middle table-secondary">PREVALENCIA</th>
                    <th class="text-center align-middle table-secondary">FUENTE PREV.</th>
                    <th class="text-center align-middle table-secondary">COBERTURA</th>
                    <th class="text-center align-middle table-secondary">Nº POB. A ATENDER</th>
                    <th class="text-center align-middle table-secondary">CONCENTRACIÓN</th>
                    <th class="text-center align-middle table-secondary">TOTAL ACTIVIDAD</th>
                </tr>
            </thead>
            <tbody  style="font-size:75%;">
                <tr>
                    <td class="text-center align-middle">{{$programmingItem->activityItem && $programmingItem->activityItem->tracer == 'NO' ? $programmingItem->def_target_population : ($programmingItem->activityItem->def_target_population ?? $programmingItem->def_target_population) }}</td>
                    <td class="text-center align-middle">{{$programmingItem->source_population}}</td>
                    <td class="text-center align-middle">{{number_format($programmingItem->cant_target_population,0, ",", ".")}}</td>
                    <td class="text-center align-middle">{{$programmingItem->prevalence_rate}} %</td>
                    <td class="text-center align-middle">{{$programmingItem->source_prevalence}}</td>
                    <td class="text-center align-middle">{{$programmingItem->coverture}} %</td>
                    <td class="text-center align-middle">{{number_format($programmingItem->population_attend,0, ",", ".")}}</td>
                    <td class="text-center align-middle">{{number_format($programmingItem->concentration,0, ",", ".")}}</td>
                    <td class="text-center align-middle font-weight-bold">{{number_format($programmingItem->activity_total,0, ",", ".")}}</td>
                </tr>
            </tbody>
        </table>
        @endif
        
        <table class="table-sm table  table-bordered  ">
            <thead  style="font-size:75%;">
                <tr>
                    <th class="text-center align-middle table-secondary">PROFESIONAL</th>
                    <th class="text-center align-middle table-secondary">RENDIMIENTO</th>
                    @if($programmingItem->professionalHours->count() > 0)
                    <th class="text-center align-middle table-secondary">HORAS/SEMANAS DESIGNADAS</th>
                    @endif
                    <th class="text-center align-middle table-secondary">T. DÍAS HAB.</th>
                    <th class="text-center align-middle table-secondary">HORA LABORAL</th>
                    <th class="text-center align-middle table-secondary">HORAS AÑO REQUERIDAS</th>
                    <th class="text-center align-middle table-secondary">HORAS DÍAS REQUERIDAS</th>
                    <th class="text-center align-middle table-secondary">JORNADAS DIRECTAS AÑO</th>
                    <th class="text-center align-middle table-secondary">JORNADAS HORAS DIRECTA DIARAS</th>
                </tr>
            </thead>
            <tbody  style="font-size:75%;">
                @if($programmingItem->professionalHours->count() > 0)
                    @foreach($programmingItem->professionalHours as $professionalHour)
                    <tr>
                        <td class="text-center align-middle">{{ $professionalHour->professional->name ?? '' }}</td>
                        <td class="text-center align-middle">{{ $professionalHour->pivot->activity_performance }}</td>
                        <td class="text-center align-middle">{{ $professionalHour->pivot->designated_hours_weeks }}</td>
                        <td class="text-center align-middle">{{ $programmingDay->days_programming ? number_format($programmingDay->days_programming,0, ",", ".") : ''}}</td>
                        <td class="text-center align-middle">{{ $programmingDay->day_work_hours ? number_format($programmingDay->day_work_hours,0, ",", ".") : ''}}</td>
                        <td class="text-center align-middle">{{ $professionalHour->pivot->hours_required_year ? number_format($professionalHour->pivot->hours_required_year,2, ",", ".") : '' }}</td>
                        <td class="text-center align-middle">{{ $professionalHour->pivot->hours_required_day ? number_format($professionalHour->pivot->hours_required_day,2, ",", ".") : '' }}</td>
                        <td class="text-center align-middle">{{ $professionalHour->pivot->direct_work_year ? number_format($professionalHour->pivot->direct_work_year,2, ",", ".") : '' }}</td>
                        <td class="text-center align-middle">{{ $professionalHour->pivot->direct_work_hour ? number_format($professionalHour->pivot->direct_work_hour,5, ",", ".") : '' }}</td>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <td class="text-center align-middle">{{$professional}}</td>
                    <td class="text-center align-middle">{{$programmingItem->activity_performance}}</td>
                    <td class="text-center align-middle">{{$programmingDay->days_programming ? number_format($programmingDay->days_programming,0, ",", ".") : ''}}</td>
                    <td class="text-center align-middle">{{$programmingDay->day_work_hours ? number_format($programmingDay->day_work_hours,0, ",", ".") : ''}}</td>
                    <td class="text-center align-middle">{{$programmingItem->hours_required_year ? number_format($programmingItem->hours_required_year,2, ",", ".") : ''}}</td>
                    <td class="text-center align-middle">{{$programmingItem->hours_required_day ? number_format($programmingItem->hours_required_day,2, ",", ".") : ''}} </td>
                    <td class="text-center align-middle">{{$programmingItem->direct_work_year ? number_format($programmingItem->direct_work_year,2, ",", ".") : ''}}</td>
                    <td class="text-center align-middle">{{$programmingItem->direct_work_hour ? number_format($programmingItem->direct_work_hour,5, ",", ".") : ''}}</td>
                </tr>
                @endif
            </tbody>
        </table>

        <table class="table-sm table  table-bordered  ">
            <thead  style="font-size:75%;">
                <tr>
                    <th class="text-center align-middle table-secondary">FUENTE INFORMACIÓN</th>
                    <th class="text-center align-middle table-secondary">FINANCIADA POR PRAP</th>
                    <th class="text-center align-middle table-secondary">OBSERVACIÓN</th>
                </tr>
            </thead>
            <tbody  style="font-size:75%;">
                <tr>
                    <td class="text-center align-middle">{{$programmingItem->activityItem->verification_rem ?? $programmingItem->information_source }}</td>
                    <td class="text-center align-middle">{{$programmingItem->prap_financed}}</td>
                    <td class="text-center align-middle">{{$programmingItem->observation}}</td>
                </tr>
            </tbody>
        </table>
        
    </div>
</div>
<!-- {{$reviewItems}} -->
<div class="card mt-3 small">
    <div class="card-body">

        <h5>Observaciones</h5>
        <ul class="list-inline">
            <li class="list-inline-item"><i class="fas fa-square text-danger "></i> No Aceptado</li>
            <li class="list-inline-item"><i class="fas fa-square text-success "></i> Rectificado</li>
            <li class="list-inline-item"><i class="fas fa-square text-warning "></i> Regularmente Aceptado</li>
            <li class="list-inline-item"><i class="fas fa-square text-primary "></i> Aceptado</li>
        </ul>
            <table id="tblData"  class="table table-sm table-hover   table-bordered">
                <thead style="font-size:75%;">
                    <tr >
                        <th class="text-center align-middle table-dark">ID</th>
                        <th class="text-center align-middle table-dark">FECHA CREACIÓN</th>
                        <th class="text-center align-middle table-dark">EVALUACIÓN</th>
                        <th class="text-center align-middle table-dark">¿SE ACEPTA?</th>
                        <th class="text-center align-middle table-dark">OBSERVACIÓN</th>
                        <th class="text-center align-middle table-dark">EVALUADO POR</th>
                        <th class="text-center align-middle table-dark">RECTIFICADO POR</th>
                        <th class="text-center align-middle table-dark">¿REC.?</th>
                        <th class="text-center align-middle table-dark">COMENTARIO / ACUERDO</th>
                        @can('Reviews: edit')<th class="text-center align-middle table-dark" >EDITAR</th>@endcan
                        @can('Reviews: edit')<th class="text-center align-middle table-dark" >¿CONFIRMAR?</th>@endcan
                        @if(auth()->user()->can('Reviews: rectify') && $programmingItem->programming->status == 'active')
                        <th class="text-center align-middle table-dark" >RECTIFICAR</th>
                        @endif
                        @can('Reviews: delete')<th class="text-center align-middle table-dark" >ELIMINAR</th>@endcan
                    </tr>
                </thead>
                <tbody style="font-size:75%;">
                    @foreach($reviewItems as $review)
                    <tr >
                        <td 
                            @if($review->answer == 'NO' && $review->rectified == 'NO')
                                class="text-center align-middle table-danger"
                            @elseif($review->answer == 'REGULAR')
                                class="text-center align-middle table-warning"
                            @elseif($review->answer == 'SI')
                                class="text-center align-middle table-primary"
                            @else
                                class="text-center align-middle table-success"
                            @endif>
                            {{ $review->id }}
                        </td>

                        <td class="text-center align-middle">{{ $review->created_at->format('d/m/Y') }}</td>
                        <td>{{ $review->review }}</td>
                        <td  class="text-center align-middle">{{ $review->answer }}</td>
                        <td>{{ $review->observation }}</td>
                        <td>{{ $review->user->fullName ?? '' }}</td>
                        <td>{{ $review->reviewer->fullName ?? '' }}</td>
                        <td 
                            @if($review->rectified == 'SI')
                                class="text-center align-middle table-success"
                            @elseif($review->rectified == 'NO')
                                class="text-center align-middle table-default"
                            @endif>
                            {{ $review->rectified }}
                        </td>
                        <td>{{ $review->rect_comments }}</td>
                        @can('Reviews: edit')
                        <td class="text-center align-middle" >
                        <button class="btn btb-flat  btn-light" data-toggle="modal"
                            data-target="#updateModal"
                            data-review_id="{{ $review->id }}"
                            data-answer="{{ $review->answer }}"
                            data-observation="{{ $review->observation }}"
                            data-formaction="{{ route('reviewItems.update', $review->id)}}">
                        <i class="fas fa-edit "></i>
                        </button>
                        </td>
                        @endcan

                        @can('Reviews: edit')
                        <td class="text-center align-middle" >
                        <button class="btn btb-flat  btn-light" data-toggle="modal"
                            data-target="#updateModalConfirm"
                            data-review_id="{{ $review->id }}"
                            data-answer="{{ $review->answer }}"
                            data-observation="{{ $review->observation }}"
                            data-formaction="{{ route('reviewItems.update', $review->id)}}">
                        <i class="fas fa-handshake "></i>
                        </button>
                        </td>
                        @endcan
                        <!-- EVALUAR PARA  -->
                        @if(auth()->user()->can('Reviews: rectify') && $programmingItem->programming->status == 'active')
                       
                        <td class="text-center align-middle" >
                        <!-- <button class="btn btb-flat  btn-light" data-toggle="modal"
                            data-target="#updateModalRect"
                            data-review_id="{{ $review->id }}"
                            data-rectified="{{ $review->rectified }}"
                            data-rect_comments="{{ $review->rect_comments }}"
                            data-formaction="{{ route('reviewItemsRect.update', $review->id)}}">
                        <i class="far fa-check-square text-success "></i>
                        </button> -->
                        <a target="_blank" rel=opener href="{{ route('programmingitems.show', [$programmingItem->id, 'review_id' => $review->id]) }}" class="btn btb-flat btn-sm btn-light"><i class="far fa-check-square text-success"></i></a>
                        </td>
                        @endif
                        @can('Reviews: delete')
                        <td class="text-center align-middle">
                            <form method="POST" action="{{ route('reviewItems.destroy', $review->id) }}" class="small d-inline">
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
            
            @can('Reviews: create')
            <form method="POST" class="form-horizontal small" action="{{ route('reviewItems.store') }}" enctype="multipart/form-data">
                <div class="form-row">

                    @csrf
                    @method('POST')
                    <input type="hidden" name="programming_item_id" value="{{$programmingItem->id}}">
                    <input type="hidden" name="active" value="SI">
                    <input type="hidden" name="answer" value="NO">

                    <div class="form-group col-md-12">
                        <label for="forprogram">Evaluar</label>
                        <select name="review" id="review"  class="form-control">
                            @if($programmingItem->professionalHours->count() > 0 && $programmingItem->activity_type == 'Indirecta')
                            <option value="No hay observaciones. Actividad aceptada">No hay observaciones. Actividad aceptada.</option>
                            <option value="Actividad bien programada">Actividad bien programada.</option>
                            <option value="El profesional asignado está bien programado">El profesional asignado está bien programado.</option>
                            <option value="El rendimiento de la actividad se acepta">El rendimiento de la actividad se acepta.</option>
                            <option value="Las horas designadas se aceptan">Las horas designadas se aceptan.</option>
                            <option value="El total de actividades se acepta">El total de actividades se acepta.</option>
                            <option value="Otra observación">Otra observación.</option>
                            @else
                            <option value="No hay observaciones. Actividad aceptada">No hay observaciones. Actividad aceptada</option>
                            <option value="1. La actividad programada ¿se plantea como problema en el diagnóstico de salud? ¿está bien planteado?">1. La actividad programada ¿se plantea como problema en el diagnóstico de salud? ¿está bien planteado?</option>
                            <option value="2. La actividad programada ¿se encuentra planteada en la matriz de cuidados? ¿tiene un indicador elaborado?">2. La actividad programada ¿se encuentra planteada en la matriz de cuidados? ¿tiene un indicador elaborado?</option>
                            <option value="3. ¿Se acepta el número de población definido y fuente utilizada?">3. ¿Se acepta el número de población definido y fuente utilizada?</option>
                            <option value="4. ¿Se acepta la incidencia/prevalencia utilizada y su fuente?">4. ¿Se acepta la incidencia/prevalencia utilizada y su fuente?</option>
                            <option value="5. ¿Se acepta la cobertura definida">5. ¿Se acepta la cobertura definida?</option>
                            <option value="6. ¿Se acepta la concentración definida?">6. ¿Se acepta la concentración definida?</option>
                            <option value="7. ¿Se acepta el rendimiento definido?">7. ¿Se acepta el rendimiento definido?</option>
                            <option value="8. ¿Se acepta el profesional a quien se programa?">8. ¿Se acepta el profesional a quien se programa?</option>
                            <option value="9. ¿El total de actividades programadas está de acuerdo a la capacidad productiva de la comuna?">9. ¿El total de actividades programadas está de acuerdo a la capacidad productiva de la comuna?</option>
                            <option value="10. ¿Ruta REM definida corresponde para evaluación posterior?">10. ¿Ruta REM definida corresponde para evaluación posterior?</option>
                            <option value="11. Otra variable a observar">11. Otra variable a observar. </option>
                            @endif           
                        </select>
                    </div>

                    <div class="form-group col-12">
                        <label for="date_end" class="col-form-label">Observaciones:</label>
                        <textarea class="form-control" id="observation" name="observation" rows="5"></textarea>
                    </div>



                </div>

                <button type="submit" class="btn btn-primary">Agregar</button>

            </form>
            @endcan
           
        </div>

        
    </div>

    @include('programmings/reviewItems/modal_edit_eval')
    @include('programmings/reviewItems/modal_edit_confirm')
    @include('programmings/reviewItems/modal_edit_eval_rect')

    @hasanyrole('Programming: Review|Programming: Admin')
    <hr/>

        <h6><i class="fas fa-info-circle"></i> Auditoría Interna</h6>

        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Observaciones
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                     data-parent="#accordionExample">
                    <div class="card-body">
                    <h6 class="mt-3 mt-4">Historial de cambios</h6>
                        <div class="table-responsive-md">
                            <table class="table table-sm small text-muted mt-3">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Modificaciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reviewItems as $reviewItem)
                                    @if($reviewItem->audits->count() > 0)
                                        @foreach($reviewItem->audits->sortByDesc('updated_at') as $audit)
                                            <tr>
                                                <td nowrap>{{ $audit->created_at }}</td>
                                                <td nowrap>{{ optional($audit->user)->fullName }}</td>
                                                <td>
                                                    @foreach($audit->getModified() as $attribute => $modified)
                                                        @if(isset($modified['old']) OR isset($modified['new']))
                                                            <strong>{{ $attribute }}</strong>
                                                            :  {{ isset($modified['old']) ? $modified['old'] : '' }}
                                                            => {{ $modified['new'] }};
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endhasanyrole

@endsection

@section('custom_js')
<script type="text/javascript">
    $('#updateModal').on('show.bs.modal', function (event) {
        console.log("en modal");
        
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="review_id"]').val(button.data('review_id'))
        modal.find('select[name="answer"]').val(button.data('answer'))
        modal.find('textarea[name="observation"]').val(button.data('observation'))

        var formaction  = button.data('formaction')
        modal.find("#form-edit").attr('action', formaction)
    })

    $('#updateModalConfirm').on('show.bs.modal', function (event) {
        console.log("en modal");
        
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="review_id"]').val(button.data('review_id'))
        modal.find('select[name="answer"]').val(button.data('answer'))
        modal.find('textarea[name="observation"]').val(button.data('observation'))

        var formaction  = button.data('formaction')
        modal.find("#form-edit").attr('action', formaction)
    })

    $('#updateModalRect').on('show.bs.modal', function (event) {
        console.log("en modal");
        
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="review_id"]').val(button.data('review_id'))
        modal.find('select[name="rectified"]').val(button.data('rectified'))
        modal.find('textarea[name="rect_comments"]').val(button.data('rect_comments'))

        var formaction  = button.data('formaction')
        modal.find("#form-edit").attr('action', formaction)
    })
</script>
@endsection
