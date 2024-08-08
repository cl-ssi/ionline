@extends('layouts.bt5.app')

@section('title', 'Editar documento')

@section('content')

@include('documents.partials.nav')

<h3>Editar Documento {{ $document->id }}</h3>

@if( Auth::id() == $document->user_id )

<x-documents.tinymce-config />

<form method="POST" class="form-horizontal" action="{{ route('documents.update', $document) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row mb-3 g-2">
        <div class="form-group col-2">
            <label for="forNumber">Número</label>
            @livewire('documents.enumerate',['document' => $document])
        </div>
        <div class="form-group col-2">
            <label for="forDate">Fecha</label>
            <input type="date" class="form-control" id="forDate" name="date"
                value="{{ $document->date ? $document->date->format('Y-m-d') : '' }}">
        </div>
        <div class="form-group col-2">
            <label for="forType">Tipo*</label>
            <select name="type_id" id="for_type_id" class="form-select" {{ isset($document->number) ? 'disabled':'' }}>
                <option value=""></option>
                @foreach($types as $id => $type)
                    <option value="{{ $id }}" {{ $document->type_id == $id ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <fieldset class="form-group col-1">
            <label for="for_reserved">&nbsp;</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" 
                        name="reserved" id="for_reserved" {{ $document->reserved ? 'checked' : '' }}>
                    <label class="form-check-label" for="for_reserved">Reservado</label>
                </div>
            </div>
        </fieldset>
        <div class="form-group col">
            <label for="for_antecedent">Antecedente</label>
            <input type="text" class="form-control" id="for_antecedent"
                placeholder="[opcional]"
                value="{{ $document->antecedent }}" name="antecedent">
        </div>
    </div>
    <div class="row mb-3">
        <div class="form-group col">
            <label for="forSubject">Materia</label>
            <input type="text" class="form-control" id="forSubject"
                value="{{ $document->subject }}" name="subject" maxlength="255"
                placeholder="Descripción del contenido del documento" required>
        </div>
    </div>

    <div id="collapse">
        <div class="row mb-3">
            <div class="form-group col-7">
                <label for="forFrom">De:*</label>
                <input type="text" class="form-control" id="forFrom"
                    value="{{ $document->from }}" name="from"
                    placeholder="Nombre/Funcion" >
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-group ">
                <label for="forFor">Para:*</label>
                <input type="text" class="form-control" id="forFor" name="for"
                    value="{{ $document->for }}" placeholder="Nombre/Funcion">
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-group">
                Mayor jerarquía:
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="greater_hierarchy"
                        id="forHierarchyFrom" value="from"
                        {{ $document->greater_hierarchy == 'from' ? 'checked' : ''}}>
                    <label class="form-check-label" for="forHierarchyFrom"> DE: </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="greater_hierarchy"
                        id="forHierarchyFor" value="for"
                        {{ $document->greater_hierarchy == 'for' ? 'checked' : ''}}>
                    <label class="form-check-label" for="forHierarchyFor"> PARA: </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="form-group" style="width: 940px;">
            <label for="contenido">Contenido*</label>
            <textarea class="form-control" id="contenido" rows="44"
                name="content">{{ $document->content }}</textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="form-group col">
            <label for="for_file">Archivo (Opcional, para cuando se quiere subir el archivo que fue hecho fuera del generador de documentos)</label>
            <input type="file" class="form-control" id="for_file" name="file">
            <small class="form-text text-muted">Tamaño máximo 32 MB, 
                <span class="text-danger"> una vez cargado un archivo, no se podrá volver a editar a menos que se elimine el archivo cargado</span>
            </small>
        </div>
    </div>

    <div class="row mb-3 g-2">
        <div class="form-group col">
            <label for="forDistribution">Distribución (separado por salto de línea)*</label>
            <textarea class="form-control" id="forDistribution" rows="5"
                name="distribution">{{ $document->distribution }}</textarea>
        </div>
        <div class="form-group col">
            <label for="forResponsible">Responsables (separado por salto de línea)</label>
            <textarea class="form-control" id="forResponsible" rows="5"  placeholder="Cargo"
                name="responsible">{{ $document->responsible }}</textarea>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="form-group col-3">
            <label for="for_internal_number">Número Interno (Opcional)</label>
            <input type="number" class="form-control" id="for_internal_number" name="internal_number" value="{{ $document->internal_number }}">
        </div>
    </div>

    <div class="row">
        <div class="col-2 mb-3">
            <button type="submit" class="btn btn-primary mr-4">Guardar</button>
        </div>
</form>
        <div class="offset-md-8 text-end col-2">
            @if(session()->has('god') OR auth()->user()->can('Documents: delete document'))

                @if(!$document->file OR $document->file_to_sign_id === null)
                <form method="POST" class="form-inline" action="{{ route('documents.destroy', $document) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger ml-4 float-right">Eliminar</button>
                    <br>
                </form>
                @else
                <button class="btn btn-outline-danger" disable>No se puede eliminar, tiene un archivo o ha sido firmado</button>
                @endif
            @endif
        </div>
    </div>

    <div class="alert alert-info" role="alert">
        <strong><i class="bi bi-exclamation-circle"></i> Puede utilizar las nuevas opciones dentro del menú "Limpiar Documento" en el editor</strong>
        <ul>
            <li>Limpiar espacios en blanco: Eliminará todos los espacios innecesarios y duplicados. </li>
            <li>Limpiar tamaño y tipo de letra: Todos los textos quedarán con el mismo tamaño y tipo de letra (estándard del Servicio).</li>
            <li>Limpiar colores y fondos: Se eliminarán los colores de fondo y de texto (se mantendrán las negritas).</li>
            <li>Limpiar tablas: Todas las tablas del documento quedarán uniformes, del mismo ancho y forma.</li>
        </ul>
    </div>

    <div class="alert alert-warning" role="alert">
        <strong>Convenios</strong>
        <ul>
            <li>Para eliminar el color "destacado amarillo" del documento, vaya al menú "Editar", luego
                 "Seleccionar todo" y finalmente en el boton de color de fondo, selecione remover color,
                es la opción que está al lado derecho del color blanco (cuadro blanco con una raya roja)</li>
        </ul>
    </div>

@endif

@endsection

@section('custom_js')

<script type="text/javascript">
    var typeVal = $('#for_type_id').val();

    /* Circular */
    if(typeVal == "4") {
        $("#forFrom").removeAttr("required");
        $("#forFor").removeAttr("required");
        $("#collapse").hide();
    }
    /* Resolución */
    if(typeVal == "5") {
        $("#forFrom").removeAttr("required");
        $("#forFor").removeAttr("required");
        $("#forSubject").removeAttr("required");
        $("#collapse").hide();
    }
    /* Convenio */
    if(typeVal == "6") {
        $("#forFrom").removeAttr("required");
        $("#forFor").removeAttr("required");
        $("#collapse").hide();
    }
    /* Ordinario */
    if (typeVal == "7") {

    }
    /* Informe */
    if (typeVal == "8") {
        $("#forFrom").removeAttr("required");
        $("#forFor").removeAttr("required");
        $("#collapse").hide();
    }
    /* Protocolo */
    if (typeVal == "9") {
        $("#forFrom").removeAttr("required");
        $("#forFor").removeAttr("required");
        $("#collapse").hide();
    }
    /* Acta */
    if (typeVal == "10") {
        $("#forFrom").removeAttr("required");
        $("#forFor").removeAttr("required");
        $("#collapse").hide();
    }
    /* Resolución de continuidad convenio */
    if (typeVal == "19") {
        $("#forFrom").removeAttr("required");
        $("#forFor").removeAttr("required");
        $("#collapse").hide();
    }
    /* Certificado disponibilidad presupuestaria */
    if (typeVal == "21") {
        $("#forFrom").removeAttr("required");
        $("#forFor").removeAttr("required");
        $("#collapse").hide();
    }
    /* Resolución */
    if(typeVal == "23") {
        $("#forFrom").removeAttr("required");
        $("#forFor").removeAttr("required");
        $("#forSubject").removeAttr("required");
        $("#collapse").hide();
    }

$('#formType').change(
    function() {
        if(!confirm('Con este cambio se reemplazará el número actual que tiene asignado el documento por uno nuevo según el tipo de documento que seleccionaste, ¿Está seguro/a de realizar esto al momento de guardar los cambios?')){
            $(this).val(typeVal);
            return;
        }

        if("Resolución" === this.value) {
            $("#forFrom").removeAttr( "required" );
            $("#forFor").removeAttr( "required" );
            $("#collapse").hide();
        }



        $("#forNumber").val(null);
        // if("Memo" === this.value) {
        //     $("#forNumber").prop('disabled', false);
        // }
        // if("Ordinario" === this.value) {
        //     $("#forNumber").prop('disabled', true);
        //     $("#forNumber").val(null);
        // }
        // if("Reservado" === this.value) {
        //     $("#forNumber").prop('disabled', true);
        //     $("#forNumber").val(null);
        // }
        // if("Circular" === this.value) {
        //     $("#forNumber").prop('disabled', false);
        // }
    }



);
</script>

@endsection
