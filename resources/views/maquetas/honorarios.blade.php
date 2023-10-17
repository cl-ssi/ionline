@extends('layouts.bt4.app')

@section('title', 'Maqueta Honorario')

@section('content')

<h3 class="mb-3">Perfil del Funcionario</h3>
<!-- Datos Personales -->
<div class="card mb-3">
    <div class="card-body">
        <h4 class="card-title">Datos Personales</h4>
        <div class="form-row mb-3">
            <div class="col-md-2">
                <label for="validationDefault02">Run.</label>
                <input type="text" class="form-control" id="validationDefault02" value="15.287.582-7">
            </div>
            <div class="col-md-3">
                <label for="validationDefault01">Nombres</label>
                <input type="text" class="form-control" id="validationDefault01" value="Alvaro Raymundo">
            </div>
            <div class="col-md-2">
                <label for="validationDefault02">Apellido P.</label>
                <input type="text" class="form-control" id="validationDefault02" value="Torres" >
            </div>
            <div class="col-md-2">
                <label for="validationDefault02">Apellido M.</label>
                <input type="text" class="form-control" id="validationDefault02" value="Fuchslocher" >
            </div>
            <div class="col-md-1">
                <label for="validationDefault02">Sexo</label>
                <select name="" id="" class="form-control">
                    <option value="">M</option>
                    <option value="">F</option>
                    <option value="">O</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="validationDefault02">F. Nac.</label>
                <input type="date" class="form-control" id="validationDefault02" value="1982-02-25" >
            </div>
        </div>
        <div class="form-row mb-3">
            <div class="col-md-3">
                <label for="validationDefault02">Dirección</label>
                <input type="text" class="form-control" id="validationDefault02" value="Ruben Donodo 2942" >
            </div>
            <div class="col-md-2">
                <label for="validationDefault02">Comuna</label>
                <select name="" id="" class="form-control">
                    <option value="">Iquique</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="validationDefault02">Telefono</label>
                <input type="text" class="form-control" id="validationDefault02" value="093453453" >
            </div>
            <div class="col-md-3">
                <label for="validationDefault02">Email</label>
                <input type="text" class="form-control" id="validationDefault02" value="atorres@gmail.com" >
            </div>
        </div>
    </div>
</div>
<ul class="nav justify-content-end">
    <li class="nav-item">
        <b class="nav-link">Año</b>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" href="#">2020</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" href="#">2021</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">2022</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">2023 (actual)</a>
    </li>
</ul>


<h5>Contratos</h5>

<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            
            <li class="nav-item">
                <a class="nav-link active" href="#">Diurno</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Hora extra</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Turno</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled">Hora médica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled">Mensual</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <ul class="nav mb-3">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <h5><i>id: 124</i></h5>
                    2023-01-10 <br> 
                    2023-02-28 <br>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <h5><i>id: 340</i></h5>
                    2023-03-01 <br> 
                    2023-04-30 <br>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <h5><i>id: 1240</i></h5>
                    2023-05-01 <br> 
                    2023-05-15 <br>
                </a>
            </li>
            <li>
                |<br>
                |<br>
                |<br>
                |
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <h5><i>id: 2534</i></h5>
                    2023-06-08 <br> 
                    2023-07-10 <br>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-success" href="#">
                    <h5><i>id: 14355</i></h5>
                    2023-07-11 <br> 
                    2023-08-31 <br>
                </a>
            </li>
        </ul>


        <h5 class="card-title">Contrato id: 14355</h5>
        <div class="form-row mb-3">
            <div class="col-md-3">
                <label for="validationDefault02">Programa</label>
                <select name="" id="" class="form-control" disabled>
                    <option value="">Contingencia respiratoria</option>
                    <option value="">F</option>
                    <option value="">O</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="validationDefault01">Fuente de financiamiento</label>
                <select name="" id="" class="form-control" disabled>
                    <option value="">Suma alzada</option>
                    <option value="">F</option>
                    <option value="">O</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="validationDefault02">Responsable</label>
                <input type="text" disabled class="form-control" id="validationDefault02" value="Elisabeth Contreras Guerrero" >
            </div>
            <div class="col-md-3">
                <label for="validationDefault02">Supervisor</label>
                <input type="text" disabled class="form-control" id="validationDefault02" value="Elisabeth Contreras Guerrero" >
            </div>
        </div>
        <div class="form-row mb-3">
            <div class="col-md-2">
                <label for="validationDefault02">Establecimiento</label>
                <select name="" id="" class="form-control" disabled>
                    <option value="">Servicio de Salud</option>
                    <option value="">F</option>
                    <option value="">O</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="validationDefault02">Unidad Organizacional</label>
                <select name="" id="" class="form-control" disabled>
                    <option value="">Unidad de Operaciones</option>
                    <option value="">F</option>
                    <option value="">O</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="validationDefault02">Estamento</label>
                <select name="" id="" class="form-control" disabled>
                    <option value="">Profesional</option>
                    <option value="">F</option>
                    <option value="">O</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="validationDefault02">Profesión</label>
                <select name="" id="" class="form-control" disabled>
                    <option value="">Ingeniero Informático</option>
                    <option value="">F</option>
                    <option value="">O</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="validationDefault02">Jornada</label>
                <input type="text" class="form-control" disabled id="validationDefault02" value="HORA EXTRA" >
            </div>
        </div>


        <h5 class="card-title">Aprobaciones</h5>

        <table class="table table-sm table-bordered small">
            <thead>
                <tr>
                    <th scope="col">U.Organizacional</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Observación</th>
                    <th scope="col">Fecha</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td>Extensión Hospital -Estadio</td>
                    <td>Jefa (S)</td>
                    <td>Elisabeth Cristina Contreras Guerrero</td>
                    <td>Creador</td>
                    <td class="table-success">Creada</td>
                    <td></td>
                    <td>2022-09-06 12:21:48</td>
                </tr>
                <!-- aceptado o rechazado -->
                <tr>
                    <td>Extensión Hospital -Estadio</td>
                    <td>Jefa (S)</td>
                    <td>Elisabeth Cristina Contreras Guerrero</td>
                    <td>Responsable</td>
                    <td class="table-success">Aceptada</td>
                    <td></td>
                    <td>2022-09-06 13:21:48</td>
                </tr>
                
                <tr>
                    <td>Extensión Hospital -Estadio</td>
                    <td>Jefa (S)</td>
                    <td>Elisabeth Cristina Contreras Guerrero</td>
                    <td>Supervisor</td>
                    <td class="table-success">Aceptada</td>
                    <td></td>
                    <td>2022-09-06 13:22:18</td>
                </tr>
                
                <tr>
                    <td>Subdirección de Gestión de Desarrollo de las Personas</td>
                    <td>Subdirector (S) RRHH</td>
                    <td>Juan Carlos Patricio Vega Damke</td>
                    <td>visador</td>
                    <td class="table-success">Aceptada</td>
                    <td></td>
                    <td>2022-09-06 13:23:53</td>
                </tr>
                
                <tr>
                    <td>Departamento de Finanzas</td>
                    <td>Jefe de Finanzas</td>
                    <td>Cristian Raúl Palacios Reyes</td>
                    <td>visador</td>
                    <td class="table-danger">Rechazada </td>
                    <td>No hay PPT</td>
                    <td>2022-09-08 18:25:54</td>
                </tr>
                
                <tr>
                    <td>Dirección</td>
                    <td>Director (S)</td>
                    <td>Pedro Antonio Iriondo Correa</td>
                    <td>visador</td>
                    <td>
                        <select name="" class="form-control-sm" id="">
                            <option value="">Aceptar</option>
                            <option value="">Rechazar</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control-sm">
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary">Guardar</button>
                    </td>
                </tr>
                
                <tr>
                    <td>Subdirección de Gestión del Cuidado</td>
                    <td>Subdirector SGCP</td>
                    <td>Karla Andrea Martínez Donoso</td>
                    <td>visador</td>
                    <td>
                        <select name="" class="form-control-sm" id="">
                            <option value="">Aceptar</option>
                            <option value="">Rechazar</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control-sm">
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary">Guardar</button>
                    </td>
                </tr>
                
            </tbody>
      </table>


        <h5 class="card-title">Información adicional Recursos Humanos</h5>
        <div class="form-row mb-3">
            <div class="col-md-2">
                <label for="validationCustom01">Nº resolución</label>
                <input type="text" class="form-control" id="validationCustom01" value="2355" >
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-2">
                <label for="validationCustom02">Fecha</label>
                <input type="date" class="form-control" id="validationCustom02" value="2023-04-12" >
            </div>
            <div class="col-md-2">
                <label for="validationCustom03">Monto mensualizado</label>
                <input type="text" class="form-control" id="validationCustom03" >
            </div>
            <div class="col-md-2">
                <label for="validationCustom03">Bruto/Valor Hora</label>
                <input type="text" class="form-control" id="validationCustom03" >
            </div>
            <div class="col-md-1">
                <label for="validationCustom04">SirH</label>
                <select class="custom-select" id="validationCustom04" required>
                    <option selected value="">Si</option>
                    <option>No</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFileLangHTML">
                    <label class="custom-file-label" for="customFileLangHTML" data-browse="Examinar">resolución_14355.pdf</label>
                </div>
            </div>
            <div class="col-1">
                <a class=" btn btn-outline-danger" href=""> <i class="fas fa-file-pdf"></i> </a>
            </div>
            <div class="col text-right">
                <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
        </div>

        
    </div>
</div>

<br>

<h5>Periodos</h5>

<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Ene</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Feb</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Mar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Abr <span class="badge badge-success">&nbsp;</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">May <span class="badge badge-success">&nbsp;</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Jun <span class="badge badge-success">&nbsp;</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Jul <span class="badge badge-warning">&nbsp;</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Ago</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Sep</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Oct</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Nov</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Dic</a>
            </li>
        </ul>
    </div>

    <div class="card-body">



        <div class="progress mb-3">
            <div class="progress-bar bg-success" role="progressbar" style="width: 18%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Contrato</div>
            <div class="progress-bar bg-success" role="progressbar" style="width: 18%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Responsable</div>
            <div class="progress-bar bg-success" role="progressbar" style="width: 18%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Recursos Humanos</div>
            <div class="progress-bar bg-secondary" role="progressbar" style="width: 18%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Boleta</div>
            <div class="progress-bar bg-secondary" role="progressbar" style="width: 18%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Finanzas</div>
            <div class="progress-bar bg-secondary" role="progressbar" style="width: 10%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Pagado</div>
        </div>



        <div class="card border-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Responsable </h5>

                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th>Hrs. Diurnas</th>
                            <th>Hrs. Nocturnas</th>
                            <th>Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01-08-2022 08:00</td>
                            <td>01-08-2022 20:00</td>
                            <td>12</td>
                            <td>0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>02-08-2022 20:00</td>
                            <td>03-08-2022 08:00</td>
                            <td>2</td>
                            <td>10</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Horas Diurno</th>
                            <th>Horas Nocturno</th>
                            <th>Horas Total</th>
                            <th>Horas a pagar</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>14 x 5000</td>
                            <td>10 x 5000</td>
                            <td></td>
                            <td></td>
                            <td>$120.000 <span class="text-muted small">(Se debe comprobar)</span></td>
                        </tr>
                    </tbody>
                </table>

                <fieldset class="form-group col-12 col-md-6">
                    <a type="button" class="btn btn-outline-primary" href="https://i.saludtarapaca.gob.cl/rrhh/service-request/fulfillment/certificate-pdf/85766" target="_blank">
                        Ver certificado 
                        <i class="fas fa-file"></i>
                    </a>
                    <a class="btn btn-info" href="https://i.saludtarapaca.gob.cl/rrhh/service-request/fulfillment/signed-certificate-pdf/85766/1689134297" target="_blank" title="Certificado">
                        Certificado firmado
                        <i class="fas fa-signature"></i>
                    </a>
                    <a class="btn btn-outline-danger ml-2" href="https://i.saludtarapaca.gob.cl/rrhh/service-request/fulfillment/delete-signed-certificate-pdf/85766" title="Borrar Certificado" onclick="return confirm('¿Está seguro que desea eliminar el certificado de cumplimiento firmado?')">
                    <i class="fas fa-trash"></i> Certificado
                    </a>
                </fieldset>

                <!--archivos adjuntos-->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Adjuntar archivos al cumplimiento (opcional)</h6>
                        <div>
                            <div>
                                <button class="btn btn-outline-info">
                                    <i class="fas fa-plus"></i>
                                    Agregar 
                                </button>
                                <button type="submit" class="btn btn-outline-primary float-right">
                                    <i class="fas fa-upload"></i> Subir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--fin archivos adjuntos-->

                <div class="form-row">
                    <div class="col-3">
                        <button class="btn btn-outline-secondary" type="submit" disabled>Guardar</button>
                    </div>
                    <div class="col align-text-bottom">
                        2023-03-06 10:12:25 - Ana María Mujica López
                    </div>
                    <div class="col-3 text-right">
                        <button class="btn btn-outline-danger" type="submit" disabled>Rechazar</button>
                        <button class="btn btn-success" type="submit" disabled>Confirmar</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="card mb-3 border-danger">
            <div class="card-body">
                <h5 class="card-title">Recursos Humanos</h5>
                <div class="form-row mb-3">
                    <div class="col-md-2">
                        <label for="validationCustom01">Nº resolución</label>
                        <input type="text" class="form-control" id="validationCustom01" disabled value="2355" >
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="validationCustom02">Fecha</label>
                        <input type="date" class="form-control" id="validationCustom02" disabled value="2023-04-12" >
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="validationCustom03">Total de horas a pagar</label>
                        <input type="text" class="form-control" id="validationCustom03" >
                        <div class="invalid-feedback">
                            Please provide a valid city.
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="validationCustom03">Total a pagar</label>
                        <input type="text" class="form-control" id="validationCustom03" >
                        <div class="invalid-feedback">
                            Please provide a valid city.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-3">
                        <button class="btn btn-outline-secondary" type="submit">Guardar</button>
                    </div>
                    <div class="col align-text-bottom">
                        2023-03-06 11:21:46 - Carol Lilian Pérez Rocha
                    </div>
                    <div class="col-3 text-right">
                        <button class="btn btn-outline-danger" disabled type="submit">Rechazar</button>
                        <button class="btn btn-success" disabled type="submit">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3 border-warning">
            <div class="card-body">
                <h5 class="card-title">Boleta</h5>
                <div class="form-row mb-3">
                    <div class="col">
                        <b>Valor de la boleta: </b> $ 843.233
                    </div>
                    <div class="col-md-4">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFileLangHTML">
                            <label class="custom-file-label" for="customFileLangHTML" data-browse="Examinar">boleta 213.pdf</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <a class=" btn btn-outline-primary" href=""> <i class="fas fa-file-pdf"></i> Boleta</a>
                        <a class=" btn btn-outline-danger" href=""> <i class="fas fa-trash"></i> </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Finanzas</h5>
                <div class="form-row">
                    <fieldset class="form-group col-5 col-md-2">
                        <label for="for_resolution_number">N° Resolución</label>
                        <input type="text" class="form-control" disabled="" name="resolution_number" value="13684">
                    </fieldset>
                    <fieldset class="form-group col-7 col-md-2">
                        <label for="for_resolution_date">Fecha Resolución</label>
                        <input type="date" class="form-control" disabled="" name="resolution_date" value="2021-09-24">
                    </fieldset>
                    <fieldset class="form-group col col-md-2">
                        <label for="for_total_hours_paid">Total hrs. a pagar per.</label>
                        <input type="text" class="form-control" name="total_hours_to_pay" disabled="" value="44">
                    </fieldset>
                    <fieldset class="form-group col col-md-2">
                        <label for="for_total_paid">Total a pagar</label>
                        <input type="text" class="form-control" name="total_to_pay" disabled="" value="863025">
                    </fieldset>
                </div>
                <div class="form-row">
                    <fieldset class="form-group col-6 col-md-2">
                        <label for="for_bill_number">N° Boleta</label>
                        <input type="text" class="form-control" name="bill_number" value="100">
                    </fieldset>
                    <fieldset class="form-group col-6 col-md-2">
                        <label for="for_total_hours_paid">Tot. hrs pagadas per.</label>
                        <input type="text" class="form-control" name="total_hours_paid" value="44">
                    </fieldset>
                    <fieldset class="form-group col-6 col-md-2">
                        <label for="for_total_paid">Total pagado</label>
                        <input type="text" class="form-control" name="total_paid" value="863025">
                    </fieldset>
                    <fieldset class="form-group col-6 col-md-2">
                        <label for="for_payment_date">Fecha pago</label>
                        <input type="date" class="form-control" name="payment_date" required="" value="2021-11-05">
                    </fieldset>
                    <fieldset class="form-group col-6 col-md-3">
                        <label for="for_contable_month">Mes contable pago</label>
                        <select name="contable_month" class="form-control" required="">
                            <option value=""></option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10" selected="">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </fieldset>
                </div>
                <div class="form-row">
                    <div class="col">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-danger" type="submit">Rechazar</button>
                        <button class="btn btn-success" type="submit">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right text-muted small">id cumplimiento: 23432</div>

    </div>

</div>



@endsection
