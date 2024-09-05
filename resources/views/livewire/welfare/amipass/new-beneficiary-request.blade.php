<div>
    
    @include('layouts.bt4.partials.errors')
    @include('layouts.bt4.partials.flash_message')

    <h3 class="mb-3">Solicitud de Beneficio de Alimentación - AMIPASS</h3>

    <div class="alert alert-info" role="alert">
        Estimadas y Estimados: <br><br>

        La solicitud de beneficio de alimentación, deber ser creada por la jefatura directa del
        Funcionario/a como nuevo ingreso, en calidad de Planta, Contrata, Suplencias y/o reemplazos
        que desempeñen funciones en un establecimiento que no cuente con un casino.<br>

        Para hacer efectiva esta solicitud, se debe verificar el estado contractual del Funcionario/a,
        periodo en vigencia del contrato y a quién reemplaza (en el caso que corresponda). <br>

        Toda Solicitud tiene un plazo máximo de respuesta de tres días hábiles. <br> <br>

        <strong>
            Atentamente, Departamento de Calidad de Vida Laboral. <br>
        </strong>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">
                1.- Antecedentes del solicitante (solo jefatura o subrogante).<br>
                La Jefatura directa del funcionario, es la encargada de realizar la solicitud de Beneficio Alimentación
                Amipass.
            </h5>
            <p class="card-text">


            <div class="form-row">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios2" id="exampleRadios2"
                        value="yo" wire:model.live="selectedOption">
                    <label class="form-check-label" for="exampleRadios2">
                        Yo:
                    </label>
                </div>
                <div class="form-group col">
                    <label for="text">Nombre de la Jefatura *</label>
                    <input id="text" name="text" type="text" class="form-control"
                        value="{{auth()->user()->full_name}}" required="required" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios2" id="exampleRadios2"
                        value="otro" wire:model="selectedOption">
                    <label class="form-check-label" for="exampleRadios2">
                        Otro:
                    </label>
                </div>
                <div class="form-group col">
                    <label for="text">Nombre de la Jefatura *</label>
                    <input id="text" name="text" type="text" class="form-control"
                        value="{{ auth()->user()->name }}" required="required" wire:model="jefatura">
                </div>

                <div class="form-group col">
                    <label for="text2">Correo electrónico solicitante *</label>
                    <input id="text2" name="text2" type="text" class="form-control" required="required"
                        wire:model="correoElectronico">
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col">
                    <label for="text1">Cargo y Unidad ó Departamento al que pertenece. *</label>
                    <input id="text1" name="text1" type="text" class="form-control" required="required"
                        wire:model="cargoUnidad">
                </div>

                <div class="form-group col">
                    <label for="select1">Establecimiento</label>
                    <div>
                        <select id="select1" name="select1" class="custom-select" wire:model="selectedEstablishmentId"
                            required>
                            <option value="">Seleccionar Establecimiento</option>
                            @foreach ($establecimientos as $establecimiento)
                                <option value="{{ $establecimiento->id }}"
                                    @if ($establecimiento->id == $selectedEstablishmentId) selected @endif>
                                    {{ $establecimiento->official_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>


            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Motivo del requerimiento *</label>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                                value="Suplencia o Reemplazo por Renuncia" wire:model="motivoRequerimiento">
                            <label class="form-check-label" for="exampleRadios1">
                                Suplencia o Reemplazo por Renuncia
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                                value="Suplencia o Reemplazo por Licencia Medica" wire:model="motivoRequerimiento">
                            <label class="form-check-label" for="exampleRadios2">
                                Suplencia o Reemplazo por Licencia Medica
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                                value="Suplencia o Reemplazo por Permiso sin Goce de Sueldo"
                                wire:model="motivoRequerimiento">
                            <label class="form-check-label" for="exampleRadios3">
                                Suplencia o Reemplazo por Permiso sin Goce de Sueldo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                                value="Suplencia o reemplazo por Feriado Legal" wire:model="motivoRequerimiento">
                            <label class="form-check-label" for="exampleRadios3">
                                Suplencia o reemplazo por Feriado Legal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                                value="Creacion de Cargo" wire:model="motivoRequerimiento">
                            <label class="form-check-label" for="exampleRadios3">
                                Creacion de Cargo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                                value="Continuidad" wire:model="motivoRequerimiento">
                            <label class="form-check-label" for="exampleRadios3">
                                Continuidad
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                                value="Contrato transitorio" wire:model="motivoRequerimiento">
                            <label class="form-check-label" for="exampleRadios3">
                                Contrato transitorio
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                                value="Ingreso de Funcionario en Comisión de Servicios en la DSST"
                                wire:model="motivoRequerimiento">
                            <label class="form-check-label" for="exampleRadios3">
                                Ingreso de Funcionario en Comisión de Servicios en la DSST
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                                value="Otro" wire:model="motivoRequerimiento">
                            <label class="form-check-label" for="exampleRadios3">
                                Otro
                            </label>
                        </div>

                    </div>

                </div>
                <div class="form-group col-6">
                    <label for="text3">Nombre del funcionario/a A REEMPLAZAR, según motivo del requerimiento</label>
                    <input id="text3" name="text3" type="text" class="form-control"
                        wire:model="nombreFuncionarioReemplazar">
                    <small id="emailHelp" class="form-text text-muted">Si no es una suplencia o reemplazo, indique NO
                        CORRESPONDE</small>
                </div>
            </div>

            </p>
        </div>
    </div>



    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">
                2.- Datos de Beneficiario/a:<br>
                Ingresar antecedentes de nuevo funcionario a recibir Beneficio de Alimentación Amipass.
            </h5>
            <p class="card-text">


            <div class="form-row">
                <div class="form-group col-3">
                    <label for="text5">RUT de Funcionario/a*</label>
                    <input id="text5" name="text5" type="text" class="form-control"
                        placeholder="Ejemplo: 12345678-9" wire:model="rutFuncionario">
                    <small id="emailHelp" class="form-text text-muted">SIN PUNTOS Y CON GUION</small>
                </div>
                <div class="form-group col-6">
                    <label for="text6">Nombre Completo (nombres y apellidos) *</label>
                    <input id="text6" name="text6" type="text" class="form-control"
                        wire:model="nombreCompleto">
                </div>
                <div class="form-group col-3">
                    <label for="text9">Fecha de Nacimiento *</label>
                    <input id="text9" name="text9" type="date" required="required" class="form-control"
                        wire:model="fechaNacimiento">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col">
                    <label for="text7">Correo electrónico "PERSONAL" *</label>
                    <input id="text7" name="text7" type="text" class="form-control"
                        wire:model="correoPersonal">
                </div>
                <div class="form-group col">
                    <label for="text8">Número de celular (9-12345678) *</label>
                    <input id="text8" name="text8" type="text" required="required" class="form-control"
                        wire:model="celular">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-3">
                    <label for="text11">Fecha de inicio de contrato</label>
                    <input id="text11" name="text11" type="date" class="form-control"
                        wire:model="fechaInicioContrato">
                    <small id="emailHelp" class="form-text text-muted">Contrata, suplencia y/o reemplazo</small>
                </div>
                <div class="form-group col-3">
                    <label for="text12">Fecha de termino de contrato</label>
                    <input id="text12" name="text12" type="date" class="form-control"
                        wire:model="fechaTerminoContrato">
                    <small id="emailHelp" class="form-text text-muted">De acuerdo a los respaldos existentes Ej.
                        duración de Licencia Médica, suplencia, etc.</small>
                </div>

                <div class="form-group col-6">
                    <label for="text10">Donde cumplirá funciones (especificar)</label>
                    <input id="text10" name="text10" type="text" class="form-control"
                        wire:model="dondeCumpliraFunciones">
                    <small id="emailHelp" class="form-text text-muted">Unidad organizacional, Establecimiento o
                        Residencia</small>
                </div>
            </div>


            <div class="form-group">
                <label>Jornada Laboral*</label>
                <div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input name="radio1" id="radio1_0" type="radio" class="custom-control-input"
                            value="Diurna (44 hrs.)" wire:model="jornadaLaboral">
                        <label for="radio1_0" class="custom-control-label">Diurna (44 hrs.)</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input name="radio1" id="radio1_1" type="radio" class="custom-control-input"
                            value="Diurna (33 hrs.)" wire:model="jornadaLaboral">
                        <label for="radio1_1" class="custom-control-label">Diurna (33 hrs.)</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input name="radio1" id="radio1_2" type="radio" class="custom-control-input"
                            value="3° Turno" wire:model="jornadaLaboral">
                        <label for="radio1_2" class="custom-control-label">3° Turno</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input name="radio1" id="radio1_3" type="radio" class="custom-control-input"
                            value="4° Turno" wire:model="jornadaLaboral">
                        <label for="radio1_3" class="custom-control-label">4° Turno</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input name="radio1" id="radio1_4" type="radio" class="custom-control-input"
                            value="SAMU Periférico" wire:model="jornadaLaboral">
                        <label for="radio1_4" class="custom-control-label">SAMU Periférico</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input name="radio1" id="radio1_5" type="radio" class="custom-control-input"
                            value="SAMU Diurno" wire:model="jornadaLaboral">
                        <label for="radio1_5" class="custom-control-label">SAMU Diurno</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input name="radio1" id="radio1_6" type="radio" class="custom-control-input"
                            value="SAMU Turno" wire:model="jornadaLaboral">
                        <label for="radio1_6" class="custom-control-label">SAMU Turno</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="text14">Sólo Jornada en Turno: Especificar Dependencias.</label>
                <input id="text14" name="text14" type="text" class="form-control" wire:model="residencia">
            </div>
            <div class="form-group">
                <label>Ha utilizado antes el beneficio en SSI</label>
                <div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input name="radio2" id="radio2_0" type="radio" class="custom-control-input"
                            value="Sí" wire:model="haUtilizadoAmipass">
                        <label for="radio2_0" class="custom-control-label">Sí</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input name="radio2" id="radio2_1" type="radio" class="custom-control-input"
                            value="No" wire:model="haUtilizadoAmipass">
                        <label for="radio2_1" class="custom-control-label">No</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button wire:click="save" type="button" class="btn btn-primary">Guardar</button>
            </div>
            </p>
        </div>
    </div>

    <div class="alert alert-info" role="alert">
        <strong>Una vez recibida la solicitud: <br></strong>
        <p>
            Para entregar una correcta asignación al Beneficio de Alimentación:
        </p>
        <ul>
            <li>
                Se analizaran los datos y se confirmará que se cumplan los requisitos para la correcta asignación y
                carga Amipass.
            </li>
            <li>
                Toda Solicitud tiene un plazo máximo de respuesta de tres días hábiles.
            </li>
            <li>
                De no contar con contrato vigente, la asignación del beneficio quedará pendiente
                hasta que se confirme con la Unidad de personal la continuidad del/la Funcionario/a.
            </li>
        </ul>

    </div>

</div>
