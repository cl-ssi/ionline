<div class="card">
    <div class="card-header">
        {{ $requestForm->purchaseMechanism->name }} - <strong>{{ $requestForm->purchaseType->name }}</strong>
    </div>
    <div class="card-body">
      <div class="form-row">
          <fieldset class="form-group col-sm-12">
              <label for="for_description">Descripción de la compra:</label>
              <input type="text" class="form-control form-control-sm" id="for_description" name="description" required>
          </fieldset>
      </div>

      <div class="form-row">
          <!-- <fieldset class="form-group col-sm-2">
              <label for="for_date">Fecha</label>
              <input type="date" class="form-control form-control-sm" id="for_date" name="date"
                  value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
          </fieldset> -->

          <fieldset class="form-group col-sm-4">
              <label for="for_description">Nº Resol. de las Bases Administrativas:</label>
              <input type="text" class="form-control form-control-sm" id="for_description" name="description" required>
          </fieldset>

          <fieldset class="form-group col-sm-4">
              <label for="for_description">Nº Resol. de Adjudicación:</label>
              <input type="text" class="form-control form-control-sm" id="for_description" name="description" required>
          </fieldset>

          <fieldset class="form-group col-sm-4">
              <label for="for_description">Nº Resol. Desierta:</label>
              <input type="text" class="form-control form-control-sm" id="for_description" name="description" required>
          </fieldset>

      </div>

      <div class="form-row">
          <fieldset class="form-group col-sm-6">
              <label for="for_supplier" >Proveedor</label>
              <select name="supplier_id" id="for_supplier_id" class="form-control form-control-sm" required>
                  <option value="">Seleccione...</option>
                  @foreach($suppliers as $supplier)
                      <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                  @endforeach
              </select>
          </fieldset>

          <fieldset class="form-group col-sm-3">
              <label for="for_status" >Estado de la Licitación</label>
              <select name="status" id="for_status" class="form-control form-control-sm" required>
                  <option value="">Seleccione...</option>
                  <option value="adjudicada">Adjudicada</option>
                  <option value="desierta">Desierta</option>
              </select>
          </fieldset>

          <fieldset class="form-group col-sm-3">
              <label for="for_status" >Estilo de Compra</label>
              <select name="type_of_purchase" id="for_type_of_purchase" class="form-control form-control-sm" required>
                  <option value="">Seleccione...</option>
                  <option value="suministro">Suministro</option>
                  <option value="compra inmediata">Compra Inmediata</option>
              </select>
          </fieldset>
      </div>

      <button type="submit" class="btn btn-primary float-right" id="save_btn">
          <i class="fas fa-save"></i> Guardar
      </button>

      </form>
    </div>
</div>
