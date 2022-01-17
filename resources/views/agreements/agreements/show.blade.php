@extends('layouts.app')

@section('title', 'Ver detall de convenio')

@section('content')

@include('agreements/nav')


<h3 class="mb-3">Ver detalle de Convenio #{{$agreement->id}}
    @can('Agreement: delete')
		<form method="POST" action="{{ route('agreements.destroy', $agreement->id) }}" onclick="return confirm('¿Está seguro/a de eliminar este convenio?');" class="d-inline">
			{{ method_field('DELETE') }} {{ csrf_field() }}
			<button class="btn btn-sm btn-danger"><span class="fas fa-trash" aria-hidden="true"></span> Eliminar</button>
		</form>
	@endcan
</h3>

<div class="card">
  <div class="card-header">
    Flujo de firmas
  </div>
  <div class="card-body">
    <!-- <h5 class="card-title">Special title treatment</h5> -->
    <ul class="list-group list-group-horizontal justify-content-center">
        <li class="list-group-item list-group-item-{{$agreement->endorseState}}">1. Visación convenio</li>
        <li class="list-group-item list-group-item-{{$agreement->signState}}">2. Firma convenio</li>
        <li class="list-group-item list-group-item-{{$agreement->resSignState}}">3. Firma resolución</li>
    </ul>
    <br>
    <ul class="list-group list-group-horizontal-sm justify-content-end">
        <li class="list-group-item py-0 list-group-item-success"><small>Aprobada</small></li>
        <li class="list-group-item py-0 list-group-item-warning"><small>Actual</small></li>
        <li class="list-group-item py-0 list-group-item-danger"><small>Rechazada</small></li>
        <li class="list-group-item py-0 list-group-item-secondary"><small>En espera</small></li>
    </ul>
  </div>
</div>

<ol class="breadcrumb bg-light justify-content-end small">
    <li class="nav-item">
        @if($agreement->period >= 2022)
        <a href="#" class="nav-link text-secondary" data-toggle="modal"
                        data-target="#selectEvalOption"
                        data-formaction="{{ route('agreements.createWord', $agreement )}}">
                        <i class="fas fa-file-download"></i> Descargar borrador Convenio</a>
        @else
        <a class="nav-link text-secondary" href="{{ route('agreements.createWord', $agreement) }}"><i class="fas fa-file-download"></i> Descargar borrador Convenio</a>
        @endif
    </li>

    @if($agreement->file != null)
    <li>
        <a class="nav-link text-secondary" href="{{ route('agreements.preview', $agreement->id) }}" target="blank"><i class="fas fa-eye"></i> Previsualizar convenio</a>
    </li>
    @endif

    @canany(['Documents: signatures and distribution'])
    <li class="nav-item">
        <a class="nav-link text-secondary" href="{{ route('agreements.sign', [$agreement, 'visators']) }}"><i class="fas fa-file-signature"></i> Solicitar visación Convenio</a>
    </li>

    @if($agreement->fileToEndorse && $agreement->fileToEndorse->HasAllFlowsSigned)
    <li class="nav-item">
        <a class="nav-link text-secondary" href="{{route('documents.signatures.showPdf', [$agreement->file_to_endorse_id, time()])}}" target="blank"><i class="fas fa-eye"></i> Ver convenio visado</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link text-secondary" href="{{ route('agreements.sign', [$agreement, 'signer']) }}"><i class="fas fa-file-signature"></i> Solicitar firma Convenio</a>
    </li>
    @endif

    @if($agreement->fileToSign && $agreement->fileToSign->HasAllFlowsSigned)
    <li class="nav-item">
        <a class="nav-link text-secondary" href="{{route('documents.signatures.showPdf', [$agreement->file_to_sign_id, time()])}}" target="blank"><i class="fas fa-eye"></i> Ver convenio firmado</a>
    </li>

    <li class="nav-item">
        <a href="#" class="nav-link text-secondary" data-toggle="modal"
                        data-target="#selectSignerRes"
                        data-formaction="{{ route('agreements.createWordRes', $agreement )}}">
                        <i class="fas fa-file-download"></i> Descargar borrador Resolución</a>
    </li>
    @endif

    @if($agreement->fileResEnd != null)
    <li class="nav-item">
        <a class="nav-link text-secondary" href="{{ route('agreements.downloadRes', $agreement->id) }}" target="blank"><i class="fas fa-eye"></i> Ver resolución firmada</a>
    </li>
    @endif

    @endcan
</ol>
<p>

<div id="accordion" class="small">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-xs" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <i class="fas fa-plus"></i> Convenio
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('agreements.update',$agreement->id) }}" >
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="forcommune">Comuna</label>
                    <select name="commune" id="formcommune" class="form-control" disabled>
                        <option>{{ $agreement->commune->name }}</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="foragreement">Programa</label>
                    <select name="agreement" id="formagreement" class="form-control" disabled>
                        <option>{{ $agreement->program->name }}</option>
                    </select>
                </div>
                <fieldset class="form-group col-3">
                    <label for="for">Archivo 
                        @if($agreement->file != null)  
                            <a class="text-info" href="{{ route('agreements.download', $agreement->id) }}" target="_blank">
                                <i class="fas fa-paperclip"></i> adjunto
                            </a>
                        @endif
                    </label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="forfile" name="file">
                      <label class="custom-file-label" for="forfile">Seleccionar Archivo </label>
                     <small class="form-text text-muted">* Adjuntar versión final de Covenio Referentes</small>
                    </div>
                </fieldset>
            </div>
            <div class="form-row">
                <fieldset class="form-group col-3">
                    <label for="fordate">Fecha</label>
                    <input type="date" name="date" class="form-control" id="fordate" value="{{ $agreement->date }}" >
                    <small class="form-text text-muted">* Fecha del convenio</small>
                </fieldset>

                <fieldset class="form-group col-4">
                    <label for="forreferente">Referente</label>
                    <!-- <input type="text" name="referente" class="form-control" id="forreferente" value="{{ $agreement->referente }}" > -->
                    <select name="referrer_id" class="form-control selectpicker" data-live-search="true" title="Seleccione referente" required>
                        @foreach($referrers as $referrer)
                        <option value="{{$referrer->id}}" @if(isset($agreement->referrer->id) && $referrer->id == $agreement->referrer->id) selected @endif>{{$referrer->fullName}}</option>
                        @endforeach
                    </select>
                </fieldset>

                <fieldset class="form-group col-5">
                    <label for="forestablishment">Centros de Atencion</label>
                    <select id="establishment" class="selectpicker " name="establishment[]" title="Seleccionar" data-selected-text-format="count > 2" data-width="100%" multiple>
                    @foreach($agreement->commune->establishments as $key => $establishment)
                      <option value="{{ $establishment->id }}">{{ $establishment->type }} - {{ $establishment->name }}</option>
                    @endforeach
                    </select>
                    <small class="form-text text-muted">* Seleccionar uno o más centros de atención</small>
                </fieldset>
            </div>
            <div class="form-row">
                <fieldset class="form-group col-12">
                <label for="forrepresentative">Director/a a cargo</label>
                        <select name="director_signer_id" class="form-control selectpicker" title="Seleccione..." required>
                            @foreach($signers as $signer)
                            <option value="{{$signer->id}}" @if($signer->id == $agreement->director_signer_id) selected @endif>{{$signer->appellative}} {{$signer->user->fullName}}, {{$signer->decree}}</option>
                            @endforeach
                        </select>
                </fieldset>
            </div>
            <div class="form-row">
                <fieldset class="form-group col-4">
                    <label for="forrepresentative">Representante alcalde</label>
                    <select id="representative" class="selectpicker" name="representative" title="Seleccionar" data-width="100%">
                      <option value="{{ $municipality->name_representative }}" @if($municipality->name_representative == $agreement->representative) selected @endif>{{ $municipality->name_representative }}</option>
                      @if($municipality->name_representative_surrogate != null) <option value="{{ $municipality->name_representative_surrogate }}" @if($municipality->name_representative_surrogate == $agreement->representative) selected @endif>{{ $municipality->name_representative_surrogate }}</option> @endif
                      @if($agreement->representative != null && $agreement->representative != $municipality->name_representative && $agreement->representative != $municipality->name_representative_surrogate) <option value="{{ $agreement->representative }}" selected>{{ $agreement->representative }}</option> @endif
                    </select>   
                    <!-- <small class="form-text text-muted">Ej: Alcalde Subrogante Don Nombre Apellidos</small> -->
                </fieldset>
                <fieldset class="form-group col-2">
                    <label for="fornumber">Rut Representante</label>
                    <input type="text" name="representative_rut" class="form-control" id="representative_rut" value="{{ $agreement->representative_rut }}" readonly>
                </fieldset>
                <fieldset class="form-group col-6">
                    <label for="fornumber">Decreto representante</label>
                    <input type="text" name="representative_decree" class="form-control" id="representative_decree" value="{{$agreement->representative_decree}}" readonly>
                </fieldset>
                <input type="hidden" name="representative_appelative" id="representative_appelative" value="{{$agreement->representative_appelative}}">
            </div>

            <div class="form-row">
                <fieldset class="form-group col-4">
                    <label for="fornumber">Municipio</label>
                    <input type="integer" name="municipality_name" class="form-control" id="municipality_name" value="{{ $municipality->name_municipality }}" readonly>
                </fieldset>
                 <fieldset class="form-group col-2">
                    <label for="fornumber">Rut Municipalidad</label>
                    <input type="integer" name="municipality_rut" class="form-control" id="municipality_rut" value="{{ $agreement->municipality_rut }}" readonly>
                </fieldset>
                <fieldset class="form-group col-6">
                    <label for="fornumber">Dirección Municipalidad</label>
                    <input type="integer" name="municipality_adress" class="form-control" id="municipality_adress" value="{{ $agreement->municipality_adress }}" readonly>
                </fieldset>
            </div>

            <hr class="mt-2 mb-3"/>
            <div class="form-row">
                <fieldset class="form-group col-3">
                    <label for="fornumber">Número Resolución del Programa Ministerial</label>
                    <input type="integer" name="number" class="form-control" id="fornumber" value="{{ $agreement->number }}" >
                    <small class="form-text text-muted">* Nro. Resolución, se puede agregar al final.</small>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="fordate">Fecha Resolución del Programa Ministerial</label>
                    <input type="date" name="resolution_date" class="form-control" id="fordate" value="{{ $agreement->resolution_date }}" >
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="fornumber">Número Resolución Distribuye Recursos</label>
                    <input type="integer" name="res_resource_number" class="form-control" id="fornumber" value="{{ $agreement->res_resource_number }}" >
                    <small class="form-text text-muted">* Nro. Resolución, se puede agregar al final.</small>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="fordate">Fecha Resolución Distribuye Recursos</label>
                    <input type="date" name="res_resource_date" class="form-control" id="fordate" value="{{ $agreement->res_resource_date }}" >
                </fieldset>
            </div>
            <hr class="mt-2 mb-3"/>
            <div class="form-row">
                <fieldset class="form-group col-3">
                    <label for="fornumber">Número Resolución Exenta del Convenio</label>
                    <input type="integer" name="res_exempt_number" class="form-control" id="fornumber" value="{{ $agreement->res_exempt_number }}" >
                    <small class="form-text text-muted">* Nro. Resolución Exenta, se puede agregar al final.</small>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="fordate">Fecha Resolución Exenta del Convenio</label>
                    <input type="date" name="res_exempt_date" class="form-control" id="fordate" value="{{ $agreement->res_exempt_date }}" >
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for">Archivo Resolución Final PDF SSI
                         @if($agreement->fileResEnd != null)  
                            <a class="text-info" href="{{ route('agreements.downloadRes', $agreement->id) }}" target="_blank">
                                <i class="fas fa-paperclip"></i> adjunto
                            </a>
                        @endif
                    </label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="forfile" name="fileResEnd">
                      <label class="custom-file-label" for="forfile">Seleccionar Archivo </label>
                     <small class="form-text text-muted">* Adjuntar versión final de Resolución Función Exclusiva Encargado de Convenio</small>
                    </div>
                </fieldset>
            </div>
            <button type="submit" class="btn btn-primary ">Actualizar</button>
        </form>

      </div>
    </div>
  </div>
</div>

    <div class="card mt-3 mb-3 small">
        <div class="card-body">
            <h5>Montos</h5>

            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Componente</th>
                        <th>Subtítulo</th>
                        <th class="text-right">Monto $</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agreement->agreement_amounts as $key=>$amount)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{ $amount->program_component->name }}</td>
                        <td>{{ $amount->subtitle }}</td>
                        <td class="text-right">@numero($amount->amount)</td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                                data-target="#editModalAmount"
                                data-name="{{ $amount->program_component->name }}"
                                data-subtitle="{{ $amount->subtitle }}"
                                data-amount="{{ $amount->amount }}"
                                data-formaction="{{ route('agreements.amount.update', $amount->id)}}">
                            <i class="fas fa-edit"></i></button>
                        
                            <form method="POST" action="{{ route('agreements.amount.destroy', $amount->id) }}" class="d-inline">
                                {{ method_field('DELETE') }} {{ csrf_field() }}
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Desea eliminar el componente realmente?')"><i class="fas fa-trash-alt"></i></button></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Total convenio</td>
                        <td class="text-right font-weight-bold">@numero($agreement->agreement_amounts->sum('amount'))</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

    <div class="card mt-3 small">
        <div class="card-body">
            <h5>Cuotas <form method="POST" action="{{ route('agreements.quotaAutomatic.update', $agreement->id) }}" class="d-inline float-right small">
                {{ method_field('PUT') }} {{ csrf_field() }}
                <button class="btn btn-sm btn-outline-primary" onclick="return confirm('¿Desea realmente calcular las cuotas automaticamente?')"><i class="fas fa-sync"></i> Calculo Automático</button></button> <!-- onclick="return confirm('¿Desea eliminar el componente realmente?')-->
            </form></h5>

            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Descripción</th>
                        <th>Porcentaje</th>
                        <th class="text-right">Monto $</th>
                        <th class="text-center">Fecha Transferencia</th>
                        <th>Comprobante</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agreement->agreement_quotas as $key=>$quota)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{ $quota->description }}</td>
                        <td>{{ $quota->percentage }}{{ $quota->percentage ? '%' : '' }}</td>
                        <td class="text-right">@numero($quota->amount)</td>
                        <td class="text-center">{{ $quota->transfer_at ? $quota->transfer_at->format('d-m-Y') : '' }}</td>
                        <td>{{ $quota->voucher_number }}</td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                                data-target="#editModalQuota"
                                data-description="{{ $quota->description }}"
                                data-amount="{{ $quota->amount }}"
                                data-transfer_at="{{ $quota->transfer_at ? $quota->transfer_at->format('Y-m-d') : '' }}"
                                data-voucher_number="{{ $quota->voucher_number }}"
                                data-formaction="{{ route('agreements.quota.update', $quota->id)}}">
                            <i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    @if($agreement->fileResEnd != null)
    <div class="card mt-3 small">
        <div class="card-body">
            <h5>Addendums
            <button class="btn btn-sm btn-outline-primary float-right" data-toggle="modal"
                                data-target="#addModalAddendum"
                                data-formaction="{{ route('agreements.addendums.store' )}}">
                            <i class="fas fa-plus"></i> Nuevo Addendum</button></h5>

            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Fecha</th>
                        <th>Referente</th>
                        <th>Director/a a cargo</th>
                        <th>Representante alcalde</th>
                        <th>Fecha Res.</th>
                        <th>N° Res.</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agreement->addendums as $addendum)
                    <tr>
                        <td>{{ $addendum->id }}</td>
                        <td>{{ $addendum->date ? $addendum->date->format('d-m-Y') : '' }}</td>
                        <td>{{ $addendum->referrer->fullName ?? ''}}</td>
                        <td>{{ $addendum->director_signer->user->fullName ?? '' }}</td>
                        <td>{{ $addendum->representative }}</td>
                        <td>{{ $addendum->res_date ? $addendum->res_date->format('d-m-Y') : '' }}</td>
                        <td>{{ $addendum->res_number }}
                            @if($addendum->res_file)
                             <a class="text-info" href="{{ route('agreements.addendum.downloadRes', $addendum) }}" target="_blank">
                                <i class="fas fa-paperclip"></i>
                            </a>
                            @endif
                        </td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                                data-target="#editModalAddendum"
                                data-referrer_id="{{$addendum->referrer_id}}"
                                data-director_signer_id="{{$addendum->director_signer_id}}"
                                data-representative="{{$addendum->representative}}"
                                data-date="{{ $addendum->date ? $addendum->date->format('Y-m-d') : '' }}"
                                data-res_number="{{ $addendum->res_number }}"
                                data-res_date="{{ $addendum->res_date ? $addendum->res_date->format('Y-m-d') : '' }}"
                                data-formaction="{{ route('agreements.addendums.update', $addendum )}}">
                            <i class="fas fa-edit"></i></button>
                            <a class="btn btn-sm btn-outline-secondary" href="#" data-toggle="tooltip" data-placement="top" title="Descargar borrador Addendum"
                                onclick="event.preventDefault(); document.getElementById('submit-form-addendum-{{$addendum->id}}').submit();"><i class="fas fa-file-download"></i></a>
                            <form id="submit-form-addendum-{{$addendum->id}}" action="{{ route('agreements.addendum.createWord', [$addendum, 'addendum']) }}" method="POST" hidden>@csrf</form>
                            @if($addendum->file != null)
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('agreements.addendum.preview', $addendum) }}" target="blank" data-toggle="tooltip" data-placement="top" title="Previsualizar Addendum"><i class="fas fa-eye"></i></a>
                            @endif
                            @canany(['Documents: signatures and distribution'])
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('agreements.addendum.sign', [$addendum, 'visators']) }}" data-toggle="tooltip" data-placement="top" title="Solicitar visación Addendum"><i class="fas fa-file-signature"></i></a>
                            @if($addendum->fileToEndorse && $addendum->fileToEndorse->HasAllFlowsSigned)
                            <a class="btn btn-sm btn-outline-secondary" href="{{route('documents.signatures.showPdf', [$addendum->file_to_endorse_id, time()])}}" target="blank" data-toggle="tooltip" data-placement="top" title="Ver addendum visado"><i class="fas fa-eye"></i></a> 
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('agreements.addendum.sign', [$addendum, 'signer']) }}" data-toggle="tooltip" data-placement="top" title="Solicitar firma Addendum"><i class="fas fa-file-signature"></i></a> 
                            @endif
                            @if($addendum->fileToSign && $addendum->fileToSign->HasAllFlowsSigned)
                            <a class="btn btn-sm btn-outline-secondary" href="{{route('documents.signatures.showPdf', [$addendum->file_to_sign_id, time()])}}" target="blank" data-toggle="tooltip" data-placement="top" title="Ver addendum firmado"><i class="fas fa-eye"></i></a> 
                            <span data-toggle="modal" data-target="#selectSignerRes" data-formaction="{{ route('agreements.addendum.createWord', [$addendum, 'res'] )}}">
                                <a href="#" class="btn btn-sm btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Descargar borrador Resolución Addendum"><i class="fas fa-file-download"></i></a>
                            </span>
                            @endif
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        
    </div>
    
    @endif

    @include('agreements/agreements/modal_edit_amount')
    @include('agreements/agreements/modal_edit_quota')
    @include('agreements/agreements/modal_add_addendum')
    @include('agreements/agreements/modal_edit_addendum')
    @include('agreements/agreements/modal_select_signer_res')
    @include('agreements/agreements/modal_select_evaluation_option')

@endsection

@section('custom_js')
<!-- <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script> -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        //var jobs = JSON.parse("{{!! json_encode($establishment_list) !!}}");
        var jobs =  @json($establishment_list);
        //console.log(jobs);
        $('select').selectpicker();

        jobs.forEach(function(row) {
         //console.log(row);
            $("#establishment option").filter(function(){
                return $.trim($(this).val()) ==  row
            }).prop('selected', true);

        });
        $('#establishment').selectpicker('refresh')


    });

    $('#editModalAmount').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="name"]').val(button.data('name'))
        modal.find('#subtitle' + button.data('subtitle')).prop('checked',true);
        modal.find('input[name="amount"]').val(button.data('amount'))

        modal.find("#form-edit").attr('action', button.data('formaction'))
    })

    $('#editModalQuota').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="description"]').val(button.data('description'))
        modal.find('input[name="amount"]').val(button.data('amount'))
        modal.find('input[name="transfer_at"]').val(button.data('transfer_at'))
        modal.find('input[name="voucher_number"]').val(button.data('voucher_number'))

        modal.find("#form-edit").attr('action', button.data('formaction'))
    })

    $('#addModalAddendum').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find("#form-add").attr('action', button.data('formaction'))
    })

    $('#editModalAddendum').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="date"]').val(button.data('date'))
        modal.find('select[name="referrer_id"]').val(button.data('referrer_id'))
        modal.find('select[name="director_signer_id"]').val(button.data('director_signer_id'))
        modal.find('select[name="representative"]').val(button.data('representative'))
        modal.find('input[name="res_number"]').val(button.data('res_number'))
        modal.find('input[name="res_date"]').val(button.data('res_date'))
        
        modal.find("#form-edit").attr('action', button.data('formaction'))
        modal.find('.selectpicker').selectpicker('refresh')
    })

    $('#selectSignerRes,#selectEvalOption').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)
        modal.find("#form-edit").attr('action', button.data('formaction'))
    })

    $('#SubmitSignerSelected,#SubmitEvalSelected').click(function() {
        $('#selectSignerRes, #selectEvalOption').modal('hide');
    })

    // $('#authority_id').on('change', function(e){
    //     var selected = this.value;
    //     var ruts = {{-- $authorities->map(function ($authority) { return ['id' => $authority->id , 'rut' => $authority->user->runFormat(), 'decree' => $authority->decree];})->toJson() --}};
    //     $("#authority_rut").val(ruts.find(item => item.id == selected).rut)
    //     $("#authority_decree").val(ruts.find(item => item.id == selected).decree)
    // })

    $('#representative').on('change', function(e){
        var selected = this.selectedIndex - 1;
        var ruts = new Array();
        var appelatives = new Array();
        var decrees = new Array();
        //Alcalde actual
        ruts.push(@json($municipality->rut_representative))
        appelatives.push('Alcalde Don')
        decrees.push(@json($municipality->decree_representative))
        // alcalde subrogante actual
        if(@json($municipality->rut_representative_surrogate) != null){ 
            ruts.push(@json($municipality->rut_representative_surrogate))
            appelatives.push('Alcalde Subrogante Don')
            decrees.push(@json($municipality->decree_representative_surrogate))
        }
        // alcalde registrado al momento de completar el convenio pero que no es igual al alcalde ni al subrogante actual
        if(@json($agreement->representative) != null && @json($agreement->representative) != @json($municipality->name_representative) && @json($agreement->representative) != @json($municipality->name_representative_surrogate)){ 
            ruts.push(@json($agreement->representative_rut))
            appelatives.push(@json($agreement->representative_appelative))
            decrees.push(@json($agreement->representative_decree))
        }
        $("#representative_rut").val(ruts[selected])
        $("#representative_appelative").val(appelatives[selected])
        $("#representative_decree").val(decrees[selected])
    })
</script>
@endsection
