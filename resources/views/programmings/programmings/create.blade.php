@extends('layouts.bt4.app')

@section('title', 'Nuevo convenio')

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Iniciar Programación Operativa </h3>

<form method="POST" class="form-horizontal small" action="{{ route('programmings.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-row ">
        <div class="form-group col-md-6">
            <label for="forprogram">Establecimiento</label>
            <select name="establishment" id="formprogram" class="form-control selectpicker " data-live-search="true">
                @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}">{{$establishment->type}} - {{ $establishment->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group col-md-6">
            <label for="forprogram">Descripción</label>
            <input type="input" class="form-control" id="forreferente" name="description" required="">
            <small>Ej. Programación 2021 - Cirujano Videla</small>
        </div>
    </div>

    <div class="form-row">

        <fieldset class="form-group col-2">
            <label for="fordate">Fecha</label>
            <input type="text" class="form-control " id="datepicker" name="date" required="">
        </fieldset>

        <div class="form-group col-md-6">
            <label for="forprogram">Responsable</label>
            <select name="user" id="user" class="form-control selectpicker " data-live-search="true" >
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{$user->name}} {{$user->fathers_family}} {{$user->mothers_family}} - {{ $user->position }}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="forprogram">Permitir Acceso</label>
            <select name="access[]" id="access" class="form-control selectpicker " data-live-search="true" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{$user->name}} {{$user->fathers_family}} {{$user->mothers_family}} - {{ $user->position }}</option>
                @endforeach
            </select>
        </div>

        </div>
    <button type="submit" class="btn btn-info mb-4">Crear</button>

</form>

@endsection

@section('custom_js')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>

<script type="text/javascript">
    $("#datepicker").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });

</script>
@endsection
