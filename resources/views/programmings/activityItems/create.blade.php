@extends('layouts.app')

@section('title', 'Nuevo convenio')

@section('content')

@include('programmings/nav')

<h4 class="mb-3">Nuevo Item Planificación Actividades Anual </h4>

<form method="POST" class="form-horizontal small" action="{{ route('programmings.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="forprogram">Trazadora</label>
            <select name="tracer" id="formprogram" class="form-control">
                    <option value=""></option>
                    <option value="">SI</option>
                    <option value="">NO</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="forprogram">Ciclo Vital</label>
            <select name="establishment" id="formprogram" class="form-control">
                    <option value="">INFANTIL</option>
                    <option value="">ADOLESCENTE</option>
                    <option value="">ADULTO</option>
                    <option value="">ADULTO MAYOR</option>
               
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="forprogram">Programa Ministerial</label>
            <select name="establishment" id="formprogram" class="form-control">
                @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}"></option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-5">
            <label for="forprogram">Prestación o Actividad</label>
            <select name="establishment" id="formprogram" class="form-control">
                @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}"></option>
                @endforeach
            </select>
        </div>
    </div>

    
    <button type="submit" class="btn btn-info mb-4">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
