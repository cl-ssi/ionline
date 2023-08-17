<div class="card border-info mb-3">
    <div class="card-body">
        <h5 class="card-title">Finanzas</h5>
        <div class="form-row">
            <fieldset class="form-group col-6 col-md-2">
                <label for="for_bill_number">N° Boleta</label>
                <input type="text" class="form-control" name="bill_number" value="{{ $fulfillment->bill_number }}">
            </fieldset>
            <fieldset class="form-group col-6 col-md-2">
                <label for="for_total_hours_paid">Tot. hrs pagadas per.</label>
                <input type="text" class="form-control" name="total_hours_paid" value="{{ $fulfillment->total_hours_paid }}">
            </fieldset>
            <fieldset class="form-group col-6 col-md-2">
                <label for="for_total_paid">Total pagado</label>
                <input type="text" class="form-control" name="total_paid" value="{{ $fulfillment->total_paid }}">
            </fieldset>
            <fieldset class="form-group col-6 col-md-2">
                <label for="for_payment_date">Fecha pago*</label>
                <input type="date" class="form-control" name="payment_date" required="required" value="{{ optional($fulfillment->payment_date)->format('Y-m-d') }}">
            </fieldset>
            <fieldset class="form-group col-6 col-md-3">
                <label for="for_contable_month">Mes contable pago*</label>
                <select name="contable_month" class="form-control" required="required">
                    <option value=""></option>
                    <option value="1" @selected($fulfillment->month == 1)>Enero</option>
                    <option value="2" @selected($fulfillment->month == 2)>Febrero</option>
                    <option value="3" @selected($fulfillment->month == 3)>Marzo</option>
                    <option value="4" @selected($fulfillment->month == 4)>Abril</option>
                    <option value="5" @selected($fulfillment->month == 5)>Mayo</option>
                    <option value="6" @selected($fulfillment->month == 6)>Junio</option>
                    <option value="7" @selected($fulfillment->month == 7)>Julio</option>
                    <option value="8" @selected($fulfillment->month == 8)>Agosto</option>
                    <option value="9" @selected($fulfillment->month == 9)>Septiembre</option>
                    <option value="10" @selected($fulfillment->month == 10)>Octubre</option>
                    <option value="11" @selected($fulfillment->month == 11)>Noviembre</option>
                    <option value="12" @selected($fulfillment->month == 12)>Diciembre</option>
                </select>
            </fieldset>
        </div>
        <div class="form-row">
            <div class="col-3">
                <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
            <div class="col align-self-end">
                @if($fulfillment->finances_approbation_date)
                    @if($fulfillment->finances_approbation) 
                        <span class="badge badge-pill badge-success">Confirmado</span>
                    @else 
                        <span class="badge badge-pill badge-danger">Rechazado</span>
                    @endif - 
                    {{ $fulfillment->finances_approbation_date }} - {{ $fulfillment->financesUser->shortName }}
                @else
                    <span class="text-danger">Pendiente de aprobación</span>
                @endif
            </div>
            <div class="col-3 text-right">
                <button class="btn btn-danger" @disabled($fulfillment->finances_approbation) type="submit">Rechazar</button>
                <button class="btn btn-success" @disabled($fulfillment->finances_approbation) type="submit">Confirmar</button>
            </div>
        </div>
        @if($fulfillment->payment_rejection_detail)
        <i>{!! $fulfillment->payment_rejection_detail !!}</i>
        @endif
    </div>
</div>
