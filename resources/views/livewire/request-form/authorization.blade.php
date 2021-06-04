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

        <div class="row justify-content-md-start mt-0"><!-- FILA 3 -->
            <div class="col-7">
              <label for="forRejectedComment">Comentario de Rechazo:</label>
              <textarea wire:model="rejectedComment" wire:click="resetError" name="rejectedComment" class="form-control form-control-sm" rows="3"></textarea>
              @error('rejectedComment') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            @if($eventType=='supply_event')
            <div class="col-5">
              <label>Usuario Asignado:</label><br>
              <select wire:model.defer="supervisorUser" wire:click="resetError" name="supervisorUser" class="form-control form-control-sm" required>
                  <option value="">Seleccione...</option>
                @foreach($lstSupervisorUser as $user)
                  <option value="{{$user->id}}">{{$user->tinnyName()}}</option>
                @endforeach
              </select>
              @error('supervisorUser') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            @endif
        </div><!-- FILA 3 -->

        <div class="row justify-content-md-end mt-0"><!-- FILA 4 -->
          <div class="col-2">
            <button type="button" wire:click="acceptRequestForm" class="btn btn-primary btn-sm float-right">Autorizar</button>
          </div>
          <div class="col-1">
            <button type="button" wire:click="rejectRequestForm" class="btn btn-secondary btn-sm float-right">Rechazar</button>
          </div>
        </div><!-- FILA 4 -->

      </div>
    </div>
