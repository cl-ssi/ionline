<div>
    {{-- The whole world belongs to you. --}}
    <div class="card mx-3 mb-3 mt-0 pt-0">
      <h6 class="card-header bg-primary text-white"><i class="fas fa-signature"></i></a> Autorización Refrendación Presupuestaria</h6>
      <div class="card-body mb-1">

          <div class="row justify-content-md-center"><!-- FILA 1 -->
           <div class="form-group col-5">
             <label for="forRut">Responsable:</label>
             <input wire:model="userAuthority" name="userAuthority" class="form-control form-control-sm" type="text" readonly>
           </div>
           <div class="form-group col-2">
             <label>Cargo:</label><br>
             <input wire:model="position" name="position" class="form-control form-control-sm" type="text" readonly>
           </div>
           <div class="form-group col-5">
             <label for="forRut">Unidad Organizacional:</label>
             <input wire:model="organizationalUnit" name="organizationalUnit" class="form-control form-control-sm" type="text" readonly>
           </div>
        </div><!-- FILA 1 -->

        <div class="row justify-content-md-center"><!-- FILA 2 -->
          <div class="form-group col-6">
            <label for="forRut">Folio Requerimiento SIGFE:</label>
            <input wire:model="sigfe" name="sigfe" class="form-control form-control-sm" type="text">
          </div>
          <div class="form-group col-6">
            <label>Programa Asociado:</label><br>
            <input wire:model="program" name="program" class="form-control form-control-sm" type="text">
          </div>
        </div><!-- FILA 2 -->

        <div class="row mx-3 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
          <h6 class="card-subtitle mt-0 mb-2 text-primary">Lista de Bienes y/o Servicios:</h6>
          <table class="table table-condensed table-hover table-bordered table-sm small">
            <thead>
              <tr>
                <th>Item</th>
                <th>ID</th>
                                <th>Item Pres.</th>
                <th>Artículo</th>
                <th>UM</th>
                <th>Especificaciones Técnicas</th>
                <th>Archivo</th>
                <th>Cantidad</th>
                <th>Valor U.</th>
                <th>Impuestos</th>
                <th>Total Item</th>
              </tr>
            </thead>
            <tbody>
              @foreach($requestForm->itemRequestForms as $key => $item)
                      <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$item->id}}</td>
                          <td>
                          <select  class="form-control form-control-sm" required>
                            <option value="">Seleccione...</option>
                            @foreach($lstBudgetItem as $val)
                              <option value="{{$val->id}}">{{$val->code.' - '.$val->name}}</option>
                            @endforeach
                          </select>
                          <?php $collectItemRequest[$item->id]=$codigo; ?>
                          </td>
                          <td>{{$item->article}}</td>
                          <td>{{$item->unit_of_measurement}}</td>
                          <td>{{$item->specification}}</td>
                          <td>FILE</td>
                          <td>{{$item->quantity}}</td>
                          <td>{{$item->unit_value}}</td>
                          <td>{{$item->tax}}</td>
                          <td>{{$item->expense}}</td>
                      </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td colspan="5" rowspan="2"></td>
                <td colspan="3">Cantidad de Items</td>
                <td colspan="3">{{count($requestForm->itemRequestForms)}}</td>
              </tr>
              <tr>
                <td colspan="3">Valor Total</td>
                <td colspan="3">{{$requestForm->estimated_expense}}</td>
              </tr>
            </tfoot>
          </table>
        </div><!-- DIV para TABLA-->

        <div class="row justify-content-md-start mt-0">
            <div class="col-7">
              <label for="forRejectedComment">Comentario de Rechazo:</label>
              <textarea wire:model="rejectedComment" name="rejectedComment" class="form-control form-control-sm" rows="3"></textarea>
              @error('rejectedComment') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row justify-content-md-end mt-0"><!-- FILA BOTONES -->
          <div class="col-2">
            <button type="button" wire:click="acceptRequestForm" class="btn btn-primary btn-sm float-right">Autorizar</button>
          </div>
          <div class="col-1">
            <button type="button" wire:click="rejectRequestForm" class="btn btn-secondary btn-sm float-right">Rechazar</button>
          </div>
        </div><!-- FILA 4 --><!--Valida la variable error para que solo contenga validación de los Items-->
</div>
