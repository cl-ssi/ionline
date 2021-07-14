@extends('layouts.app')

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

@include('agreements/programs/modal_add_resolution')

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
</script>

@endsection