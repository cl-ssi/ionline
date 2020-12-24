@extends('layouts.app')

@section('title', 'Nuevo convenio')

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Evaluación General - {{$communeFile->description ?? '' }}</h3>


<div class="card mt-3 small">
        <div class="card-body">

            <table class="table-sm table table-striped table-bordered  table-hover ">
                <thead  style="font-size:75%;">
                    <tr>
                        <th>N°</th>
                        <th></th>
                        <th>Aspectos Generales</th>
                        <th class="text-right">SI  /  NO / REGULAR</th>
                        <th class="text-center">Observación y Solicitud</th>
                         @can('Reviews: edit')<th class="text-left align-middle" ></th>@endcan
                    </tr>
                </thead>
                <tbody  style="font-size:75%;">
                    @foreach($review as $key=>$review)
                    <tr>
                        <td class="text-center align-middle">{{++$key}}</td>
                        <td class="text-left align-middle">{{ $review->revisor }}</td>
                        <td class="text-left align-middle">{{ $review->general_features }}</td>
                        <td class="text-center align-middle">{{ $review->answer }}</td>
                        <td class="text-center align-middle">{{ $review->observation }}</td>
                        @can('Reviews: edit')
                        <td class="text-center align-middle" >
                        <button class="btn btb-flat btn-sm btn-light" data-toggle="modal"
                            data-target="#updateModal"
                            data-review_id="{{ $review->id }}"
                            data-answer="{{ $review->answer }}"
                            data-observation="{{ $review->observation }}"
                            data-formaction="{{ route('reviews.update', $review->id)}}">
                        <i class="fas fa-edit small"></i> Evaluar
                        </button>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('programmings/reviews/modal_edit_eval')

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
</script>
@endsection
