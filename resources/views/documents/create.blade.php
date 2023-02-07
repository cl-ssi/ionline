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
<x-head.tinymce-config />

<form method="post" name="form" action="{{ route('documents.store') }}" onsubmit="return validate_form()">
    @csrf
    

    <div class="form-row">
        <div class="form-group col-2">
            <label for="forDate">Fecha</label>
            <input type="date" class="form-control" id="forDate" name="date" value="{{ now()->toDateString() }}">
        </div>
        <div class="form-group col-2">
            <label for="forType">Tipo*</label>
            <select name="type_id" id="formType" class="form-control" required>
                <option value=""></option>
                @foreach($types as $id => $type)
                    <option value="{{ $id }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <fieldset class="form-group col-1">
            <label for="for_reserved">&nbsp;</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="reserved" id="for_reserved">
                    <label class="form-check-label" for="for_reserved">Reservado</label>
                </div>
            </div>
        </fieldset>
        <div class="form-group col">
            <label for="for_antecedent">Antecedente</label>
            <input type="text" class="form-control" id="for_antecedent" name="antecedent" placeholder="[opcional]" {!! $document->antecedent ? 'value="' . $document->antecedent .'"' : '' !!}>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <label for="forSubject">Materia*</label>
            <input type="text" class="form-control" id="forSubject" name="subject" placeholder="Descripción del contenido del documento" required maxlength="255" {!! $document->subject ? 'value="' . $document->subject .'"' : '' !!}>
        </div>
    </div>
    <div id="collapse">
        <div class="form-row">
            <div class="form-group col-7">
                <div class="form-group ">
                    <label for="forFrom">De:*</label>
                    <input type="text" class="form-control" id="forFrom" name="from" placeholder="Nombre/Funcion" required {!! $document->from ? 'value="' . $document->from .'"' : '' !!}>
                </div>
                <div class="form-group ">
                    <label for="forFor">Para:*</label>
                    <input type="text" class="form-control" id="forFor" name="for" placeholder="Nombre/Funcion" required {!! $document->for ? 'value="' . $document->for .'"' : '' !!}>
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
    </div>

    <div class="form-group pt-1" style="width: 940px;">
        <label for="contenido">Contenido*</label>
        <textarea class="form-control" id="contenido" rows="18" name="content">{!! $document->content !!}</textarea>
    </div>

    <div class="form-row">
        <div class="form-group col">
            <label for="forDistribution">Distribución (separado por salto de línea)</label>
            <textarea class="form-control" id="forDistribution" rows="6" name="distribution" required>{!! $document->distribution ?? '' !!}</textarea>
        </div>

        <div class="form-group col">
            <label for="forResponsible">Responsables (separado por salto de línea)</label>
            <textarea class="form-control" id="forResponsible" rows="6" name="responsible">{!! $document->responsible ? $document->responsible : '' !!}</textarea>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary mr-4">Guardar</button>
        <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="¡ Tampoco me pongas el mouse encima !" onclick="alert('Noooo, si pones Aceptar se borrará todo.');">No apretar</button>
    </div>
</form>

<div class="alert alert-info" role="alert">
    <strong>TIP para pegar tablas de word o excel</strong>
    <p>
        <ol>
            <li>Copiar la tabla desde el excel o word</li>
            <li>Pegar la tabla en la herramienta limpiadora de tabla en el siguiente
                <a href="https://www.r2h.nl/html-word-excel-table-code-cleaner/index.php">link</a>
            </li>
            <li>Presionar el boton "Clean code", luego "Select all" y luego copiar con "Control + C"</li>
            <li>Volver a donde está haciendo el documento y en el cuadro del contenido, seleccionar "Vista" y luego "Código fuente"</li>
            <li>Finalmente pegar el texto con "Control + V" y guardar</li>
        </ol>
    </p>
</div>

@endsection

@section('custom_js')

<script type="text/javascript">
    function validate_form() {
        tinymce.triggerSave();
        validity = true;
        if (document.forms["form"]["content"].value.length == 0) {
            validity = false;
            alert('El "Contenido" no puede estar vacío');
        }
        return validity;
    };

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('#formType').change(
        function() {
            $("#collapse").show();
            if ("1" === this.value) {
                $("#forNumber").prop('disabled', false);
            }
            if ("2" === this.value) {
                $("#forNumber").prop('disabled', true);
                $("#forNumber").val(null);
            }
            if ("3" === this.value) {
                $("#forNumber").prop('disabled', true);
                $("#forNumber").val(null);
            }
            if ("6" === this.value) {
                $("#forNumber").prop('disabled', true);
                $("#forNumber").val(null);
            }
            if ("7" === this.value) {
                $("#forNumber").prop('disabled', false);
                $("#forFrom").removeAttr("required");
                $("#forFor").removeAttr("required");
                $("#forNumber").prop('disabled', true);
                $("#collapse").hide();
            }
            if ("10" === this.value) {
                var contenido = '<h1 style="text-align: center; text-decoration: underline;">ACTA DE RECEPCIÓN</h1> <p><strong>Datos de ubicación</strong></p> <table style="width: 100%; border-collapse: collapse;" border="1" cellpadding="2"> <tbody> <tr> <td style="width: 30%; height: 30px;">Establecimiento</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Dirección</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Unidad Organizacional</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Ubicación (oficina)</td> <td></td> </tr> </tbody> </table> <p><strong>Características de la especie</strong></p> <table style="width: 100%; border-collapse: collapse;" border="1" cellpadding="2"> <tbody> <tr> <td style="width: 30%; height: 30px;">Inventario SSI</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Tipo de equipo</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Marca</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Modelo</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Número de serie</td> <td></td> </tr> </tbody> </table> <p><strong>Responsable</strong></p> <table style="width: 100%; border-collapse: collapse;" border="1" cellpadding="2"> <tbody> <tr> <td style="width: 30%; height: 30px;">Nombre completo</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Función / cargo</td> <td></td> </tr>  </tbody> </table> <table style="height: 36px; width: 100%; border-collapse: collapse; margin-top: 60px" border="0"><tbody><tr><td style="width: 50%; height: 18px; text-align: center;">__________________________</td><td style="width:50%; height: 18px; text-align: center;">__________________________</td></tr><tr><td style="width: 50%; height: 18px; text-align: center;">{{Auth::user()->TinnyName}}</td><td style="width: 50%; height: 18px; text-align: center;">SSI</td></tr><tr><td style="width: 50%; height: 18px; text-align: center;"><strong>Quien entrega</strong></td><td style="width: 50%; height: 18px; text-align: center;"><strong>Quien recibe</strong></td></tr><tr><td></td><td style="width: 50%; height: 38px; text-align: center;"><br>_____/_____/_____________</td></tr></tbody></table>';
                tinyMCE.activeEditor.setContent(contenido);
            }
            if ("10" === this.value) {
                var contenido = '<h1 style="text-align: center; text-decoration: underline;">ACTA DE RECEPCION CONFORME</h1><br><h1 style="text-align: center; text-decoration: underline;">OBRAS MENORES Nº </h1><p>En Iquique, a dìa de mes 202x se emite el "Acta Recepción", que corresponde a:</p> <table border="1" cellspacing="0"  cellpadding="0"> <tbody> <tr> <td width="151"valign="top"> <p>Servicio</p> </td> <td width="438"valign="top"> </td></tr><tr><td width="151"valign="top"> <p>Unidad Requirente</p></td> <td width="438"valign="top"></td></tr><tr><td width="151"valign="top"><p>FR</p></td> <td width="438"valign="top"> </td></tr><tr><td width="151"valign="top"> <p>Proveedor</p></td> <td width="438"valign="top"></td></tr><tr><td width="151"valign="top"><p>Cotización</p></td> <td width="438"valign="top"> </td></tr><tr><td width="151"valign="top"> <p>Fuente Financiamiento</p></td> <td width="438"valign="top"> </td> </tr> </tbody> </table><br><br><table border="1"cellspacing="0" cellpadding="0"width="586"><tbody><tr><td width="85"rowspan="2"><p align="center"><strong>DISPOSITIVO</strong></p></td><td width="170"rowspan="2"><p align="center"><strong>TRABAJOS SOLICITADOS</strong></p></td><td width="331"colspan="3"valign="top"><p align="center"><strong>TRABAJOS REALIZADOS</strong></p></td></tr><tr><td width="66"valign="top"><p align="center"><strong>Realizado</strong></p></td><td width="66"valign="top"><p align="center"><strong>No Realizado</strong></p></td><td width="198"><p align="center"><strong>Observaciones</strong></p></td></tr><tr><td width="85"rowspan="7"></td><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"><p align="center"></p></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"><p align="center"></p></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="586"colspan="5"><p><strong>OTROS</strong></p></td></tr><tr><td width="85"></td><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="85"></td><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="85"></td><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr></tbody></table><br><br><br><p>NOTA:<br/>Se deja constancia que se recepcionan conforme<br/>Para constancia firman:</p>';
                tinyMCE.activeEditor.setContent(contenido);
            }

            if ("8" === this.value) {
                $("#forFrom").removeAttr("required");
                $("#forFor").removeAttr("required");
                $("#forNumber").prop('disabled', true);
                $("#collapse").hide();
                $("#forSubject").val('Exenta');
            }
        }
    );
</script>

@endsection