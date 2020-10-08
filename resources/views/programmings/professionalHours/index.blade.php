@extends('layouts.app')

@section('title', 'Lista de Profesionales')

@section('content')

@include('programmings/nav')

<h3 class="mb-3"> Valor Profesionales Hora</h3>

<div class="row">
<div class="col-sm-6">
  
    <table class="table  btn-table table-sm table-condensed fixed_headers table-hover ">
        <thead class="small">
            <tr >
                <th class="text-center align-middle table-dark" colspan="3">LISTADO DE PROFESIONALES</th>
            </tr>
        </thead>
        <thead>
            <tr class="small">
                <th>ID</th>
                <th>PROFESIONAL</th>
                <th class="text-center">ASIGNAR</th>
            </tr>
        </thead>
        <tbody >
            @foreach($professionals as $professional)
            <tr class="small">
                <td>{{ $professional->id }}</td>
                <td>{{ $professional->name }}</td>
                <td class="text-center">
                <button class="btn btb-flat btn-sm btn-light" data-toggle="modal"
                        data-target="#addModal"
                        data-programming="1"
                        data-professional_id="{{ $professional->id }}"
                        data-name="{{ $professional->name }}"
                        data-formaction="{{ route('professionalhours.store')}}">
                    <i class="fas fa-arrow-right small"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

  </div>
  <div class="col-sm-6">

    <table class="table table-sm table-hover">
    <thead>
            <tr class="small">
                <th class="text-center align-middle table-info" colspan="5">SELECCIONADOS</th>
            </tr>
        </thead>
        <thead>
            <tr class="small">
                <th>ID</th>
                <th>PROFESIONAL</th>
                <th class="text-right">VALOR x HORA</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($professionalHours as $professionalHour)
            <tr class="small">
                <td>{{ $professionalHour->id }}</td>
                <td>{{ $professionalHour->name }}</td>
                <td  class="text-right">{{ $professionalHour->value }}</td>
                <td class="text-right">
                    <form method="POST" action="{{ route('professionalhours.destroy', $professionalHour->professionalHour_id) }}" class=" d-inline">
                        {{ method_field('DELETE') }} {{ csrf_field() }}
                        <button class="btn btb-flat btn-sm btn-light"><span class="fas fa-times-circle text-dark" aria-hidden="true"></span></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="small">
                <td class="text-right" colspan="2">TOTAL</td>
                <td  class="text-right">{{ $professionalHours->sum('value') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
  
  </div>
</div>

@include('programmings/professionalHours/modal_add')

@endsection

@section('custom_js')
<script type="text/javascript">
    $('#addModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="name"]').val(button.data('name'))

        modal.find('input[name="programming_id"]').val(button.data('programming'))
        modal.find('input[name="professional_id"]').val(button.data('professional_id'))

        var formaction  = button.data('formaction')
        modal.find("#form-edit").attr('action', formaction)
    })
</script>
@endsection
