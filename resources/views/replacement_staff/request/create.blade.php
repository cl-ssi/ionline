@extends('layouts.app')

@section('title', 'Solicitud')

@section('content')

@include('replacement_staff.nav')

<div class="card">
    <div class="card-header">
        Formulario Solicitud Contratación de Personal
    </div>
    <div class="card-body">

        <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.store') }}">
            @csrf
            @method('POST')

            <!-- <div class="form-row">
                <fieldset class="form-group col">
                    <label for="for_name">Nombre de Cargo</label>
                    <input type="text" class="form-control" name="name"
                        id="for_name" required>
                </fieldset>
            </div> -->

            <div class="form-row">
                <fieldset class="form-group col-6">
                    <label for="for_name">Nombre de Cargo</label>
                    <input type="text" class="form-control" name="name"
                        id="for_name" required>
                </fieldset>

                <fieldset class="form-group col-2">
                    <label for="degree">Grado</label>
                    <input type="number" class="form-control" name="degree"
                        id="for_degree" min="1" max="26" required>
                </fieldset>

                <fieldset class="form-group col-4">
                    <label for="for_legal_quality" >Calidad Jurídica</label>
                    <select name="legal_quality" id="for_legal_quality" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <option value="to hire">Contrata</option>
                        <option value="fee">Honorarios</option>
                    </select>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-6">
                    <label for="for_calidad_juridica">Jornada</label>
                    <div class="mt-1">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="work_day" id="for_work_day_diurnal" value="diurnal" required>
                          <label class="form-check-label" for="for_work_day_diurnal">Diurno</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="work_day" id="for_work_day_third_shift" value="third_shift" required>
                          <label class="form-check-label" for="for_work_day_third_shift">Tercer Turno</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="work_day" id="for_work_day_fourth_shift" value="fourth_shift" required>
                          <label class="form-check-label" for="for_work_day_fourth_shift">Cuarto Turno</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="work_day" id="for_work_day_other" value="other" required>
                          <label class="form-check-label" for="for_work_day_other">Otro</label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group col-6">
                    <label for="for_name">&nbsp;</label>
                    <input type="text" class="form-control" name="other_work_day"
                        id="for_other_work_day" placeholder="Otro">
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-3">
                    <label for="for_start_date">Desde</label>
                    <input type="date" class="form-control" name="start_date"
                        id="for_start_date" required>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_end_date">Hasta</label>
                    <input type="date" class="form-control" name="end_date"
                        id="for_end_date" required>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_fundament">Fundamento</label>
                    <select name="fundament" id="for_fundament" class="form-control">
                        <option value="">Seleccione...</option>
                        <option value="replacement">Reemplazo o suplencia</option>
                        <option value="quit">Renuncia</option>
                        <option value="allowance without payment">Permiso sin goce de sueldo</option>
                        <option value="regularization work position">Regulación de cargos</option>
                        <option value="expand work position">Cargo expansión</option>
                        <option value="vacations">Feriado legal</option>
                        <option value="other">Otro</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_name_to_replace">&nbsp;</label>
                    <input type="text" class="form-control" name="name_to_replace"
                        id="for_name_to_replace" placeholder="Nombre de Reemplazo">

                    <label for="for_other_fundament">&nbsp;</label>
                    <input type="text" class="form-control" name="other_fundament"
                        id="for_other_fundament" placeholder="Otro fundamento...">
                </fieldset>
            </div>

            <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>

        </form>
    </div>
</div>

@endsection

@section('custom_js')

<script type="text/javascript">
    // ID campo oculto
    $("#for_other_work_day").hide();
    // NAME Option
    $("input[name=work_day]").click(function() {
        switch(this.value){
            case "other":
                // ID campo oculto
                $("#for_other_work_day").show("slow");
                break;
            default:
                // ID campo oculto
                $("#for_other_work_day").hide("slow");
                document.getElementById('for_other_work_day').value = '';
                break;
        }
    });
</script>

<script type="text/javascript">
    $("#for_name_to_replace").hide();
    $("#for_other_fundament").hide();
    jQuery('select[name=fundament]').change(function(){
        var fieldsetName = $(this).val();
        alert(fieldsetName);
        switch(this.value){
            case "replacement":
                // ID campo oculto
                $("#for_name_to_replace").show();
                $("#for_other_fundament").hide();
                document.getElementById('for_other_fundament').value = '';
                break;
            case "quit":
                // ID campo oculto
                $("#for_name_to_replace").show();
                $("#for_other_fundament").hide();
                document.getElementById('for_other_fundament').value = '';
                break;
            case "allowance without payment":
                // ID campo oculto
                $("#for_name_to_replace").show();
                $("#for_other_fundament").hide();
                document.getElementById('for_other_fundament').value = '';
                break;
            case "other":
                // ID campo oculto
                $("#for_other_fundament").show();
                $("#for_name_to_replace").hide();
                document.getElementById('for_name_to_replace').value = '';
                break;
            default:
                // ID campo oculto
                $("#for_name_to_replace").hide();
                document.getElementById('for_name_to_replace').value = '';
                $("#for_other_fundament").hide();
                document.getElementById('for_other_fundament').value = '';
                break;
        }
    });
</script>

@endsection
