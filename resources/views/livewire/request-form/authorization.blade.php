<div>
    {{-- The whole world belongs to you. --}}
    <div class="card mx-3 mb-3 mt-0 pt-0">
      <h6 class="card-header bg-primary text-white">Autorización Jefatura</h6>
      <div class="card-body mb-1">
          <div class="row justify-content-md-center"><!-- FILA 2 -->
           <div class="form-group col-5">
             <label for="forRut">Responsable:</label>
             <input name="responsable" class="form-control form-control-sm" type="text" value="" readonly>
           </div>
           <div class="form-group col-2">
             <label>Cargo:</label><br>
             <input name="position" class="form-control form-control-sm" type="text" value="" readonly>
           </div>
           <div class="form-group col-5">
             <label for="forRut">Unidad Organizacional:</label>
             <input wire:model="organizationalUnit" name="organizationalUnit" class="form-control form-control-sm" type="text" readonly>
           </div>
        </div><!-- FILA 2 -->
        <div class="row justify-content-md-end mt-0"><!-- FILA 4 -->
          <div class="col-2">
            <button type="button" wire:click="updateRequestService" class="btn btn-primary btn-sm float-right">Autorizar</button>
          </div>
          <div class="col-1">
            <button type="button" wire:click="cancelRequestService" class="btn btn-secondary btn-sm float-right">Rechazar</button>
          </div>
        </div><!-- FILA 4 --><!--Valida la variable error para que solo contenga validación de los Items-->
</div>
