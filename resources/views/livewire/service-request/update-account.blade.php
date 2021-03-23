<div>
    <h6>Información Bancaria/de Contacto</h6>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <div class="form-row">
    <fieldset class="form-group col-4">
        <label>Banco</label>        
        <select wire:model="bank_id" class="form-control" required>
        <option value="">Seleccionar Banco</option>
        @foreach($banks as $bank)
        <option value="{{$bank->id}}">{{$bank->name}}</option>
        @endforeach
        </select>
        @error('bank_id') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
    

    <fieldset class="form-group col-4">
        <label>Número de Cuenta</label>
        <input type="text" wire:model="account_number" class="form-control" required>
        @error('account_number') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
    
    

    <fieldset class="form-group col-4">
        <label for="for_pay_method">Tipo de Pago</label>
        <select wire:model="pay_method" class="form-control">
        <option value="">Seleccionar Forma de Pago</option>
        <option value="01">CTA CORRIENTE / CTA VISTA</option>
        <option value="02">CTA AHORRO</option>
        <option value="30">CUENTA RUT</option>
        </select>
        @error('pay_method') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>   
    </div>

    <div class="form-row">
    <fieldset class="form-group col-4">
        <label>Número de Teléfono</label>
        <input type="text" wire:model="phone_number" class="form-control" required>
        @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
    


    <fieldset class="form-group col-4">
        <label>E-mail</label>
        <input type="email" wire:model="email" class="form-control" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
    
    </div>

    <br>

    <button wire:click="save()" type="button">Guardar/Actualizar</button>
</div>
