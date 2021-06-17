<div>
    {{-- The whole world belongs to you. --}}
    <div class="card mx-3 mb-3 mt-0 pt-0">
      <h6 class="card-header bg-primary text-white"><i class="fas fa-signature"></i></a> {{$title}}</h6>
      <div class="card-body mb-1">

        <div class="row justify-content-md-center"><!-- FILA 2 -->
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
        </div><!-- FILA 2 -->

        @if($eventType=='supply_event')
        <div class="row justify-content-md-start mt-0 mb-2"><!-- FILA 3 -->
          <div class="col-3">
            <label>Comprador:</label><br>
            <select wire:model.defer="supervisorUser" wire:click="resetError" name="supervisorUser" class="form-control form-control-sm" required>
                <option value="">Seleccione...</option>
              @foreach($lstSupervisorUser as $user)
                <option value="{{$user->id}}">{{$user->tinnyName()}}</option>
              @endforeach
            </select>
            @error('supervisorUser') <span class="error text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="col-3">
            <label>Unidad de Compra:</label><br>
            <select wire:model.defer="purchaseUnit" wire:click="resetError" name="purchaseUnit" class="form-control form-control-sm" required>
                <option value="">Seleccione...</option>
              @foreach($lstPurchaseUnit as $unit)
                <option value="{{$unit->id}}">{{$unit->name}}</option>
              @endforeach
            </select>
            @error('purchaseUnit') <span class="error text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="col-3">
            <label>Tipo de Compra:</label><br>
            <select wire:model.defer="purchaseType" wire:click="resetError" name="purchaseType" class="form-control form-control-sm" required>
                <option value="">Seleccione...</option>
              @foreach($lstPurchaseType as $type)
                <option value="{{$type->id}}">{{$type->name}}</option>
              @endforeach
            </select>
            @error('purchaseType') <span class="error text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="form-group col-3">
            <label>Mecanismo de Compra:</label><br>
            <select wire:model="purchaseMechanism" name="purchaseMechanism" class="form-control form-control-sm" required>
              <option value="">Seleccione...</option>
              <option value="cm<1000">Convenio Marco < 1000 UTM</option>
              <option value="cm>1000">Convenio Marco > 1000 UTM</option>
              <option value="lp">Licitación Pública</option>
              <option value="td">Trato Directo</option>
              <option value="ca">Compra Ágil</option>
            </select>
            @error('purchaseMechanism') <span class="error text-danger">{{ $message }}</span> @enderror
          </div>

        </div>
        @endif

        <div class="row justify-content-md-start mt-0"><!-- FILA 4 -->
            <div class="col-7">
              <label for="forRejectedComment">Comentario de Rechazo:</label>
              <textarea wire:model="rejectedComment" wire:click="resetError" name="rejectedComment" class="form-control form-control-sm" rows="3"></textarea>
              @error('rejectedComment') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div><!-- FILA 4 -->

        <div class="row justify-content-md-end mt-0"><!-- FILA 5 -->
          <div class="col-2">
            <button type="button" wire:click="acceptRequestForm" class="btn btn-primary btn-sm float-right">Autorizar</button>
          </div>
          <div class="col-1">
            <button type="button" wire:click="rejectRequestForm" class="btn btn-secondary btn-sm float-right">Rechazar</button>
          </div>
        </div><!-- FILA 5 -->

      </div>
    </div>
