<div class="card">
    <div class="card-header">
        Orden de Compra Interna
    </div>
    <div class="card-body">
      <div class="form-row">
          <fieldset class="form-group col-sm-2">
              <label for="for_date">Fecha</label>
              <input type="date" class="form-control form-control-sm" id="for_date" name="date"
                  value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
          </fieldset>

          <fieldset class="form-group col-sm-6">
              <label for="for_supplier" >Proveedor</label>
              <select name="supplier_id" id="for_supplier_id" class="form-control form-control-sm" required>
                  <option value="">Seleccione...</option>
                  @foreach($suppliers as $supplier)
                      <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                  @endforeach
              </select>
          </fieldset>

          <fieldset class="form-group col-2">
              <label for="for_date">Condición de Pago</label>
              <input type="number" class="form-control form-control-sm" id="for_payment_condition" name="payment_condition"
                  value="">
          </fieldset>

          <fieldset class="form-group col-sm-2">
              <label for="for_estimated_delivery_date">Fecha estimada entrega</label>
              <input type="date" class="form-control form-control-sm" id="for_estimated_delivery_date" name="estimated_delivery_date"
                  value="">
          </fieldset>
      </div>

      <button type="submit" class="btn btn-primary float-right" id="save_btn">
          <i class="fas fa-save"></i> Guardar
      </button>

      </form>
    </div>
</div>