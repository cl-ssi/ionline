@extends('layouts.app')

@section('title', 'Editar documento')

@section('content')

@include('documents.partials.nav')

<h3>Editar Documento</h3>

@if( Auth::id() == $document->user_id )

<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/create_doc.js') }}"></script>


<form method="POST" class="form-horizontal" action="{{ route('documents.update', $document) }}">
    @csrf
    @method('PUT')
    <div class="form-row">
        <div class="form-group col-3">
            <label for="for_internal_number">Número Interno (Opcional)</label>
            <input type="number" class="form-control" id="for_internal_number" name="internal_number" value="{{ $document->internal_number }}">
        </div>
    </div>

    <div class="form-row">
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
            <select name="type_id" id="for_type_id" class="form-control" required>
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
    <div class="form-row">
        <div class="form-group col">
            <label for="forSubject">Materia*</label>
            <input type="text" class="form-control" id="forSubject"
                value="{{ $document->subject }}" name="subject" maxlength="255"
                placeholder="Descripción del contenido del documento" required>
        </div>
    </div>

<div id="collapse">
    <div class="form-row">
        <div class="form-group col-7">
            <div class="form-group ">
                <label for="forFrom">De:*</label>
                <input type="text" class="form-control" id="forFrom"
                    value="{{ $document->from }}" name="from"
                    placeholder="Nombre/Funcion" >
            </div>
            <div class="form-group ">
                <label for="forFor">Para:*</label>
                <input type="text" class="form-control" id="forFor" name="for"
                    value="{{ $document->for }}" placeholder="Nombre/Funcion">
            </div>
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
</div>

    <div class="form-group pt-1" style="width: 940px;">
        <label for="contenido">Contenido*</label>
        <textarea class="form-control" id="contenido" rows="18"
            name="content">{{ $document->content }}</textarea>
    </div>

    <div class="form-row">
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

    <div class="form-group">
        <button type="submit" class="btn btn-primary mr-4">Guardar</button>
        </form>
        @if(session()->has('god') OR auth()->user()->can('Documents: delete document'))

            @if(!$document->file OR $document->file_to_sign_id === null)
            <form method="POST" class="form-horizontal" action="{{ route('documents.destroy', $document) }}">
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

    <div class="alert alert-info" role="alert">
        <strong>TIP para pegar tablas de word o excel</strong>
        <p>
            <ol>
                <li>Copiar y pegar la tabla desde el excel o word</li>
                <li>En el cuadro del contenido, seleccionar "Vista" y luego "Código fuente"</li>
                <li>Buscar donde diga <strong>&lt;table width="XXX"&gt;</strong></li>
                <li>Reemplazar por <strong>&lt;table style="border-collapse: collapse; width: 100%;" border="1"&gt;</strong></li>
            </ol>
        </p>
    </div>

@endif

@endsection

@section('custom_js')

<script type="text/javascript">
var typeVal = $('#formType').val();
    if(typeVal == "Resolución") {
        $("#forFrom").removeAttr( "required" );
        $("#forFor").removeAttr( "required" );
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
