@extends('layouts.app')

@section('title', 'Nuevo documento')

@section('content')

@include('documents.partials.nav')

<h3>Nuevo Documento</h3>

<form class="form-inline float-right" method="POST" action="{{ route('documents.createFromPrevious') }}">
    @csrf
    <label class="my-1 mr-2" for="forDocumentID">Crear a partir del </label>
    <input name="document_id" type="text" class="form-control mr-3" id="forDocumentID" placeholder="Código Interno">
    <button type="submit" class="btn btn-outline-secondary my-1"> <i class="fas fa-search"></i> Precargar</button>
</form>

<br><br>
<hr>

<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/create_doc.js') }}"></script>

<form method="post" action="{{ route('documents.store') }}">
    @csrf

    <div class="form-row">
        <div class="form-group col-2">
            <label for="forNumber">Número</label>
            <input type="text" class="form-control" id="forNumber" name="number"
                placeholder="[Automático]">
        </div>
        <div class="form-group col-2">
            <label for="forDate">Fecha</label>
            <input type="date" class="form-control" id="forDate" disabled>
        </div>
        <div class="form-group col-2">
            <label for="forType">Tipo*</label>
            <select name="type" id="formType" class="form-control" required>
                <option value="Memo" @if($document->type == 'Memo') selected @endif>Memo</option>
                <option value="Ordinario" @if($document->type == 'Ordinario') selected @endif>Ordinario</option>
                <option value="Reservado" @if($document->type == 'Reservado') selected @endif>Reservado</option>
                <option value="Circular" @if($document->type == 'Circular') selected @endif>Circular</option>
                <option value="Acta de recepción" @if($document->type == 'Acta de recepción') selected @endif>Acta de recepción</option>
            </select>
        </div>
        <div class="form-group col">
            <label for="for_antecedent">Antecedente</label>
            <input type="text" class="form-control" id="for_antecedent" name="antecedent"
                placeholder="[opcional]"
                {!! $document->antecedent ? 'value="' . $document->antecedent .'"' : '' !!}>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <label for="forSubject">Materia*</label>
            <input type="text" class="form-control" id="forSubject" name="subject"
                placeholder="Descripción del contenido del documento" required
                {!! $document->subject ? 'value="' . $document->subject .'"' : '' !!}>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-7">
            <div class="form-group ">
                <label for="forFrom">De:*</label>
                <input type="text" class="form-control" id="forFrom" name="from"
                    placeholder="Nombre/Funcion" required
                    {!! $document->from ? 'value="' . $document->from .'"' : '' !!}>
            </div>
            <div class="form-group ">
                <label for="forFor">Para:*</label>
                <input type="text" class="form-control" id="forFor" name="for"
                    placeholder="Nombre/Funcion" required
                    {!! $document->for ? 'value="' . $document->for .'"' : '' !!}>
            </div>
            <div class="form-group">
                Mayor jerarquía:
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="greater_hierarchy" id="forHierarchyFrom" value="from" checked>
                    <label class="form-check-label" for="forHierarchyFrom">DE:</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="greater_hierarchy" id="forHierarchyFor" value="for">
                    <label class="form-check-label" for="forHierarchyFor">PARA:</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group pt-1" style="width: 940px;">
        <label for="contenido">Contenido*</label>
        <textarea class="form-control" id="contenido" rows="18" name="content">{!! $document->content !!}</textarea>
    </div>

    <div class="form-row">
        <div class="form-group col">
            <label for="forDistribution">Distribución (separado por salto de línea)*</label>
            <textarea class="form-control" id="forDistribution" rows="6" name="distribution" required>{!! $document->distribution ? $document->distribution : '' !!}</textarea>
        </div>

        <div class="form-group col">
            <label for="forResponsible">Responsables (separado por salto de línea)</label>
            <textarea class="form-control" id="forResponsible" rows="6"
                name="responsible">{!! $document->responsible ? $document->responsible : '' !!}</textarea>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary mr-4">Guardar</button>
        <button type="button" class="btn btn-outline-primary"
            data-toggle="tooltip" data-placement="top"
            title="¡ Tampoco me pongas el mouse encima !"
            onclick="alert('Noooo, si pones Aceptar se borrará todo.');">No apretar</button>
    </div>
</form>


@endsection

@section('custom_js')

<script type="text/javascript">
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$('#formType').change(
    function() {
        if("Memo" === this.value) {
            $("#forNumber").prop('disabled', false);
        }
        if("Ordinario" === this.value) {
            $("#forNumber").prop('disabled', true);
            $("#forNumber").val(null);
        }
        if("Reservado" === this.value) {
            $("#forNumber").prop('disabled', true);
            $("#forNumber").val(null);
        }
        if("Circular" === this.value) {
            $("#forNumber").prop('disabled', false);
        }
        if("Acta de recepción" === this.value) {
            var contenido = '<h1 style="text-align: center; text-decoration: underline;">ACTA DE RECEPCIÓN</h1> <p><strong>Datos de ubicación</strong></p> <table style="width: 100%; border-collapse: collapse;" border="1" cellpadding="2"> <tbody> <tr> <td style="width: 30%; height: 30px;">Establecimiento</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Dirección</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Unidad Organizacional</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Ubicación (oficina)</td> <td></td> </tr> </tbody> </table> <p><strong>Características de la especie</strong></p> <table style="width: 100%; border-collapse: collapse;" border="1" cellpadding="2"> <tbody> <tr> <td style="width: 30%; height: 30px;">Inventario SSI</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Tipo de equipo</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Marca</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Modelo</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Número de serie</td> <td></td> </tr> </tbody> </table> <p><strong>Responsable</strong></p> <table style="width: 100%; border-collapse: collapse;" border="1" cellpadding="2"> <tbody> <tr> <td style="width: 30%; height: 30px;">Nombre completo</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Función / cargo</td> <td></td> </tr> </tbody> </table>';
            tinyMCE.activeEditor.setContent(contenido);
        }
    }
);

</script>

@endsection
