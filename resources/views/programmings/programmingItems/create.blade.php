@extends('layouts.app')

@section('title', 'Nuevo convenio')

@section('content')

@include('programmings/nav')

<h4 class="mb-3">Nuevo Item Programación Operativa </h4>

<form method="POST" class="form-horizontal small" action="{{ route('programmings.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
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

    <div class="form-row">
    
        <div class="form-group col-md-3">
            <label for="forprogram">Def. Población Objetivo</label>
            <input type="input" class="form-control" id="forreferente" name="description" required="">
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Fuente Población</label>
            <input type="input" class="form-control" id="forreferente" name="description" required="">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Nº Población Objetivo</label>
            <input type="number" class="form-control" id="forreferente" name="description" required="">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Prevalencia o Tasa</label>
            <input type="input" class="form-control" id="forreferente" name="description" required="">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Fuente Prevalencia o Tasa</label>
            <input type="input" class="form-control" id="forreferente" name="description" required="">
        </div>
        
    </div>

    <div class="form-row">
    
        <div class="form-group col-md-4">
            <label for="forprogram">Total Actividades</label>
            <input type="input" class="form-control" id="forreferente" name="description" required="">
        </div>

        <div class="form-group col-md-4">
            <label for="forprogram">Profesional</label>
            <select name="establishment" id="formprogram" class="form-control">
                @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}"></option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Rendimiento de la Actividad</label>
            <input type="number" class="form-control" id="forreferente" name="description" required="">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Horas Años Requeridas</label>
            <input type="input" class="form-control" id="forreferente" name="description" required="">
        </div>
        
    </div>

    <div class="form-row">
    
        <div class="form-group col-md-4">
            <label for="forprogram">Horas días Requeridas</label>
            <input type="input" class="form-control" id="forreferente" name="description" required="">
        </div>

        <div class="form-group col-md-4">
            <label for="forprogram">Jornada Direca Año</label>
            <input type="input" class="form-control" id="forreferente" name="description" required="">
        </div>

        <div class="form-group col-md-4">
            <label for="forprogram">Jornada Horas Directas Diarias</label>
            <input type="number" class="form-control" id="forreferente" name="description" required="">
        </div>
        
</div>

    
    <button type="submit" class="btn btn-info mb-4">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
