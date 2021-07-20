@extends('layouts.app')

@section('title', 'Ver detalle de resolución')

@section('content')

@include('agreements/nav')


<h3 class="mb-3">Ver detalle de Resolución #{{$program_resolution->id}}
    {{--@can('Agreement: delete')
		<form method="POST" action="{{ route('agreements.destroy', $agreement->id) }}" onclick="return confirm('¿Está seguro/a de eliminar este convenio?');" class="d-inline">
			{{ method_field('DELETE') }} {{ csrf_field() }}
			<button class="btn btn-sm btn-danger"><span class="fas fa-trash" aria-hidden="true"></span> Eliminar</button>
		</form>
	@endcan--}}
</h3>

<ol class="breadcrumb bg-light justify-content-end small">
    <li class="nav-item">
        <a class="nav-link text-secondary" href="{{ route('agreements.programs.resolution.createWord', $program_resolution) }}"><i class="fas fa-file-download"></i> Descargar borrador resolución</a>
    </li>
    @if($program_resolution->file != null)
    <li>
        <a class="nav-link text-secondary" href="{{ route('agreements.programs.resolution.download', $program_resolution) }}" target="blank"><i class="fas fa-eye"></i> Ver resolución firmada</a>
    </li>
    @endif
</ol>

    <div class="card mt-3 mb-3 small">
        <div class="card-body">
            <h5>Resolución</h5>

            <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('agreements.programs.resolutions.update', $program_resolution) }}" >
            @csrf
            @method('PUT')
            <div class="form-row">
                <fieldset class="form-group col-3">
                    <label for="fordate">Fecha Resolución</label>
                    <input type="date" name="date" class="form-control" id="fordate" value="{{ $program_resolution->date ? $program_resolution->date->format('Y-m-d') : '' }}" >
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="fornumber">Número Resolución</label>
                    <input type="integer" name="number" class="form-control" id="fornumber" value="{{ $program_resolution->number }}" >
                    <small class="form-text text-muted">* Nro. Resolución Exenta, se puede agregar al final.</small>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for">Archivo Resolución PDF ya firmada</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="forfile" name="file">
                      <label class="custom-file-label" for="forfile">Seleccionar Archivo </label>
                     <small class="form-text text-muted">* Adjuntar versión ya firmada por el/la director/a</small>
                    </div>
                </fieldset>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="foragreement">Programa</label>
                    <select name="agreement" id="formagreement" class="form-control" disabled>
                        <option>{{ $program_resolution->program->name }}</option>
                    </select>
                </div>

                <fieldset class="form-group col-3">
                    <label for="forreferente">Referente</label>
                    <select name="referrer_id" class="form-control selectpicker" data-live-search="true" title="Seleccione referente" required>
                        @foreach($referrers as $referrer)
                        <option value="{{$referrer->id}}" @if(isset($program_resolution->referrer->id) && $referrer->id == $program_resolution->referrer->id) selected @endif>{{$referrer->fullName}}</option>
                        @endforeach
                    </select>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="forestablishment">Establecimiento</label>
                    @php($establishments = array('Servicio de Salud Iquique', 'Hospital Dr. Ernesto Torres G.', 'CGU. Hector Reyno'))
                    <select name="establishment" class="form-control selectpicker" title="Seleccione..." required>
                        @foreach($establishments as $establishment)
                        <option value="{{$establishment}}" @if(isset($program_resolution->establishment) && $establishment == $program_resolution->establishment) selected @endif>{{$establishment}}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
            <div class="form-row">
                <fieldset class="form-group col-12">
                <label for="forrepresentative">Director/a a cargo</label>
                        <select name="director_signer_id" class="form-control selectpicker" title="Seleccione..." required>
                            @foreach($signers as $signer)
                            <option value="{{$signer->id}}" @if($signer->id == $program_resolution->director_signer_id) selected @endif>{{$signer->appellative}} {{$signer->user->fullName}}, {{$signer->decree}}</option>
                            @endforeach
                        </select>
                </fieldset>
            </div>
            <hr class="mt-2 mb-3"/>
            <div class="form-row">
                <fieldset class="form-group col-3">
                    <label for="fornumber">Número Resolución del Programa Ministerial</label>
                    <input type="integer" name="res_exempt_number" class="form-control" id="fornumber" value="{{ $program_resolution->res_exempt_number }}" >
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="fordate">Fecha Resolución del Programa Ministerial</label>
                    <input type="date" name="res_exempt_date" class="form-control" id="fordate" value="{{ $program_resolution->res_exempt_date ? $program_resolution->res_exempt_date->format('Y-m-d') : '' }}" >
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="fornumber">Número Resolución Distribuye Recursos</label>
                    <input type="integer" name="res_resource_number" class="form-control" id="fornumber" value="{{ $program_resolution->res_resource_number }}" >
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="fordate">Fecha Resolución Distribuye Recursos</label>
                    <input type="date" name="res_resource_date" class="form-control" id="fordate" value="{{ $program_resolution->res_resource_date ? $program_resolution->res_resource_date->format('Y-m-d') : '' }}" >
                </fieldset>
            </div>
            
            <button type="submit" class="btn btn-primary ">Actualizar</button>
        </form>

        </div>
    </div>

    <div class="card mt-3 mb-3 small">
        <div class="card-body">
            <h5>Montos <button class="btn btn-sm btn-outline-primary float-right" data-toggle="modal" data-target="#addModalAmount" data-formaction="{{ route('agreements.programs.resolution.amount.store', $program_resolution->id )}}">
                <i class="fas fa-plus"></i> Nuevo monto</button></h5>

            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Componente</th>
                        <th>Subtítulo</th>
                        <th class="text-right">Monto $</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($program_resolution->resolution_amounts as $amount)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $amount->program_component->name }}</td>
                        <td>{{ $amount->subtitle }}</td>
                        <td class="text-right">@numero($amount->amount)</td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                                data-target="#editModalAmount"
                                data-name="{{ $amount->program_component->name }}"
                                data-subtitle="{{ $amount->subtitle }}"
                                data-amount="{{ $amount->amount }}"
                                data-formaction="{{ route('agreements.programs.resolution.amount.update', $amount->id)}}">
                            <i class="fas fa-edit"></i></button>
                        
                            <form method="POST" action="{{ route('agreements.programs.resolution.amount.destroy', $amount->id) }}" class="d-inline">
                                {{ method_field('DELETE') }} {{ csrf_field() }}
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Desea eliminar este item?')"><i class="fas fa-trash-alt"></i></button></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" align="center">No hay registro de montos para esta resolución</td>
                    </tr>
                    @endforelse
                    @if($program_resolution->resolution_amounts->isNotEmpty())
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Total resolución</td>
                        <td class="text-right font-weight-bold">@numero($program_resolution->resolution_amounts->sum('amount'))</td>
                        <td></td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>

    @include('agreements/programs/resolutions/modal_add_amount')
    @include('agreements/programs/resolutions/modal_edit_amount')

@endsection


@section('custom_js')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
    $('[data-toggle="tooltip"]').tooltip()

    $('#addModalAmount').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find("#form-add").attr('action', button.data('formaction'))
    })

    $('#editModalAmount').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="name"]').val(button.data('name'))
        modal.find('#subtitle' + button.data('subtitle')).prop('checked',true);
        modal.find('input[name="amount"]').val(button.data('amount'))

        modal.find("#form-edit").attr('action', button.data('formaction'))
    })
</script>
@endsection
