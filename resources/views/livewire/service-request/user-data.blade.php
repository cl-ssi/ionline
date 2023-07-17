<div>
    <!-- Datos Personales -->
    <div class="card mb-3">
        <div class="card-body">
            <h4 class="card-title">Datos Personales</h4>
            <div class="form-row mb-3">
                <div class="col-md-2">
                    <label for="validationDefault02">Run.</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->runFormat() }}">
                </div>
                <div class="col-md-3">
                    <label for="validationDefault01">Nombres</label>
                    <input type="text" class="form-control" id="validationDefault01" value="{{ $user->name }}">
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Apellido P.</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->fathers_family }}">
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Apellido M.</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->mothers_family }}">
                </div>
                <div class="col-md-1">
                    <label for="validationDefault02">Sexo</label>
                    <select name="" id="" class="form-control">
                        <option value=""></option>
                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Masculino</option>
                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">F. Nac.</label>
                    <input type="date" class="form-control" id="validationDefault02" value="{{ $user->birthday }}">
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
                    <label for="validationDefault02">Email</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->email }}">
                </div>
            </div>

        </div>
    </div>
</div>