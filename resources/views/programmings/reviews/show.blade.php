@extends('layouts.bt4.app')

@section('title', 'Evaluación General -'. $communeFile->description ?? '')

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Evaluación General - {{$communeFile->description ?? '' }}</h3>


<div class="card mt-3 small">
        <div class="card-body">

            <table class="table-sm table table-striped table-bordered  table-hover ">
                <thead  style="font-size:75%;">
                    <tr>
                        <th></th>
                        <th>Aspectos Generales</th>
                        <th class="text-right">Puntaje</th>
                        <th class="text-center w-25">Observación y Solicitud</th>
                        @if(auth()->user()->can('Reviews: edit'))<th class="text-left align-middle" ></th>@endif
                    </tr>
                </thead>
                <tbody style="font-size:75%;">
                    @php($revisor_temp = null)
                    @php($passTotalA = false)
                    @php($totalA = $totalB = $totalC = 0)
                    @php($countA = $countB = $countB = 0)
                    @foreach($communeFile->programming_reviews as  $key => $review)
                    @if($communeFile->isLastReviewBy('REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES', $review))
                    <tr class="font-weight-bold">
                        <td class="text-right align-middle">TOTAL PARTE A</td>
                        <td class="text-center align-middle">{{$totalA}}</td>
                        <td class="text-center align-middle" colspan="2">PESO RELATIVO DEL COMPONENTE A (40%)</td>
                    </tr>
                    @php($countA = $key)
                    @endif
                    <tr>
                        @if($review->revisor != $revisor_temp)
                        <td class="text-left align-middle" rowspan="{{$communeFile->getReviewsCountBy($review->revisor)}}">{{ $review->revisor }}</td>
                        @php($revisor_temp = $review->revisor)
                        @endif
                        <td class="text-left align-middle">{!! $review->general_features !!}</td>
                        <td class="text-center align-middle">{{ $review->score }}</td>
                        <td class="text-center align-middle" >{{ $review->observation }}</td>
                        @if(auth()->user()->can('Reviews: edit'))
                        <td class="text-center align-middle" >
                        <button class="btn btb-flat btn-sm btn-light" data-toggle="modal"
                            data-target="#updateModal"
                            data-review_id="{{ $review->id }}"
                            data-score="{{ $review->score }}"
                            data-observation="{{ $review->observation }}"
                            data-info="{{ $review->updated_at && $review->updatedBy ? 'Actualizado el '. $review->updated_at->format('d-m-Y H:i'). ' por '. $review->updatedBy->fullName : '' }}"
                            data-formaction="{{ route('reviews.update', $review->id)}}">
                        <i class="fas fa-edit small"></i> Evaluar
                        </button>
                        </td>
                        @endif
                        @if($communeFile->isLastReviewBy('REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES', $review))
                        @php($totalB += $review->score)
                        @php($passTotalA = true)
                        <tr class="font-weight-bold">
                            <td class="text-right align-middle">TOTAL PARTE B</td>
                            <td class="text-center align-middle">{{$totalB}}</td>
                            <td class="text-center align-middle" colspan="2">PESO RELATIVO DEL COMPONENTE B (40%)</td>
                        </tr>
                        @php($countB = $key - $countA + 1)
                        @endif
                        @if($communeFile->isLastReviewBy('REVISION DE CAPACITACIÓN MUNICIPAL', $review))
                        @php($totalC += $review->score)
                        <tr class="font-weight-bold">
                            <td class="text-right align-middle" colspan="2">TOTAL PARTE C</td>
                            <td class="text-center align-middle">{{$totalC}}</td>
                            <td class="text-center align-middle" colspan="2">PESO RELATIVO DEL COMPONENTE C (20%)</td>
                        </tr>
                        @php($countC = $key - $countA - $countB+1)
                        @break
                        @endif
                    </tr>
                    <?php
                        if(!$passTotalA) $totalA += $review->score;
                        if($review->revisor != 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES') $totalC += $review->score;
                    ?>
                    @endforeach
                    @php($totalPonderado = ceil(($totalA/($countA*3))*40 + ($totalB/($countB*3))*40 + ($totalC/($countC*3))*20))
                    <tr class="font-weight-bold">
                        <td class="text-right align-middle" colspan="2">TOTAL PONDERADO</td>
                        <td class="text-right align-middle">{{$totalPonderado}}%</td>
                        <td class="text-center align-middle" colspan="2">{{ $totalPonderado >= 60 ? 'ACEPTADO' : 'RECHAZADO' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @include('programmings/reviews/modal_edit_eval')

    @can('Programming: audit')
    <hr/>
    <h6><i class="fas fa-info-circle"></i> Auditoría Interna</h6>

    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Evaluación General
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                data-parent="#accordionExample">
                <div class="card-body">
                    @include('partials.audit', ['audits' => $review->audits()])
                </div>
            </div>
        </div>
    </div>
    @endcan

@endsection

@section('custom_js')
<script type="text/javascript">
    $('#updateModal').on('show.bs.modal', function (event) {
        console.log("en modal");
        
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="review_id"]').val(button.data('review_id'))
        modal.find('select[name="score"]').val(button.data('score'))
        modal.find('textarea[name="observation"]').val(button.data('observation'))
        modal.find('small').text(button.data('info'))

        var formaction  = button.data('formaction')
        modal.find("#form-edit").attr('action', formaction)
    })
</script>
@endsection
