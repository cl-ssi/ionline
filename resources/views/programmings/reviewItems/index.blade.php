@extends('layouts.app')

@section('title', 'Evaluación')

@section('content')

@include('programmings/nav')

<h4 class="mb-3">Evaluación de Activividad</h4>
<h6 class="mb-3">{{$programmingItems->description}}</h6>
<a href="{{ route('programmingitems.index', ['programming_id' => $programmingItems->programming_id]) }}" class="btn btb-flat btn-sm btn-dark" >
                    <i class="fas fa-arrow-left small"></i> 
                    <span class="small">Volver</span> 
    </a>
@can('ProgrammingItem: edit')
<a target="_blank" href="{{ route('programmingitems.show', $programmingItems->id) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-edit"></i> Editar</a>
@endcan

@can('ProgrammingItem: delete')
    <form method="POST" action="{{ route('programmingitems.destroy', $programmingItems->id) }}" class="small d-inline">
        {{ method_field('DELETE') }} {{ csrf_field() }}
        <button class="btn btn-sm btn-outline-danger float-right " onclick="return confirm('¿Desea eliminar el registro realmente?')">
        <span class="fas fa-trash-alt " aria-hidden="true"></span> Eliminar
        </button>
    </form>
@endcan
<!-- 
{{$programmingItems }} -->
<div class="card mt-3 small">
    <div class="card-body">

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
                <tr >
                    <td class="text-center align-middle">{{$programmingItems->id}}</td>
                    <td class="text-center align-middle">{{$programmingItems->tracer}}</td>
                    <td class="text-center align-middle font-weight-bold">{{$programmingItems->tracer_number}}</td>
                    <td class="text-center align-middle">{{$programmingItems->cycle}}</td>
                    <td class="text-center align-middle">{{$programmingItems->action_type}}</td>
                    <td class="text-center align-middle">{{$programmingItems->activity_name}}</td>
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
                    <td class="text-center align-middle">{{$programmingItems->def_target_population}}</td>
                    <td class="text-center align-middle">{{$programmingItems->source_population}}</td>
                    <td class="text-center align-middle">{{number_format($programmingItems->cant_target_population,0, ",", ".")}}</td>
                    <td class="text-center align-middle">{{$programmingItems->prevalence_rate}} %</td>
                    <td class="text-center align-middle">{{$programmingItems->source_prevalence}}</td>
                    <td class="text-center align-middle">{{$programmingItems->coverture}} %</td>
                    <td class="text-center align-middle">{{number_format($programmingItems->population_attend,0, ",", ".")}}</td>
                    <td class="text-center align-middle">{{number_format($programmingItems->concentration,0, ",", ".")}}</td>
                    <td class="text-center align-middle font-weight-bold">{{number_format($programmingItems->activity_total,0, ",", ".")}}</td>
                </tr>
            </tbody>
        </table>
        
        <table class="table-sm table  table-bordered  ">
            <thead  style="font-size:75%;">
                <tr>
                    <th class="text-center align-middle table-secondary">PROFESIONAL</th>
                    <th class="text-center align-middle table-secondary">RENDIMIENTO</th>
                    <th class="text-center align-middle table-secondary">T. DÍAS HAB.</th>
                    <th class="text-center align-middle table-secondary">HORA LABORAL</th>
                    <th class="text-center align-middle table-secondary">HORAS AÑO REQUERIDAS</th>
                    <th class="text-center align-middle table-secondary">HORAS DÍAS REQUERIDAS</th>
                    <th class="text-center align-middle table-secondary">JORNADAS DIRECTAS AÑO</th>
                    <th class="text-center align-middle table-secondary">JORNADAS HORAS DIRECTA DIARAS</th>
                </tr>
            </thead>
            <tbody  style="font-size:75%;">
                <tr>
                    <td class="text-center align-middle">{{$programmingItems->professional}}</td>
                    <td class="text-center align-middle">{{$programmingItems->activity_performance}}</td>
                    <td class="text-center align-middle">{{number_format($programmingDays->days_programming,0, ",", ".")}}</td>
                    <td class="text-center align-middle">{{number_format($programmingDays->day_work_hours,0, ",", ".")}}</td>
                    <td class="text-center align-middle">{{number_format($programmingItems->hours_required_year,2, ",", ".")}}</td>
                    <td class="text-center align-middle">{{number_format($programmingItems->hours_required_day,2, ",", ".")}} </td>
                    <td class="text-center align-middle">{{number_format($programmingItems->direct_work_year,2, ",", ".")}}</td>
                    <td class="text-center align-middle">{{number_format($programmingItems->direct_work_hour,4, ",", ".")}}</td>
                </tr>
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
                    <td class="text-center align-middle">{{$programmingItems->information_source}}</td>
                    <td class="text-center align-middle">{{$programmingItems->prap_financed}}</td>
                    <td class="text-center align-middle">{{$programmingItems->observation}}</td>
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
                        @can('Reviews: rectify')<th class="text-center align-middle table-dark" >RECTIFICAR</th>@endcan
                        @can('Reviews: delete')<th class="text-center align-middle table-dark" >ELIMINAR</th>@endcan
                    </tr>
                </thead>
                <tbody style="font-size:75%;">
                    @foreach($reviewItems as $review)
                    <tr >
                        <td 
                            @if($review->answer == 'NO')
                                class="text-center align-middle table-danger"
                            @elseif($review->answer == 'REGULAR')
                                class="text-center align-middle table-warning"
                            @elseif($review->answer == 'SI')
                                class="text-center align-middle table-primary"
                            @endif>
                            {{ $review->id }}
                        </td>

                        <td class="text-center align-middle">{{ $review->created_at->format('d/m/Y') }}</td>
                        <td>{{ $review->review }}</td>
                        <td  class="text-center align-middle">{{ $review->answer }}</td>
                        <td>{{ $review->observation }}</td>
                        <td>{{ $review->name }} {{ $review->fathers_family }} {{ $review->mothers_family }}</td>
                        <td>{{ $review->name_rev }} {{ $review->fathers_family_rev }} {{ $review->mothers_family_rev }}</td>
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
                        @can('Reviews: rectify')
                       
                        <td class="text-center align-middle" >
                        <button class="btn btb-flat  btn-light" data-toggle="modal"
                            data-target="#updateModalRect"
                            data-review_id="{{ $review->id }}"
                            data-rectified="{{ $review->rectified }}"
                            data-rect_comments="{{ $review->rect_comments }}"
                            data-formaction="{{ route('reviewItemsRect.update', $review->id)}}">
                        <i class="far fa-check-square text-success "></i>
                        </button>
                        </td>
                        @endcan
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
                    <input type="hidden" name="programming_item_id" value="{{$programmingItems->id}}">
                    <input type="hidden" name="active" value="SI">
                    <input type="hidden" name="answer" value="NO">

                    <div class="form-group col-md-12">
                        <label for="forprogram">Evaluar</label>
                        <select name="review" id="review"  class="form-control">
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
</div>

    @include('programmings/reviewItems/modal_edit_eval')
    @include('programmings/reviewItems/modal_edit_confirm')
    @include('programmings/reviewItems/modal_edit_eval_rect')

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
