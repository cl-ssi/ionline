<div>
  <div class="card">
      <div class="card-header bg-primary text-white">
          {{ $title }}
      </div>
      <div class="card-body">
          <div class="form-row">
              <fieldset class="form-group col-sm-5">
                  <label for="for_userAuthority">Responsable:</label>
                  <input wire:model="userAuthority" name="userAuthority" class="form-control form-control-sm" type="text" readonly>
              </fieldset>

              <fieldset class="form-group col-sm-2">
                <label>Cargo:</label><br>
                <input wire:model="position" name="position" class="form-control form-control-sm" type="text" readonly>
              </fieldset>

              <fieldset class="form-group col-sm-5">
                  <label for="forRut">Unidad Organizacional:</label>
                  <input wire:model="organizationalUnit" name="organizationalUnit" class="form-control form-control-sm" type="text" readonly>
              </fieldset>
          </div>

          @if($eventType=='supply_event')
          <div class="form-row">
              <fieldset class="form-group col-sm">
                  <label>Comprador:</label><br>
                  <select wire:model.defer="supervisorUser" wire:click="resetError" name="supervisorUser" class="form-control form-control-sm" required>
                      <option value="">Seleccione...</option>
                      @foreach($lstSupervisorUser as $user)
                        <option value="{{$user->id}}">{{$user->tinnyName()}}</option>
                      @endforeach
                  </select>
                  @error('supervisorUser') <span class="error text-danger">{{ $message }}</span> @enderror
              </fieldset>

              <fieldset class="form-group col-sm">
                  <label>Mecanismo de Compra:</label><br>
                  <select wire:model="purchaseMechanism" name="purchaseMechanism" wire:change="changePurchaseMechanism" class="form-control form-control-sm" required>
                      <option value="">Seleccione...</option>
                        @foreach($lstPurchaseMechanism as $val)
                          <option value="{{$val->id}}">{{$val->name}}</option>
                        @endforeach
                  </select>
                  @error('purchaseMechanism') <span class="error text-danger">{{ $message }}</span> @enderror
              </fieldset>

              <fieldset class="form-group col-sm">
                  <label>Tipo de Compra:</label><br>
                  <select wire:model.defer="purchaseType" wire:click="resetError" name="purchaseType" class="form-control form-control-sm" required>
                      <option value="">Seleccione...</option>
                        @foreach($lstPurchaseType as $type)
                          <option value="{{$type->id}}">{{$type->name}}</option>
                      @endforeach
                  </select>
                  @error('purchaseType') <span class="error text-danger">{{ $message }}</span> @enderror
              </fieldset>

              <fieldset class="form-group col-sm">
                  <label>Unidad de Compra:</label><br>
                  <select wire:model.defer="purchaseUnit" wire:click="resetError" name="purchaseUnit" class="form-control form-control-sm" required>
                      <option value="">Seleccione...</option>
                        @foreach($lstPurchaseUnit as $unit)
                          <option value="{{$unit->id}}">{{$unit->name}}</option>
                        @endforeach
                  </select>
                  @error('purchaseUnit') <span class="error text-danger">{{ $message }}</span> @enderror
              </fieldset>
          </div>
          @endif

          @if($eventType=='budget_event')
          <div class="form-row">
              <fieldset class="form-group col-sm">
                  <label>Presupuesto actual:</label><br>
                  <input wire:model="estimated_expense" name="estimated_expense" class="form-control form-control-sm text-right" type="text" readonly>
                  @error('estimated_expense') <span class="error text-danger">{{ $message }}</span> @enderror
              </fieldset>

              <fieldset class="form-group col-sm">
                  <label>Presupuesto nuevo:</label><br>
                  <input wire:model="purchaser_amount" name="purchaser_amount" class="form-control form-control-sm text-right" type="text" readonly>
                  @error('purchaser_amount') <span class="error text-danger">{{ $message }}</span> @enderror
              </fieldset>
          </div>
          @endif

          <div class="form-row">
              <fieldset class="form-group col-sm">
                  <label for="forRejectedComment">Comentario de Rechazo:</label>
                  <textarea wire:model="rejectedComment" wire:click="resetError" name="rejectedComment" class="form-control form-control-sm" rows="3"></textarea>
                  @error('rejectedComment') <span class="error text-danger">{{ $message }}</span> @enderror
              </fieldset>
          </div>

          <div class="row justify-content-md-end mt-0">
              <div class="col-2">
                  <button type="button" wire:click="acceptRequestForm" class="btn btn-primary btn-sm float-right">Autorizar</button>
              </div>
              <div class="col-1">
                  <button type="button" wire:click="rejectRequestForm" class="btn btn-secondary btn-sm float-right">Rechazar</button>
              </div>
          </div>
      </div>
  </div>
</div>
