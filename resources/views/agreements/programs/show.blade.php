@extends('layouts.bt4.app')

@section('title', 'Programa '.$program->name)

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Programa {{$program->name}}</h3>

<div class="card mt-3 mb-3 small">
    <div class="card-body">
        <h5>Componentes</h5>

        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($program->components as $component)
                <tr>
                    <td>{{$component->id}}</td>
                    <td>{{$component->name }}</td>
                    <td></td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" align="center">No hay registro de componentes para este programa</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-3 mb-3 small">
    <div class="card-body">
        <h5>Disponibilidad Presupuestaria <button class="btn btn-sm btn-outline-primary float-right" data-toggle="modal" data-target="#addModalBudgetAvailability" data-formaction="{{ route('agreements.programs.budget_availability.store' )}}">
                <i class="fas fa-plus"></i> Nueva Disponibilidad presupuestaria</button></h5>

        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Fecha Res. Minsal</th>
                    <th>N° Res. Minsal</th>
                    <th>Referente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($program->budget_availabilities as $budget_availability)
                <tr>
                    <td>{{ $budget_availability->id }}</td>
                    <td>{{ $budget_availability->date ? $budget_availability->date->format('d-m-Y') : '' }}</td>
                    <td>{{ $budget_availability->res_minsal_date ? $budget_availability->res_minsal_date->format('d-m-Y') : '' }}</td>
                    <td>{{ $budget_availability->res_minsal_number }}</td>
                    <td>{{ $budget_availability->referrer->fullName ?? ''}}</td>
                    <td>
                    <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#editModalBudgetAvailability-{{$budget_availability->id}}">
                                <i class="fas fa-edit"></i></button>
                                @include('agreements/programs/modal_edit_budget_availability')
                    @can('Agreement: delete')
                    <form method="POST" action="{{ route('agreements.programs.budget_availability.destroy', $budget_availability) }}" class="d-inline">
                        {{ method_field('DELETE') }} {{ csrf_field() }}
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Desea dar de baja esta disponibilidad presupuestaria?')"><i class="fas fa-trash-alt"></i></button></button>
                    </form>
                    @endcan
                    <a class="btn btn-sm btn-outline-secondary" href="#" data-toggle="tooltip" data-placement="top" title="Crear nuevo borrador certificado disponibilidad presupuestaria"
                                    onclick="event.preventDefault(); document.getElementById('submit-form-budget-{{$budget_availability->id}}').submit();"><i class="fas fa-file-medical"></i></a>
                                <form id="submit-form-budget-{{$budget_availability->id}}" action="{{ route('agreements.programs.budget_availability.createDocument', $budget_availability) }}" method="POST" hidden>@csrf</form>
                    @if($budget_availability->document_id != null)
                        <a href="{{ route('documents.edit', $budget_availability->document_id) }}" class="btn btn-sm btn-outline-secondary" target="_blank" data-toggle="tooltip" data-placement="top" title="Editar borrador certificado disponibilidad presupuestaria"><i class="fas fa-file-alt"></i></a> 
                        <a href="{{ route('documents.show', $budget_availability->document_id) }}" class="btn btn-sm btn-outline-secondary" target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar borrador certificado disponibilidad presupuestaria"><i class="fas fa-eye"></i></a>
                    @endif
                    @canany(['Documents: signatures and distribution'])
                        @if($budget_availability->document_id != null)
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('documents.sendForSignature', $budget_availability->document_id) }}" data-toggle="tooltip" data-placement="top" title="Solicitar firma Certificado disponibilidad presupuestaria"><i class="fas fa-file-signature"></i></a>
                        @endif
                    @endcan
                    @if($budget_availability->document && $budget_availability->document->fileToSign)
                        @if($budget_availability->document->fileToSign->hasSignedFlow)
                        <a href="{{ route('documents.signedDocumentPdf', $budget_availability->document_id) }}" class="btn btn-sm @if($budget_availability->document->fileToSign->hasAllFlowsSigned) btn-outline-success @else btn-outline-primary @endif" target="_blank" data-toggle="tooltip" data-placement="top" title="Ver Certificado Disponibilidad Presupuestaria firmada">
                            <i class="fas fa-fw fa-file-contract"></i> </a>
                        @else
                            {{ $budget_availability->document->fileToSign->signature_id }}
                        @endif
                    @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" align="center">No hay registro de disponibilidad presupuestaria para este programa</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-3 mb-3 small">
    <div class="card-body">
        <h5>Resoluciones <button class="btn btn-sm btn-outline-primary float-right" data-toggle="modal" data-target="#addModalProgramResolution" data-formaction="{{ route('agreements.programs.resolutions.store' )}}">
                <i class="fas fa-plus"></i> Nueva resolución</button></h5>

        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Fecha Res.</th>
                    <th>N° Res.</th>
                    <th>Referente</th>
                    <th>Director/a a cargo</th>
                    <th>Establecimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($program->resolutions as $resolution)
                <tr>
                    <td>{{ $resolution->id }}</td>
                    <td>{{ $resolution->date ? $resolution->date->format('d-m-Y') : '' }}</td>
                    <td>{{ $resolution->number }}
                        @if($resolution->file)
                        <a class="text-info" href="{{ route('agreements.programs.resolution.download', $resolution) }}" target="_blank">
                            <i class="fas fa-paperclip"></i>
                        </a>
                        @endif
                    </td>
                    <td>{{ $resolution->referrer->fullName ?? ''}}</td>
                    <td>{{ $resolution->director_signer->user->fullName ?? '' }}</td>
                    <td>{{ $resolution->establishment}}</td>
                    <td><a class="btn btn-sm btn-outline-secondary" href="{{ route('agreements.programs.resolutions.show', $resolution) }}"><i class="fas fa-edit"></i></a> 
                    @can('Agreement: delete')
                    <form method="POST" action="{{ route('agreements.programs.resolutions.destroy', $resolution) }}" class="d-inline">
                        {{ method_field('DELETE') }} {{ csrf_field() }}
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Desea dar de baja esta resolución?')"><i class="fas fa-trash-alt"></i></button></button>
                    </form>
                    @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" align="center">No hay registro de resoluciones para este programa</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@livewire('agreements.add-quotas-minsal',['program' => $program])

@include('agreements/programs/modal_add_resolution')
@include('agreements/programs/modal_add_budget_availability')

@endsection


@section('custom_js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
    $('#addModalProgramResolution').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal = $(this)

        modal.find("#form-add").attr('action', button.data('formaction'))
    })

    $('#addModalBudgetAvailability').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal = $(this)

        modal.find("#form-add2").attr('action', button.data('formaction'))
    })
</script>

@endsection