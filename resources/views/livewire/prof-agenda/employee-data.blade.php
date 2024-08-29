<div>
    <div class="form-row">

        <fieldset class="form-group col-5 col-md-2">
            <label for="for_run">Run (sin DV)</label>
            <input type="number" min="1" max="50000000" class="form-control" id="for_user_id" name="user_id" wire:model.blur="user_id" required>
        </fieldset>

        <fieldset class="form-group col-3 col-md-1">
            <label for="for_dv">Digito</label>
            <input type="text" class="form-control" id="for_dv" name="dv" wire:model.blur="dv" required>
        </fieldset>

        <!-- <fieldset class="form-group col-3 col-md-1">
            <label for="">&nbsp;</label>
            <button type="button" id="btn_fonasa" class="btn btn-outline-info">Fonasa&nbsp;</button>
        </fieldset> -->

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_name">Sexo</label>
            <select name="gender" id="" class="form-control">
                <option value=""></option>
                <option value="male" @if($user) @selected($user->gender == "male") @endif>Masculino</option>
                <option value="female" @if($user) @selected($user->gender == "female") @endif>Femenino</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_name">Nombres</label>
            <input type="text" class="form-control" id="for_name" name="name" required="required" @if($user) value="{{$user->name}}" @endif>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_name">A.Paterno</label>
            <input type="text" class="form-control" id="for_fathers_family" name="fathers_family" required="required" @if($user) value="{{$user->fathers_family}}" @endif>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_name">A.Materno</label>
            <input type="text" class="form-control" id="for_mothers_family" name="mothers_family" required="required" @if($user) value="{{$user->mothers_family}}" @endif>
        </fieldset>

    </div>

    @if(!$user)
        <input type="hidden" name="new_user" value="1">
        <div class="form-row">
            <fieldset class="form-group col-md-12">
                <label for="forOrganizationalUnit">Establecimiento / Unidad Organizacional</label>
                    @livewire('select-organizational-unit', [
                        'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
                        'select_id' => 'organizationalunit',
                        'aditional_ous' => [53]
                    ])
            </fieldset>
        </div>
    @else
        <input type="hidden" name="new_user" value="0">           
    @endif

    <h5>Datos de contacto</h5><hr>

    <div class="form-row">

        <fieldset class="form-group col-12 col-md-5">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control" id="foraddress" placeholder="Dirección, comuna"
                name="address" @if($user) value="{{$user->address}}" @endif>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_commune_id">Comuna</label>
            <select name="commune_id" class="form-control">
            <option value=""></option>
            @foreach($communes as $key => $commune)
                <option value="{{$commune->id}}" @selected($user && $user->commune_id == $commune->id)>{{$commune->name}}</option>
            @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_phone_number">N.telefónico</label>
            <input type="text" class="form-control" id="for_phone_number"
                name="phone_number" @if($user) value="{{$user->phone_number}}" @endif>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_email">Email institucional*</label>
            <input type="email" class="form-control" id="for_email" wire:model="email"
                name="email" @if($user) value="{{$user->email}}" @endif>
        </fieldset>

    </div>

    @if($flag_more_than_3_faults)
        <div class="alert alert-danger" role="alert">
            Atención!! Hemos detectado que el funcionario tiene 3 faltas consecutivas en los últimos dos meses
        </div>
    @endif

    <br>
    @if($message != "")
        <div class="alert alert-warning" role="alert">
            {{ $message }}
        </div>
    @endif

</div>
