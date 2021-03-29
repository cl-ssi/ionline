@extends('layouts.app')

@section('title', 'Ver detall de convenio')

@section('content')

@include('agreements/nav')


<h3 class="mb-3">Ver detalle de Convenio</h3> 
    
    @can('Agreement: delete')
		<form method="POST" action="{{ route('agreements.destroy', $agreement->id) }}" class="d-inline">
			{{ method_field('DELETE') }} {{ csrf_field() }}
			<button class="btn btn-sm btn-danger"><span class="fas                                                                                                                                                                                    fa-trash" aria-hidden="true"></span> Eliminar</button>
		</form>
	@endcan

<ol class="breadcrumb bg-light justify-content-end small">
    <li class="nav-item">
        <a class="nav-link text-secondary" href="{{ route('agreements.createWord', $agreement) }}"><i class="fas fa-eye"></i> Previsualizar Convenio</a>
    </li>
</ol>
<p>
{{-- $municipality --}}

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
                    <input type="text" name="referente" class="form-control" id="forreferente" value="{{ $agreement->referente }}" >
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
                <fieldset class="form-group col-4">
                    <label for="for_authority">Director/a a cargo según fecha convenio</label>
                    {{--<select id="authority_id" class="selectpicker" name="authority_id" title="Seleccionar" data-width="100%" required>
                      @foreach($authorities as $authority)
                      @if($authority->id == $agreement->authority_id) {{$selected_authority = $authority}} @endif
                      <option value="{{ $authority->id }}" @if($authority->id == $agreement->authority_id) selected @endif>{{ $authority->user->full_name }}</option>
                      @endforeach
                    </select>  --}}
                    <input type="text" name="authority_name" class="form-control" id="authority_name" value="{{$agreement->authority->user->full_name}}" readonly>
                </fieldset>
                <fieldset class="form-group col-2">
                    <label for="fornumber">Rut director/a</label>
                    <input type="text" name="authority_rut" class="form-control" id="authority_rut" value="{{$agreement->authority->user->runFormat()}}" readonly>
                </fieldset>
                <fieldset class="form-group col-6">
                    <label for="fornumber">Decreto director/a</label>
                    <input type="text" name="authority_decree" class="form-control" id="authority_decree" value="{{$agreement->authority->decree}}" readonly>
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
                    <label for="fornumber">Número Resolución Exenta del Convenio</label>
                    <input type="integer" name="res_exempt_number" class="form-control" id="fornumber" value="{{ $agreement->res_exempt_number }}" >
                    <small class="form-text text-muted">* Nro. Resolución Exenta, se puede agregar al final.</small>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="fordate">Fecha Resolución Exenta del Convenio</label>
                    <input type="date" name="res_exempt_date" class="form-control" id="fordate" value="{{ $agreement->res_exempt_date }}" >
                </fieldset>
            </div>
            <hr class="mt-2 mb-3"/>
            <div class="form-row">
                <fieldset class="form-group col-3">
                    <label for="fornumber">Número Resolución Distribuye Recursos</label>
                    <input type="integer" name="res_resource_number" class="form-control" id="fornumber" value="{{ $agreement->res_resource_number }}" >
                    <small class="form-text text-muted">* Nro. Resolución, se puede agregar al final.</small>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="fordate">Fecha Resolución Distribuye Recursos</label>
                    <input type="date" name="res_resource_date" class="form-control" id="fordate" value="{{ $agreement->res_resource_date }}" >
                </fieldset>

                <!-- <fieldset class="form-group col-3">
                    <label for="for">Archivo Convenio PDF
                        @if($agreement->fileAgreeEnd != null)  
                            <a class="text-info" href="{{ route('agreements.downloadAgree', $agreement->id) }}" target="_blank">
                                <i class="fas fa-paperclip"></i> adjunto
                            </a>
                        @endif
                    </label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="forfile" name="fileAgreeEnd">
                      <label class="custom-file-label" for="forfile">Seleccionar Archivo </label>
                     <small class="form-text text-muted">* Adjuntar versión final de Covenio</small>
                    </div>
                </fieldset> -->
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

<!--<div class="card mt-3 mb-3">
    <div class="card-body">

        <h5>Ciclo de Vida de un convenio</h5>

        <div class="container mt-3 small">
            <div class="row">
                <div class="col-sm border border-light">
                    <strong>Enc. Convenio</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'RTP' AND $stage->group == 'CON')
                            <b>·</b> {{$stage->date->format('d-m-Y')}}<br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>Jefe APS</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAJ' AND $stage->group == 'CON')
                            <b>·</b> {{ $stage->date->format('d-m-Y') }}<br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>Jurídico</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAP' AND $stage->group == 'CON')
                            <b>·</b> {{ $stage->date->format('d-m-Y') }}<br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>Finanzas</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DGF' AND $stage->group == 'CON')
                            <b>·</b> {{$stage->date->format('d-m-Y')}} <br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>SDGA</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'SDGA' AND $stage->group == 'CON')
                            <b>·</b> {{ $stage->date->format('d-m-Y') }} <br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>Envío Comuna</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'Comuna' AND $stage->group == 'CON')
                            <b>·</b> {{$stage->date->format('d-m-Y')}} <br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>Devuelto Comuna</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'Devuelto Comuna')
                            <b>·</b> {{$stage->date->format('d-m-Y')}} <br>
                            {{ $stage->observation}}<br>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <form method="POST" class="form-horizontal" action="{{ route('agreements.stage.store') }}">
            @csrf
            @method('POST')
            <input type="hidden" name="agreement_id" value="{{$agreement->id}}">
            <input type="hidden" name="group" value="CON">

            <div class="row mt-3">
                <div class="col-2">
                    <select class="form-control" name="type">
                        <option >RTP</option>
                        <option >DAJ</option>
                        <option >DAP</option>
                        <option >DGF</option>
                        <option >SDGA</option>
                        <option value="Comuna">COMUNA</option>
                    </select>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" id="forDate" name="date" required>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" id="forDate" name="dateEnd" >
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="forObservation"
                        placeholder="Comentarios" name="observation">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </form>

    </div>
</div>-->

<!-- RESOLUTION SECTION -->
<!--<div class="card mt-3 mb-3">
    <div class="card-body">

        <h5>Ciclo de Vida de un convenio - Resolución</h5>

        <div class="container mt-3 small">
            <div class="row">
                <div class="col-sm border border-light">
                    <strong>Enc. Convenio</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'RTP' AND $stage->group == 'RES')
                            <b>·</b> {{$stage->date->format('d-m-Y')}}<br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>Jefe APS</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAJ' AND $stage->group == 'RES')
                            <b>·</b> {{ $stage->date->format('d-m-Y') }}<br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>Jurídico</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAP' AND $stage->group == 'RES')
                            <b>·</b> {{ $stage->date->format('d-m-Y') }}<br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>Finanzas</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DGF' AND $stage->group == 'RES')
                            <b>·</b> {{$stage->date->format('d-m-Y')}} <br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>SDGA</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'SDGA' AND $stage->group == 'RES')
                            <b>·</b> {{ $stage->date->format('d-m-Y') }} <br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>Envío Comuna</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'Comuna' AND $stage->group == 'RES')
                            <b>·</b> {{$stage->date->format('d-m-Y')}} <br>
                            {{ $stage->observation }}<br>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm border border-light">
                    <strong>Devuelto Comuna</strong><br>
                    @foreach($agreement->stages as $stage)
                        @if($stage->type == 'Devuelto Comuna' AND $stage->group == 'RES')
                            <b>·</b> {{$stage->date->format('d-m-Y')}} <br>
                            {{ $stage->observation}}<br>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <form method="POST" class="form-horizontal" action="{{ route('agreements.stage.store') }}">
            @csrf
            @method('POST')
            <input type="hidden" name="agreement_id" value="{{$agreement->id}}">
            <input type="hidden" name="group" value="RES">

            <div class="row mt-3">
                <div class="col-2">
                    <select class="form-control" name="type">
                        <option value="RTP">RTP</option>
                        <option value="DAJ">DAJ</option>
                        <option value="DAP">DAP</option>
                        <option value="DGF">DGF</option>
                        <option value="SDGA">SDGA</option>
                        <option value="OfParte">OF. PARTE</option>
                    </select>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" id="forDate" name="date" required>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" id="forDate" name="dateEnd" >
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="forObservation"
                        placeholder="Comentarios" name="observation">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </form>

    </div>
</div><!-- END RESOLUTION SECTION --> 
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
        <div class="card-header">
            <form method="POST" action="{{ route('agreements.quotaAutomatic.update', $agreement->id) }}" class="d-inline float-right">
                {{ method_field('PUT') }} {{ csrf_field() }}
                <button class="btn btn-sm btn-outline-primary" onclick="return confirm('¿Desea realmente calcular las cuotas automaticamente?')"><i class="fas fa-sync"></i> Calculo Automático</button></button> <!-- onclick="return confirm('¿Desea eliminar el componente realmente?')-->
            </form>
        </div>
        <div class="card-body">
            <h5>Cuotas</h5>

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


@foreach($agreement->stages as $stage)
    @if($stage->type == 'OfParte' AND $stage->group == 'RES' AND $stage->dateEnd != null)
    <div class="card mt-3 small">
        <div class="card-body">
            <h5>Addendum</h5>

            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Número</th>
                        <th>Fecha</th>
                        <th>Ingresado</th>
                        <th>Archivo Addeundum</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agreement->addendums as $addendum)
                    <tr>
                        <td>{{ $addendum->id }}</td>
                        <td>{{ $addendum->number }}</td>
                        <td>{{ $addendum->date->format('d-m-Y') }}</td>
                        <td>{{ $addendum->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                             <a class="text-info" href="{{ route('agreements.addendum.download', $addendum->id) }}" target="_blank">
                                <i class="fas fa-paperclip"></i> Adjunto
                            </a>
                        </td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                                data-target="#editModalAddendum"
                                data-number="{{ $addendum->number }}"
                                data-date="{{ $addendum->date->format('Y-m-d') }}"
                                data-formaction="{{ route('agreements.addendums.update', $addendum->id )}}">
                            <i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($agreement->addendums->isEmpty())
            <form method="POST" class="form-horizontal" action="{{ route('agreements.addendums.store') }}" enctype="multipart/form-data">
                <div class="form-row">

                    @csrf
                    @method('POST')
                    <input type="hidden" name="agreement_id" value="{{$agreement->id}}">

                    <fieldset class="form-group col-3">
                        <label for="fornumber">Número</label>
                        <input type="integer" class="form-control" id="fornumber" placeholder="Número de resolución" name="number" required="required">
                    </fieldset>

                    <fieldset class="form-group col-3">
                        <label for="fordate">Fecha</label>
                        <input type="date" class="form-control" id="fordate" name="date" required="required">
                    </fieldset>

                    <fieldset class="form-group col-6">
                        <label for="fordate">Archivo</label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="customFile" name="file">
                          <label class="custom-file-label" for="customFile">Addendum</label>
                        </div>
                    </fieldset>

                </div>

                <button type="submit" class="btn btn-primary">Agregar</button>

            </form>
           
        </div>
         @endif

        
    </div>
    
    @endif
    
@endforeach

    @include('agreements/agreements/modal_edit_amount')
    @include('agreements/agreements/modal_edit_quota')
    @include('agreements/agreements/modal_edit_addendum')

@endsection

@section('custom_js')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
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

    $('#editModalAddendum').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="number"]').val(button.data('number'))
        modal.find('input[name="date"]').val(button.data('date'))

        modal.find("#form-edit").attr('action', button.data('formaction'))
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
