<div class="card">
    <div class="card-header">
        Fondo menor (Caja chica)
    </div>
    <div class="card-body">
      <div class="form-row">
          <fieldset class="form-group col-sm-2">
              <label for="for_date">Fecha emisión</label>
              <input type="date" class="form-control form-control-sm" id="for_date" name="date"
                  value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
          </fieldset>

          <fieldset class="form-group col-sm-3">
              <label for="for_receipt_type" >Tipo de documento</label>
              <select name="receipt_type" id="for_receipt_type" class="form-control form-control-sm" required>
                  <option value="">Seleccione...</option>
                  @php($doc_types = ['Boleta electrónica', 'Boleta electrónica exenta', 'Comprobante pago electrónico', 'Factura electrónica', 'Factura No afecta o exenta electrónica' ])
                  @foreach($doc_types as $doc_type)
                      <option value="{{ $doc_type }}">{{ $doc_type }}</option>
                  @endforeach
              </select>
          </fieldset>

          <fieldset class="form-group col-2">
              <label for="for_receipt_number">Folio</label>
              <input type="number" class="form-control form-control-sm" id="for_receipt_number" name="receipt_number"
                  value="" required>
          </fieldset>

          <fieldset class="form-group col-2">
              <label for="for_amount">Monto total</label>
              <input type="number" class="form-control form-control-sm" id="for_amount" name="amount"
                  value="" required>
          </fieldset>

          <fieldset class="form-group col-3">
               <label for="forFile">Adjuntar archivo</label>
               <input type="file" class="form-control-file" id="forFile" name="file">
          </fieldset>
      </div>

      <button type="submit" class="btn btn-primary float-right" id="save_btn">
          <i class="fas fa-save"></i> Guardar
      </button>

      </form>
    </div>
</div>

<br>