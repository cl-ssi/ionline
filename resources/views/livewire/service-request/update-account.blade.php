<div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <h4>Información de contacto</h4>

    <div class="alert alert-warning" role="alert">
        <strong>Estimado funcionario, es importante que mantenga actualizada su información, 
        ya que ésta es utilizada para el proceso de pago.</strong>
    </div>

    <div class="form-row">
        <fieldset class="col-12 col-md-5">
            <label>Nombre</label>
            <p class="form-control">
                <strong>{{ $this->user->fullname?? '' }}</strong></p>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label>Número de Teléfono</label>
            <input type="text" wire:model.lazy="phone_number" class="form-control" required>
            @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label>E-mail</label>
            <input type="email" wire:model.lazy="email" class="form-control" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </fieldset>
    </div>
    
    <h4>Información Bancaria/de Contacto</h4>

    <div class="form-row">
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
    </div>

    <button class="btn btn-primary" wire:click="save()" type="button">Guardar</button>
</div>