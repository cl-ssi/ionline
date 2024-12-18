@extends('layouts.bt5.app')

@section('title', 'Nuevo documento')

@section('content')

@include('documents.partials.nav')

<div class="row">
    <div class="col-md-6">
        <h3>Nuevo Documento</h3>
    </div>
    <div class="offset-md-3 col-md-3">
        <form class="form-inline float-right" method="POST" action="{{ route('documents.createFromPrevious') }}">
            @csrf
            <label class="my-1 mr-2" for="forDocumentID">Crear a partir del </label>
            <div class="input-group">
                <input name="document_id" type="text" class="form-control" id="forDocumentID" placeholder="ID">
                <button type="submit" class="btn btn-outline-secondary"> <i class="fas fa-search"></i> Precargar</button>
            </div>
        </form>
    </div>
</div>

<hr>

<x-documents.tinymce-config />

<form method="post" name="form" action="{{ route('documents.store') }}" onsubmit="return validate_form()">
    @csrf

    @if (isset($document->continuity_resol_id))
    <input type="hidden" name="continuity_resol_id" value="{{ $document->continuity_resol_id }}">
    @endif

    @if (isset($document->budget_availability_id))
    <input type="hidden" name="budget_availability_id" value="{{ $document->budget_availability_id }}">
    @endif
    
    @if (isset($document->agreement_id))
    <input type="hidden" name="agreement_id" value="{{ $document->agreement_id }}">
    @endif

    @if (isset($document->addendum_id))
    <input type="hidden" name="addendum_id" value="{{ $document->addendum_id }}">
    @endif

    <div class="row mb-3 g-2">
        <div class="form-group col-2">
            <label for="forDate">Fecha</label>
            <input type="date" class="form-control" id="forDate" name="date" value="{{ now()->toDateString() }}">
        </div>
        <div class="form-group col-2">
            <label for="forType">Tipo*</label>
            <select name="type_id" id="formType" class="form-select" required>
                <option value=""></option>
                @foreach($types as $id => $type)
                <option value="{{ $id }}" {{$document->type_id == $id ? 'selected': ''}}>{{ $type }}</option>
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

    <div class="row mb-3 g-2">
        <div class="form-group col">
            <label for="forSubject">Materia*</label>
            <input type="text" class="form-control" id="forSubject" name="subject" placeholder="Descripción del contenido del documento" required maxlength="255" {!! $document->subject ? 'value="' . $document->subject .'"' : '' !!}>
        </div>
    </div>

    <div id="collapse">
        <div class="row mb-3">
            <div class="form-group col-7">
                <label for="forFrom">De:*</label>
                <input type="text" class="form-control" id="forFrom" name="from" placeholder="Nombre/Funcion" required {!! $document->from ? 'value="' . $document->from .'"' : '' !!}>
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-group col-7">
                <label for="forFor">Para:*</label>
                <input type="text" class="form-control" id="forFor" name="for" placeholder="Nombre/Funcion" required {!! $document->for ? 'value="' . $document->for .'"' : '' !!}>
            </div>
        </div>
        <div class="row mb-3">
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

    <div class="row mb-3">
        <div class="form-group" style="width: 940px;">
            <label for="contenido">Contenido*</label>
            <textarea class="form-control" id="contenido" rows="44" name="content">{!! $document->content !!}</textarea>
        </div>
    </div>
        
    <div class="row mb-3 g-2">
        <div class="form-group col">
            <label for="forDistribution">Distribución (separado por salto de línea)*</label>
            <textarea class="form-control" id="forDistribution" rows="6" name="distribution" required>{!! $document->distribution ?? '' !!}</textarea>
        </div>

        <div class="form-group col">
            <label for="forResponsible">Responsables (separado por salto de línea)</label>
            <textarea class="form-control" id="forResponsible" rows="6" name="responsible">{!! $document->responsible ? $document->responsible : '' !!}</textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="form-group col-3">
            <label for="for_internal_number">Número Interno (Opcional)</label>
            <input type="number" class="form-control" id="for_internal_number" name="internal_number" {!! $document->internal_number ? 'value="' . $document->internal_number .'"' : '' !!}>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Guardar</button>
    <!-- <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="¡ Tampoco me pongas el mouse encima !" onclick="alert('Noooo, si pones Aceptar se borrará todo.');">No apretar</button> -->
</form>

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
        $('#formType').change()
    })

    $('#formType').change(
        function() {
            $("#collapse").show();
            /* Memo */
            if ("1" === this.value) {
            }
            /* Oficio */
            if ("2" === this.value) {
                $("#forDate").val("");
            }
            /* Carta */
            if ("3" === this.value) {
            }
            /* Circular */
            if ("4" === this.value) {
                $("#forFrom").removeAttr("required");
                $("#forFor").removeAttr("required");
                $("#collapse").hide();
            }
            /* Resolución */
            if ("5" === this.value) {
                $("#forFrom").removeAttr("required");
                $("#forFor").removeAttr("required");
                $("#forSubject").removeAttr("required");
                $("#collapse").hide();
                $("#forDate").val("");
                var contenido = '<h4>VISTOS</h4><div style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti!</div><h4>CONSIDERANDO</h4><ol><li><span style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti! </span></li><li><span style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti!</span></li></ol><h4>RESUELVO</h4><ol><li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti!</li><li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti!</li><li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti!</li></ol><h4 style="text-align: center;">&nbsp;</h4><h4 style="text-align: center;"><strong>AN&Oacute;TESE, COMUN&Iacute;QUESE, ARCH&Iacute;VESE.</strong></h4>';
                tinyMCE.activeEditor.setContent(contenido);
            }
            /* Convenio */
            if ("6" === this.value) {
                $("#forFrom").removeAttr("required");
                $("#forFor").removeAttr("required");
                $("#collapse").hide();
            }
            /* Ordinario */
            if ("7" === this.value) {

            }
            /* Informe */
            if ("8" === this.value) {
                $("#forFrom").removeAttr("required");
                $("#forFor").removeAttr("required");
                $("#collapse").hide();
            }
            /* Protocolo */
            if ("9" === this.value) {
                $("#forFrom").removeAttr("required");
                $("#forFor").removeAttr("required");
                $("#collapse").hide();
            }
            /* Acta */
            if ("10" === this.value) {
                $("#forFrom").removeAttr("required");
                $("#forFor").removeAttr("required");
                $("#collapse").hide();
                var contenido = '<h2 style="text-align: center; text-decoration: underline;">ACTA DE REUNI&Oacute;N</h2><p><strong>Datos de la reuni&oacute;n:</strong></p><table style="border-collapse: collapse; width: 100%;" border="1" cellpadding="5"><tbody><tr style="height: 25px;"><td><strong>Fecha:</strong></td><td style="width: 15%; text-align: center;">&nbsp;</td><td style="width: 15%; text-align: center;"><strong>Hora inicio:&nbsp;</strong></td><td style="width: 15%; text-align: center;">&nbsp;</td><td style="width: 15%; text-align: center;"><strong>Hora t&eacute;rmino:</strong></td><td style="width: 15%; text-align: center;">&nbsp;</td></tr><tr style="height: 25px;"><td><strong>Tipo</strong>:</td><td colspan="5">&nbsp;[<strong>&nbsp; &nbsp;</strong>] Ordinaria - [<strong>&nbsp; &nbsp;</strong>] Lobby con instituci&oacute;n :&nbsp;&nbsp;</td></tr><tr style="height: 25px;"><td><strong>Mecanismo:</strong></td><td colspan="5">&nbsp;[<strong>&nbsp; &nbsp;</strong>] Presencial&nbsp; - [<strong>&nbsp; &nbsp;</strong>] Video Conferencia&nbsp; - [<strong>&nbsp; &nbsp;</strong>] Otro:</td></tr></tbody></table><p><strong>Temas tratados:</strong></p><table style="width: 100%; border-collapse: collapse;" border="1"><tbody><tr><td><ol><li>&nbsp;</li></ol></td></tr></tbody></table><p><strong>Asistentes y expositores</strong></p><table style="width: 100%; border-collapse: collapse;" border="1" cellpadding="5"><tbody><tr style="height: 25px;"><td><strong>Nombre completo</strong></td><td><strong>Cargo</strong></td><td><strong>Instituci&oacute;n</strong></td><td><strong>Expositor</strong></td></tr><tr style="height: 25px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="width: 8.5%; text-align: center;">[<strong>&nbsp; &nbsp;</strong>]</td></tr><tr style="height: 25px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="width: 8.5%; text-align: center;">[<strong>&nbsp; &nbsp;</strong>]</td></tr><tr style="height: 25px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="width: 8.5%; text-align: center;">[<strong>&nbsp; &nbsp;</strong>]</td></tr><tr style="height: 25px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="width: 8.5%; text-align: center;">[<strong>&nbsp; &nbsp;</strong>]</td></tr></tbody></table><p><strong>Acuerdos:</strong></p><table style="width: 100%; border-collapse: collapse;" border="1"><tbody><tr><td><ol><li>&nbsp;</li></ol></td></tr></tbody></table><p>&nbsp;</p>';
                tinyMCE.activeEditor.setContent(contenido);
            }
            /* Acta de recepción */
            if ("11" === this.value) {
                var contenido = '<h1 style="text-align: center; text-decoration: underline;">ACTA DE RECEPCIÓN</h1> <p><strong>Datos de ubicación</strong></p> <table style="width: 100%; border-collapse: collapse;" border="1" cellpadding="2"> <tbody> <tr> <td style="width: 30%; height: 30px;">Establecimiento</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Dirección</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Unidad Organizacional</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Ubicación (oficina)</td> <td></td> </tr> </tbody> </table> <p><strong>Características de la especie</strong></p> <table style="width: 100%; border-collapse: collapse;" border="1" cellpadding="2"> <tbody> <tr> <td style="width: 30%; height: 30px;">Inventario SSI</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Tipo de equipo</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Marca</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Modelo</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Número de serie</td> <td></td> </tr> </tbody> </table> <p><strong>Responsable</strong></p> <table style="width: 100%; border-collapse: collapse;" border="1" cellpadding="2"> <tbody> <tr> <td style="width: 30%; height: 30px;">Nombre completo</td> <td></td> </tr> <tr> <td style="width: 30%; height: 30px;">Función / cargo</td> <td></td> </tr>  </tbody> </table> <table style="height: 36px; width: 100%; border-collapse: collapse; margin-top: 60px" border="0"><tbody><tr><td style="width: 50%; height: 18px; text-align: center;">__________________________</td><td style="width:50%; height: 18px; text-align: center;">__________________________</td></tr><tr><td style="width: 50%; height: 18px; text-align: center;">{{ auth()->user()->tinyName }}</td><td style="width: 50%; height: 18px; text-align: center;">SSI</td></tr><tr><td style="width: 50%; height: 18px; text-align: center;"><strong>Quien entrega</strong></td><td style="width: 50%; height: 18px; text-align: center;"><strong>Quien recepciona</strong></td></tr><tr><td></td><td style="width: 50%; height: 38px; text-align: center;"><br>_____/_____/_____________</td></tr></tbody></table>';
                tinyMCE.activeEditor.setContent(contenido);
            }
            /* Acta de recepción obras menores */
            if ("12" === this.value) {
                var contenido = '<h1 style="text-align: center; text-decoration: underline;">ACTA DE RECEPCION CONFORME</h1><br><h1 style="text-align: center; text-decoration: underline;">OBRAS MENORES Nº </h1><p>En Iquique, a dìa de mes 202x se emite el "Acta Recepción", que corresponde a:</p> <table border="1" cellspacing="0"  cellpadding="0"> <tbody> <tr> <td width="151"valign="top"> <p>Servicio</p> </td> <td width="438"valign="top"> </td></tr><tr><td width="151"valign="top"> <p>Unidad Requirente</p></td> <td width="438"valign="top"></td></tr><tr><td width="151"valign="top"><p>FR</p></td> <td width="438"valign="top"> </td></tr><tr><td width="151"valign="top"> <p>Proveedor</p></td> <td width="438"valign="top"></td></tr><tr><td width="151"valign="top"><p>Cotización</p></td> <td width="438"valign="top"> </td></tr><tr><td width="151"valign="top"> <p>Fuente Financiamiento</p></td> <td width="438"valign="top"> </td> </tr> </tbody> </table><br><br><table border="1"cellspacing="0" cellpadding="0"width="586"><tbody><tr><td width="85"rowspan="2"><p align="center"><strong>DISPOSITIVO</strong></p></td><td width="170"rowspan="2"><p align="center"><strong>TRABAJOS SOLICITADOS</strong></p></td><td width="331"colspan="3"valign="top"><p align="center"><strong>TRABAJOS REALIZADOS</strong></p></td></tr><tr><td width="66"valign="top"><p align="center"><strong>Realizado</strong></p></td><td width="66"valign="top"><p align="center"><strong>No Realizado</strong></p></td><td width="198"><p align="center"><strong>Observaciones</strong></p></td></tr><tr><td width="85"rowspan="7"></td><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"><p align="center"></p></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"><p align="center"></p></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="586"colspan="5"><p><strong>OTROS</strong></p></td></tr><tr><td width="85"></td><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="85"></td><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr><tr><td width="85"></td><td width="170"></td><td width="66"valign="top"></td><td width="66"valign="top"><p align="right"></p></td><td width="198"><p align="right"></p></td></tr></tbody></table><br><br><br><p>NOTA:<br/>Se deja constancia que se recepcionan conforme<br/>Para constancia firman:</p>';
                tinyMCE.activeEditor.setContent(contenido);
            }
            /* Resolución de continuidad convenio */
            if ("19" === this.value) {
                $("#forFrom").removeAttr("required");
                $("#forFor").removeAttr("required");
                $("#collapse").hide();
            }
            /* Certificado disponibilidad presupuestaria */
            if ("21" === this.value) {
                $("#forFrom").removeAttr("required");
                $("#forFor").removeAttr("required");
                $("#collapse").hide();
            }
            /* Resolución */
            if ("23" === this.value) {
                $("#forFrom").removeAttr("required");
                $("#forFor").removeAttr("required");
                $("#forSubject").removeAttr("required");
                $("#collapse").hide();
                $("#forDate").val("");
                var contenido = '<h4>VISTOS</h4><div style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti!</div><h4>CONSIDERANDO</h4><ol><li><span style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti! </span></li><li><span style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti!</span></li></ol><h4>RESUELVO</h4><ol><li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti!</li><li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti!</li><li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit eligendi officia veritatis doloremque dolore harum necessitatibus, ad, natus accusantium quaerat quisquam amet eos, nihil ab dicta soluta numquam temporibus deleniti!</li></ol><h4 style="text-align: center;">&nbsp;</h4><h4 style="text-align: center;"><strong>AN&Oacute;TESE, COMUN&Iacute;QUESE, ARCH&Iacute;VESE.</strong></h4>';
                tinyMCE.activeEditor.setContent(contenido);
            }
        }
    );
</script>

@endsection