<div>
    <h6>Información Bancaria</h6>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    
    <fieldset class="form-group col-4">
        <label>Banco</label>        
        <select wire:model="bank_id" class="form-control" required>
        <option value="">Seleccionar Banco</option>
        @foreach($banks as $bank)
        <option value="{{$bank->id}}">{{$bank->name}}</option>
        @endforeach
        </select>
    </fieldset>

    <fieldset class="form-group col-4">
        <label>Número de Cuenta</label>
        <input type="number" wire:model="account_number" class="form-control" required>        
    </fieldset>
    

    <fieldset class="form-group col-4">
        <label for="for_pay_method">Forma de Pago</label>
        <select wire:model="pay_method" class="form-control">
        <option value="">Seleccionar Forma de Pago</option>
        <option value="01">CTA CORRIENTE / CTA VISTA</option>
        <option value="02">CTA AHORRO</option>
        <option value="30">CUENTA RUT</option>
        </select>       
        
    </fieldset>   

    <button wire:click="save()" type="button">Guardar/Actualizar</button>
</div>
