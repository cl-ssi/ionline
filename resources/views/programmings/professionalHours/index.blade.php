@extends('layouts.bt4.app')

@section('title', 'Lista de Profesionales')

@section('content')

@include('programmings/nav')

<h3 class="mb-3"> Valor Profesionales Hora</h3>

<small> * Puede asignar profesionales con valor hora 0</small>

<div class="row">
<div class="col-sm-6">
  
    <table class="table  btn-table table-sm table-condensed fixed_headers  ">
        <thead class="small">
            <tr >
                <th class="text-center align-middle table-dark" colspan="3">LISTADO DE PROFESIONALES</th>
            </tr>
        </thead>
        <thead style="font-size:80%;">
            <tr class="small">
                <th>ID</th>
                <th>PROFESIONAL</th>
                <th class="text-center">ASIGNAR</th>
            </tr>
        </thead>
        <tbody style="font-size:80%;">
            @foreach($professionals as $professional)
            <tr class="small">
                <td>{{ $professional->id }}</td>
                <td>{{ $professional->name }}</td>
                <td class="text-center">
                <button class="btn btb-flat btn-sm btn-light" data-toggle="modal"
                        data-target="#addModal"
                        data-programming="{{ Request::get('programming_id') }}"
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
        <thead style="font-size:80%;">
            <tr class="small">
                <th>ID</th>
                <th>PROFESIONAL</th>
                <th class="text-right">VALOR x HORA</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody style="font-size:80%;">
            @foreach($professionalHours as $professionalHour)
            <tr class="small">
                <td>{{ $professionalHour->professional->id }}</td>
                <td>{{ $professionalHour->professional->name }}</td>
                <td  class="text-right">{{ $professionalHour->value }}</td>
                <td class="text-right">
                    <form method="POST" action="{{ route('professionalhours.destroy', $professionalHour->id) }}" class=" d-inline">
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

@can('Programming: audit')
    <hr/>

        <h6><i class="fas fa-info-circle"></i> Auditoría Interna</h6>

        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Valores Profesional Hora
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
                                @foreach($professionalHours as $professionalHour)
                                    @if($professionalHour->audits->count() > 0)
                                        @foreach($professionalHour->audits->sortByDesc('updated_at') as $audit)
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
@endcan

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
