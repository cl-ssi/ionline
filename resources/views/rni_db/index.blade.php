@extends('layouts.bt4.app')

@section('title', 'Base datos RNI')

@section('content')

<h3 class="mb-3">Base de datos RNI</h3>

@can('RNI Database: admin')
<form method="POST" class="form-inline" action="{{ route('indicators.rni_db.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label class="sr-only" for="importFile">Example file input</label>
        <input type="file" name="file" class="form-control-file form-control-sm mb-2 mr-sm-2 pl-0" id="importFile" accept=".xlsx, .xls, .csv" required>
    </div>
    <div class="form-group">
        <select class="form-control form-control-sm mb-2 mr-sm-2" name="establishment_id" required>
            <option value="">Seleccione establecimiento...</option>
        @foreach($establishments as $establishment)
            <option value="{{$establishment->id}}">{{$establishment->name}}</option>
        @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary mb-2 btn-sm"><i class="fas fa-save" aria-hidden="true"></i> Guardar</button>
</form>
@endcan

<table class="table table-condensed table-bordered table-sm small">
    <thead>
        <tr>
            <th>Comuna / Establecimiento</th>
            <th>Nombre Archivo</th>
            <th>Tamaño</th>
            <th>Última actualización</th>
            <th>Descargar</th>
        </tr>
    </thead>

@foreach ($files as $file)
@if($file->users->where('id', Auth::id())->count() > 0 || auth()->user()->hasPermissionTo('RNI Database: admin'))
<tr>
    <td>{{ $file->establishment->commune->name ?? ''}} @if($file->establishment->commune->name != $file->establishment->name) / {{ $file->establishment->name }} @endif</td>
    <td>{{ $file->filename }}</td>
    <td>{{ $file->size }}</td>
    <td>{{ $file->updated_at->format('d-m-Y H:i') }} ({{ $file->updated_at->diffForHumans() }})</td>
    <td>
        <a href="{{ route('indicators.rni_db.download', $file) }}" class="btn btn-outline-secondary btn-sm" title="">
                        <span class="fas fa-download" aria-hidden="true"></span></a>
        @can('RNI Database: admin')
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#modal-{{$file->establishment_id}}">
            <span class="fas fa-users" aria-hidden="true"></span>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="modal-{{$file->establishment_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- Scrollable modal -->
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Accesos para {{ $file->establishment->commune->name != $file->establishment->name ? 'establecimiento' : 'comuna' }} {{$file->establishment->name ?? ''}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-{{$file->establishment_id}}" method="POST" action="{{ route('indicators.rni_db.add_user', $file) }}">
                @csrf
                    <div class="form-row">
                            <fieldset class="form-group col-8">
                                    <label for="for_user_id">Funcionario*</label>
                                    @livewire('search-select-user', ['required' => 'required'])
                            </fieldset>

                            <fieldset class="form-group col">
                                    <label for="for_user_id"><br></label>
                                    <button type="submit" class="form-control btn btn-primary">Asignar</button>
                            </fieldset>
                    </div>
                </form>
                <hr>
                <div class="form-row">
                    <fieldset class="form-group col-sm">
                        <label><i class="fas fa-users"></i> Funcionarios asignados</label>

                            <ul class="list-group">
                            @foreach ($file->users as $user)
                                <li class="list-group-item py-2">
                                    {{ $user->fullName }}
                                    <form method="POST" action="{{ route('indicators.rni_db.revoke_user', $file->id) }}" onclick="return confirm('¿Está seguro de dar quitar accesos a este archivo a {{$user->tinyName}}?');" class="d-inline">
                                        {{ method_field('DELETE') }} {{ csrf_field() }}
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                        <button class="btn btn-link btn-sm float-right"><i class="far fa-trash-alt" style="color:red"></i></button>
                                    </form>
                                </li>
                            @endforeach
                            </ul>
                    </fieldset>
                </div>
            </div>
            </div>
        </div>
        </div>
        @endif
    </td>
</tr>
@endif
@endforeach

</table>

@endsection

@section('custom_js')
<script type="text/javascript">
    $('input[type="file"]').bind('change', function(e) {
    //Validación de tamaño
    if((this.files[0].size / 1024 / 1024) > 5){
        alert('No puede cargar archivos de más de 5 MB.');
        $(this).val('');
    }
    //Validación de .xlsx, .xls, .csv
    const allowedExtensions = ["xlsx", "xls", "csv"];
    if( (this).id == 'importFile' && !allowedExtensions.includes(this.files[0]?.name.split('.').pop())){
        alert("Debe seleccionar un archivo con extensión xlsx, xls o csv.");
        $(this).val('');
    }
    });
</script>
@endsection

@section('custom_js_head')

@endsection
