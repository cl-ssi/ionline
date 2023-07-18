<div>
    <!-- Datos Personales -->
    <div class="card mb-3">
        <div class="card-body">
            <h4 class="card-title">Datos Personales</h4>
            <div class="form-row mb-3">
                <div class="col-md-2">
                    <label for="validationDefault02">RUN</label>
                    <input type="text" class="form-control" id="validationDefault02" disabled value="{{ $user->runFormat() }}">
                </div>
                <div class="col-md-3">
                    <label for="validationDefault01">Nombres</label>
                    <input type="text" class="form-control" id="validationDefault01" value="{{ $user->name }}">
                </div>
                <div class="col-md-3">
                    <label for="validationDefault02">Apellido P.</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->fathers_family }}">
                </div>
                <div class="col-md-3">
                    <label for="validationDefault02">Apellido M.</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->mothers_family }}">
                </div>
                <div class="col-1">
                    <label for=""><br></label>
                    <button type="submit" class="btn btn-primary form-control">
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-4">
                    <label for="validationDefault02">Dirección</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->address }}">
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Comuna</label>
                    <select name="" id="" class="form-control">
                        <option value="">Iquique</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Telefono</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->phone_number }}">
                </div>
                <div class="col-md-4">
                    <label for="validationDefault02">Email Personal</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Email personal" value="{{ $user->email_personal }}">
                        <div class="input-group-append">
                            @if($user->email_verified_at)
                            <button class="btn btn-success" title="Email verificado" disabled type="button" id="button-addon2">
                                <i class="fas fa-envelope"></i>
                            </button>
                            @else
                            <button class="btn btn-warning" title="Verificar email" type="button" id="button-addon2">
                                <i class="fas fa-envelope"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>