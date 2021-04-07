<div>
    <div class="form-row">

        <fieldset class="form-group col col-md">
            <label for="for_bill_number">N° Boleta</label>
            <input type="text" class="form-control" name="bill_number" wire:model="bill_number">
        </fieldset>

        <fieldset class="form-group col col-md">
            <label for="for_total_hours_paid">Tot. hrs pagadas per.</label>
            <input type="text" class="form-control" name="total_hours_paid" wire:model="total_hours_paid">
        </fieldset>

        <fieldset class="form-group col col-md">
            <label for="for_total_paid">Total pagado</label>
            <input type="text" class="form-control" name="total_paid" wire:model="total_paid">
        </fieldset>

        <fieldset class="form-group col col-md-3">
            <label for="for_payment_date">Fecha pago</label>
            <input type="date" class="form-control" name="payment_date" required wire:model="payment_date">
        </fieldset>

        <fieldset class="form-group col col-md">
            <label for="for_contable_month">Mes contable pago</label>
            <select name="contable_month" class="form-control" required wire:model="contable_month">
                <option value=""></option>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
        </fieldset>
    </div>
    <button type="submit" class="btn btn-primary" wire:click="save()"> <i class="fas fa-spinner fa-spin" wire:loading wire:target="save"></i> Guardar</button>

</div>
