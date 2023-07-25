<div class="form-row">
    <fieldset class="form-group col-12 col-md-2">
        <label for="for_type">Período</label>
        <select name="type" class="form-control" required="">
            <option value=""></option>
            <option value="Mensual" selected="">Mensual</option>
            <option value="Parcial">Parcial</option>
        </select>
    </fieldset>
    <fieldset class="form-group col-6 col-md-2">
        <label for="for_start_date">Inicio</label>
        <input type="date" class="form-control" name="start_date" value="2021-10-01" required="">
    </fieldset>
    <fieldset class="form-group col-6 col-md-2">
        <label for="for_end_date">Término</label>
        <input type="date" class="form-control" name="end_date" value="2021-10-31" required="">
    </fieldset>
    <fieldset class="form-group col-12 col-md-5">
        <label for="for_observation">Observación</label>
        <input type="text" class="form-control" name="observation" value="">
    </fieldset>
    
    <fieldset class="form-group col-1">
        <label for="for_submit"><br></label>
        <button type="submit" class="btn btn-primary form-control">
            <i class="fas fa-save"></i>
        </button>
    </fieldset>
</div>