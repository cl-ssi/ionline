@extends('layouts.bt4.app')

@section('title', 'Documentos Adjuntos Comunales')

@section('content')


<h3 class="mb-3">Documentos Comunales {{$year}} - Evaluación General
<form class="form-inline float-right small" method="GET" action="{{ route('communefiles.index') }}">
    <select name="year" class="form-control" onchange="this.form.submit()">
                    @foreach(range(2021, date('Y') + 1) as $anio)
                        <option value="{{ $anio }}" {{ request()->anio == $anio || $year == $anio ? 'selected' : '' }}>{{ $anio }}</option>
                    @endforeach
    </select>
</form>
</h3> 
 <!-- Permiso para crear nueva programación númerica -->
 @can('Communefiles: create')
    <a href="{{ route('communefiles.create') }}" class="btn btn-info mb-4">Comenzar Documentos Comunales</a>
 @endcan


<table class="table table-sm  ">
    <thead>
        <tr class="small ">
            @can('Communefiles: edit')<th class="text-left align-middle table-dark" ></th>@endcan
            <th class="text-left align-middle table-dark" >Id</th> 
            <th class="text-left align-middle table-dark" >Año</th>
            <th class="text-left align-middle table-dark" >Comuna</th>
            <th class="text-left align-middle table-dark" >Descripción</th>
            <th class="text-left align-middle table-dark" >Diagnostico</th>
            <th class="text-left align-middle table-dark" >Matriz de Cuidado</th>
            <th class="text-left align-middle table-dark" >Documento Alcaldicio</th>
            <th class="text-center align-middle table-dark">Opciones</th>
        </tr>
    </thead>
    <tbody class="small align-middle  ">
        @foreach($communeFiles as $communeFile)
        <tr class="small">
        <!-- Permiso para editar programación númerica -->
            @if(auth()->user()->can('Communefiles: edit'))
            <td >
                @if($communeFile->programming_status == 'active')
                <a href="{{ route('communefiles.show', $communeFile->id) }}" class="btn btb-flat btn-sm btn-light" >
                    <i class="fas fa-edit"></i></a>
                @endif
            </td>
            @endif
            <td >{{ $communeFile->id }}</td>
            <td>{{ $communeFile->year }}</td>
            <td>{{ $communeFile->commune->name }}</td>
            <td>{{ $communeFile->description }}</td>
            <td>
                <label for="for">
                    @if($communeFile->file_a != null)  
                        <a class="text-info" href="{{ route('programmingFile.download', $communeFile->id) }}" target="_blank">
                            <i class="fas fa-download"></i> Ver
                        </a>
                    @endif
                </label>
            </td>
            <td>
                <label for="for">
                    @if($communeFile->file_b != null)  
                        <a class="text-info" href="{{ route('programmingFile.downloadFileB', $communeFile->id) }}" target="_blank">
                            <i class="fas fa-download"></i> Ver
                        </a>
                    @endif
                </label>
            </td>
            <td>
                <label for="for">
                    @if($communeFile->file_c != null)  
                        <a class="text-info" href="{{ route('programmingFile.downloadFileC', $communeFile->id) }}" target="_blank">
                            <i class="fas fa-download"></i> Ver
                        </a>
                    @endif
                </label>
            </td>
            <td class="text-right">
            <!-- Permiso para adjuntar documentos municipales programación númerica -->
            @if(auth()->user()->can('Communefiles: upload') && $communeFile->programming_status == 'active')
                <button class="btn btb-flat btn-sm btn-light" data-toggle="modal"
                    data-target="#updateModal"
                    data-communefile_id="{{ $communeFile->id }}"
                    data-name="{{ $communeFile->file_a }}"
                    data-year="{{ $communeFile->year }}"
                    data-user_id="{{ $communeFile->user_id }}"
                    data-formaction="{{ route('communefiles.update', $communeFile->id)}}">
                <i class="fas fa-paperclip small"></i> Adjuntar
                </button>
            @endif
            
            <!-- Permiso para gestionar las capacitaciones municipales en la programación númerica en proceso -->
            @if($year < 2022)
            @can('TrainingItem: view')
                <a href="{{ route('trainingitems.index', ['commune_file_id' => $communeFile->id]) }}" class="btn btb-flat btn-sm btn-light" >
                    <i class="fas fa-chalkboard-teacher small"></i> 
                    <span class="small">Capacitaciones</span> 
                </a>
            @endcan
            @endif

            @can('Reviews: view')
                <a href="{{ request()->anio > 2021 || $year > 2021 ? route( 'reviews.show', ['review' => $communeFile->id]) : route( 'reviews.index', ['commune_file_id' => $communeFile->id]) }}" class="btn btb-flat btn-sm btn-primary">
                    <i class="fas fa-clipboard-check small"></i>
                    <span class="small">Evaluación Gral.</span> 
                </a>
            @endcan

            
            </td> 
        </tr>
        @endforeach
    </tbody>
</table>

@include('programmings/communeFiles/modal_edit_files')

@endsection

@section('custom_js')
<script type="text/javascript">
    $('#updateModal').on('show.bs.modal', function (event) {
        console.log("en modal");
        
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="name"]').val(button.data('name'))
        modal.find('input[name="date"]').val(button.data('year'))
        modal.find('input[name="user"]').val(button.data('user_id'))

        modal.find('input[name="communefile_id"]').val(button.data('communefile_id'))
        modal.find('input[name="professional_id"]').val(button.data('professional_id'))

        var formaction  = button.data('formaction')
        modal.find("#form-edit").attr('action', formaction)
    })
</script>
@endsection
