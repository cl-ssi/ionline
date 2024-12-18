<!-- <form method="GET" class="form-horizontal" action="{{ route('request_forms.all_forms') }}"> -->
<form method="GET" class="form-horizontal" action="#">
    <div class="form-row">
        <fieldset class="form-group col-3 col-md-2">
            <label for="for_rut">ID</label>
            <input name="id" class="form-control" placeholder="id" value="{{ old('id') }}" autocomplete="off" type="number">
            </input>
        </fieldset>

        <fieldset class="form-group col-3 col-md-2">
            <label for="for_rut">Folio</label>
            <input name="folio" class="form-control" placeholder="ej: 2022-17" value="{{ old('folio') }}" autocomplete="off" type="texts">
            </input>
        </fieldset>

        <fieldset class="form-group col-6 col-md-4">
            <label for="for_rut">Descripción </label>
            <input name="name" class="form-control" value="{{ old('name') }}" aucomplete="off">
            </input>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-6 col-md-4">
            <label for="for_rut">Usuario Gestor </label>
            <select name="request_user_id" data-container="#for-bootstrap-select" class="form-control form-control-sm selectpicker show-tick" data-live-search="true" data-size="5">
                <option value="">Seleccione...</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ (old('request_user_id')==$user->id)?'selected':''}}>{{ ucfirst($user->fullName) }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-4">
            <label for="for_rut">Administrador de Contrato</label>
            <select name="contract_manager_id" data-container="#for-bootstrap-select" class="form-control form-control-sm selectpicker show-tick" data-live-search="true" data-size="5">
                <option value="">Seleccione...</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ (old('contract_manager_id')==$user->id)?'selected':''}}>{{ ucfirst($user->fullName) }}</option>
                @endforeach
            </select>
        </fieldset>
    </div>
    <div class="form-row">
        <fieldset class="form-group col-6 col-md-4">
            <label for="for_rut">Comprador</label>
            <select name="purchaser_user_id" data-container="#for-bootstrap-select" class="form-control form-control-sm selectpicker show-tick" data-live-search="true" data-size="5">
                <option value="">Seleccione...</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ (old('purchaser_user_id')==$user->id)?'selected':''}}>{{ ucfirst($user->fullName) }}</option>
                @endforeach
            </select>
        </fieldset>
        <fieldset class="form-group col-5 col-md-2">
        <label for="">&nbsp;</label>
        <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
    </fieldset>

    </div>


    
    </div>
</form>