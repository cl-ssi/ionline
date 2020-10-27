<div class="card mt-4 d-print-none">
    <div class="card-body">

        <h5 class="card-title">Agregar Pasajeros</h5>

        <!-- <form class="form-horizontal" method="POST" action="{{ route('request_forms.passages.createFromPrevious', $requestForm) }}">
            @csrf
            <div class="form-row">
                <div class="form-group col-3">
                    <input type="number" class="form-control form-control-sm" id="forrun" placeholder="Ingrese RUN sin puntos ni guión..." name="run" required>
                </div>
                <div class="form-group col-2">
                    <button type="submit" class="btn btn-outline-secondary btn-sm"> <i class="fas fa-search"></i> Precargar</button>
                </div>
            </div>
        </form> -->

        <form method="POST" class="form-horizontal" action="{{ route('request_forms.passages.store', $requestForm) }}">
            @csrf
            <div class="form-row">
                <div class="form-group col-3">
                    <label for="forrun">RUN:</label>
                    <input type="number" class="form-control form-control-sm" id="forrun" placeholder="Ingrese RUN sin puntos ni guión..." name="run" required>
                </div>
                <div class="form-group col-1">
                    <label for="fordv">DV:</label>
                    <input type="number" class="form-control form-control-sm" id="fordv" placeholder="K" name="dv" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-4">
                    <label for="forname">Nombre:</label>
                    <input type="text" class="form-control form-control-sm" id="forname" placeholder="..." name="name" required>
                </div>
                <div class="form-group col-4">
                    <label for="forfathers_family">Apellido Paterno:</label>
                    <input type="text" class="form-control form-control-sm" id="forfathers_family" placeholder="..." name="fathers_family" required>
                </div>
                <div class="form-group col-4">
                    <label for="formothers_family">Apellido Paterno:</label>
                    <input type="text" class="form-control form-control-sm" id="formothers_family" placeholder="..." name="mothers_family" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-4">
            				<label for="forbirthday">Fecha Nacimiento:</label>
            				<input type="date" class="form-control form-control-sm" id="forbirthday" name="birthday" required>
        			  </div>
                <div class="form-group col-4">
                		<label for="fortelephone_number">Teléfono:</label>
                		<input type="number" class="form-control form-control-sm" id="fortelephone_number" placeholder="569xxxxxxxx" name="telephone_number" required>
              	</div>
                <div class="form-group col-4">
                		<label for="foremail">E-mail:</label>
                		<input type="email" class="form-control form-control-sm" id="foremail" placeholder="correo@redsalud.gob.cl" name="email" required>
              	</div>
        		</div>

            <div class="form-row">
                <div class="form-group col-4">
            				<label for="fordeparture_date">Fecha Ida, Hora:</label>
            				<input type="datetime-local" class="form-control form-control-sm" id="fordeparture_date" name="departure_date" required>
        			  </div>
                <div class="form-group col-4">
                		<label for="forfrom_date">Fecha Regreso, Hora:</label>
                		<input type="datetime-local" class="form-control form-control-sm" id="forfrom_date" name="from_date" required>
              	</div>
                <div class="form-group col-4">
                    <label for="forbaggage">Seleccione una opción de equipaje:</label>
                    <select class="form-control form-control-sm selectpicker" id="forbaggage" name="baggage" title="Seleccione..." data-live-search="true" data-size="5" required>
                        <option value="baggage" data-icon="fas fa-suitcase-rolling">Bodega</option>
                        <option value="hand luggage" data-icon="fas fa-suitcase">Mano</option>
                        <option value="handbag" data-icon="fas fa-briefcase">Bolso de mano</option>
                    </select>
                </div>
        		</div>

            <button class="btn btn-primary btn-sm float-right mr-3" type="submit">
                <i class="fas fa-save"></i> Enviar
            </button>

        </form>
    </div>
</div>
