<div class="pb-3"><!-- Start LiveWire -->

  <div>
      @if (session()->has('message'))
          <div class="alert alert-success">
              {{ session('message') }}
          </div>
      @endif
  </div>  

  <div class="card"><!--Start Card -->
        <div class="card-header h5">
          Información Bancaria
        </div>

        <div class="card-body">

        <div class="form-row"> <!--Start Row -->
            <fieldset class="form-group col-12 col-md-5">
                <label>Banco</label>
                <select wire:model.lazy="bank_id" class="form-control" required>
                <option value="">Seleccionar Banco</option>
                @foreach($banks as $bank)
                <option value="{{$bank->id}}">{{$bank->name}}</option>
                @endforeach
                </select>
                @error('bank_id') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>

            <fieldset class="form-group col-12 col-md-3">
                <label>Número de Cuenta</label>
                <input type="number" wire:model.lazy="account_number" class="form-control" required>
                @error('account_number') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>

            <fieldset class="form-group col-12 col-md-4">
                <label for="for_pay_method">Tipo de Pago</label>
                <select wire:model.lazy="pay_method" class="form-control">
                <option value="">Seleccionar Forma de Pago</option>
                <option value="01">CTA CORRIENTE / CTA VISTA</option>
                <option value="02">CTA AHORRO</option>
                <option value="30">CUENTA RUT</option>
                </select>
                @error('pay_method') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>

        </div><!--End Row -->

        <div class="d-flex flex-row-reverse bd-highlight">
          <div class="p-0 bd-highlight">
              <button type="button" class="btn btn-sm btn-primary" wire:click="save()">
        		  <span class="fas fa-save" aria-hidden="true"></span> Actualizar Información Bancaria</button>
          </div>
        </div>

      </div><!--End Card-Body -->
  </div><!--End Card -->
</div><!-- End LiveWire -->
