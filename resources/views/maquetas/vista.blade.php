@extends('layouts.app')

@section('title', 'Maqueta Honorario')

@section('content')

<h3 class="mb-3">Perfil del Funcionario</h3>

<div class="personal-data-table" style="border-radius: 10px; margin: 20px;">
  <div class="p-3 mb-3" style="border-radius: 10px; border: 2px solid black; background-color: white;padding: 20px; box-sizing: border-box;">
        <h4>Datos Personales</h4>
  </div>
    <div class="row" style="padding: 20px; box-sizing: border-box;" >
      <div class="col-md-2">
        <label for="nombre">Nombre:</label>
      </div>
      <div class="col-md-4">
        <input type="text" id="nombre" name="nombre" value="Alvaro">
      </div>
      <div class="col-md-2">
        <label for="apellidos">Apellidos:</label>
      </div>
      <div class="col-md-4">
        <input type="text" id="apellidos" name="apellidos" value="Scarameli">
      </div>
    </div>
    <div class="row" style="padding: 20px; box-sizing: border-box;">
      <div class="col-md-2">
        <label for="rut">Rut:</label>
      </div>
      <div class="col-md-4">
        <input type="text" id="rut" name="rut" value="1243124">
      </div>
      <div class="col-md-2">
        <label for="direccion">Dirección:</label>
      </div>
      <div class="col-md-4">
        <input type="text" id="direccion" name="direccion" value="Calle Siempre viva 123">
      </div>
    </div>
    <div class="row" style="padding: 20px; box-sizing: border-box;">
      <div class="col-md-2">
        <label for="nro-telefonico">Nro. Telefonico:</label>
      </div>
      <div class="col-md-4">
        <input type="text" id="nro-telefonico" name="nro-telefonico" value="+56969696969">
      </div>
      <div class="col-md-2">
        <label for="correo-electronico">Correo Electronico:</label>
      </div>
      <div class="col-md-4">
        <input type="email" id="correo-electronico" name="correo-electronico" value="emailu@gmail.com">
      </div>
    </div>
  </div>

<div class="table-container mb-3" style="border-radius: 10px; border: 2px solid black;">
  <div class="bg-primary text-white p-3 mb-3 rounded-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Solicitud de Honorario</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active year-option">
            <a class="nav-link" href="#">Año Vigente</a>
          </li>
          <li class="nav-item year-option">
            <a class="nav-link" href="#">2022</a>
          </li>
          <li class="nav-item year-option">
            <a class="nav-link" href="#">2021</a>
          </li>
          <li class="nav-item active contract-option">
            <a class="nav-link" href="#">Contrato Vigente</a>
          </li>
          <li class="nav-item contract-option">
            <a class="nav-link" href="#">Diurno</a>
          </li>
          <li class="nav-item contract-option">
            <a class="nav-link" href="#">Horas Extra</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form>
          <div class="form-row align-items-center">
            <div class="form-group col-md-3">
              <label for="contract-type">Tipo de Contrato:</label>
              <select class="form-control" id="contract-type">
                <option>Seleccione</option>
                <option>Diurno</option>
                <option>Horas Extra</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="start-date">Fecha Inicio:</label>
              <input type="date" class="form-control" id="start-date">
            </div>
            <div class="form-group col-md-3">
              <label for="end-date">Fecha Termino:</label>
              <input type="date" class="form-control" id="end-date">
            </div>
            <div class="form-group col-md-3">
              <label for="current-compliance">Cumplimiento Vigente:</label>
              <select class="form-control" id="current-compliance">
                <option>Aprobado</option>
                <option>No Aprobado</option>
              </select>
            </div>
            </div>  
          </div>
      </div>
    </div>
</div>

<div class="table-container mb-3" style="border-radius: 10px; border: 2px solid black;">
    <div class="bg-warning text-white p-3 mb-3" style="border-radius: 10px;">
        <h4>Firmas de resolución</h4>
    </div>
    <table class="table table-bordered table-sm w-100" style="padding: 20px; box-sizing: border-box;">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>U.Organizacional</th>
                <th>Cargo</th>
                <th>Usuario</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Observación</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2022-02-05</td>
                <td>S.A.M.U.</td>
                <td>Funcionario</td>
                <td>Norma Constanza Dueñas Peña</td>
                <td>Creador</td>
                <td>
                    <select name="estado1">
                        <option value="--">--</option>
                        <option value="Aceptado">Aceptado</option>
                        <option value="Rechazado">Rechazado</option>
                    </select>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>2022-04-11</td>
                <td>S.A.M.U.</td>
                <td>Funcionario</td>
                <td>Norma Constanza Dueñas Peña</td>
                <td>Responsable</td>
                <td>
                    <select name="estado2">
                        <option value="--">--</option>
                        <option value="Aceptado">Aceptado</option>
                        <option value="Rechazado">Rechazado</option>
                    </select>
                </td>
                <td>por Claudio Fuentes</td>
            </tr>
            <tr>
                <td>2022-04-06</td>
                <td>S.A.M.U.</td>
                <td>Médico Jefe</td>
                <td>Maria Veronica Astudillo Sanchez</td>
                <td>Supervisor</td>
                <td>
                    <select name="estado3">
                        <option value="--">--</option>
                        <option value="Aceptado">Aceptado</option>
                        <option value="Rechazado">Rechazado</option>
                    </select>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>2022-03-02</td>
                <td>Planificación y Gestion RRHH</td>
                <td>Profesional</td>
                <td>Eduardo Javier</td>
                <td>Visador</td>
                <td>
                    <select name="estado4">
                        <option value="--">--</option>
                        <option value="Aceptado">Aceptado</option>
                        <option value="Rechazado">Rechazado</option>
                    </select>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-container mb-3" style="border-radius: 10px; border: 2px solid black;">
  <div class="bg-danger text-white p-3 mb-3" style="border-radius: 10px;">
    <h4>Datos Adicionales - Recursos Humanos</h4>
  </div>
  <div class="form-container" style="padding: 20px; box-sizing: border-box;">
    <div class="form-field">
      <label for="numero_contrato">Numero de contrato</label>
      <input type="text" id="numero_contrato" name="numero_contrato">
    </div>
    <div class="form-field">
      <label for="numero_resolucion">Numero de resolución</label>
      <input type="text" id="numero_resolucion" name="numero_resolucion">
    </div>
    <div class="form-field">
      <label for="fecha_resolucion">Fecha resolución</label>
      <input type="date" id="fecha_resolucion" name="fecha_resolucion">
    </div>
    <div class="form-field">
      <label for="monto_mensualizado">Monto Mensuelizado</label>
      <input type="text" id="monto_mensualizado" name="monto_mensualizado">
    </div>
    <div class="form-field">
      <label for="monto_bruto_valor_hora">Monto Bruto Valor/Hora</label>
      <input type="text" id="monto_bruto_valor_hora" name="monto_bruto_valor_hora">
    </div>
    <div class="form-field">
      <label for="registrado_sirh">Registrado en SIRH</label>
      <select id="registrado_sirh" name="registrado_sirh">
        <option value="si">Si</option>
        <option value="no">No</option>
      </select>
    </div>
    <div class="form-field">
      <label for="cargar_resolucion">Cargar la Resolución, impresa, firmada y escaneada</label>
      <input type="file" id="cargar_resolucion" name="cargar_resolucion">
    </div>
    <div class="form-field">
      <button type="button" class="btn btn-primary">Guardar</button>
    </div>
  </div>
</div>

<style>
  .form-container {
    display: flex;
    flex-wrap: wrap;
  }

  .form-field {
    margin-right: 10px; /* Espacio entre los campos */
    margin-bottom: 10px; /* Espacio hacia abajo */
    flex: 1 1 300px; /* Tamaño mínimo y máximo de cada campo */
  }

  label {
    display: block;
    margin-bottom: 5px;
  }
</style>


<div class="table-container mb-3" style="border-radius: 10px; border: 2px solid black;">
    <div class="bg-success text-white p-3 mb-3" style="border-radius: 10px;">
        <h4 class="d-flex w-100">Responsable Cumplimientos Solicitudes de Contratación</h4>
    </div>
    <div class="bg-white p-3" style="border-radius: 10px;">
        <div class="bg-white text-black p-3 mb-3" style="border-radius: 10px;">
            <h4 class="d-flex w-100">Control de Turnos</h4>
            <hr style="border-top: 2px solid green; margin: 20px 0;">
            <div style="display: flex;">
            <div class="form-field">
                <label for="fecha_resolucion">Entrada</label>
                <input type="date" id="fecha_entrada" name="fecha_entrada">
            </div>
            <div class="form-field" style="margin-left: 10px;">
                <label for="hora_entrada">Hora</label>
                <input type="time" id="hora_entrada" name="hora_entrada">
            </div>
            <div class="form-field" style="margin-left: 10px;">
                <label for="fecha_resolucion">Salida</label>
                <input type="date" id="fecha_salida" name="fecha_salida">
            </div>
            <div class="form-field" style="margin-left: 10px;">
                <label for="hora_salida">Hora</label>
                <input type="time" id="hora_salida" name="hora_salida">
            </div>
            <div class="form-field" style="margin-left: 10px;">
                <label for="observaciones">Observaciones</label>
                <textarea id="observaciones" name="observaciones"></textarea>
            </div>
            <div class="form-field" style="margin-left: 10px;">
                <button type="button" class="btn btn-primary">Ingresar</button>
            </div>
        </div>
        <hr style="border-top: 2px solid green; margin: 20px 0;">
    <table class="table table-striped" style="border: none;">
        <thead>
            <tr>
                <th>Entradas</th>
                <th>Salidas</th>
                <th>Horas</th>
                <th>Observación</th>
            </tr>
        </thead>
        <tbody>
        <tr style="border-top: none;">
                    <td>2023-04-27 08:00</td>
                    <td>2023-04-27 17:00</td>
                    <td>9</td>
                    <td>Trabajó en el proyecto XYZ</td>
                </tr>
        </tbody>
    </table>
      <hr style="border-top: 2px solid green; margin: 20px 0;">
      <table class="table table-striped" style="border: none;">
        <thead>
            <tr>
                <th>Horas Diurno</th>
                <th>Horas Nocturno</th>
                <th>Horas Total</th>
                <th>Horas a Pagar</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
        <tr style="border-top: none;">
                    <td>12</td>
                    <td>0</td>
                    <td>12</td>
                    <td>12</td>
                    <td>$300.000 (se debe comprobar)</td>
                </tr>
        </tbody>
    </table>
        <div class="form-field" style="margin-left: 10px;">
        <div class="form-field" style="display: flex;">
        <button type="button" class="btn btn-primary">Ver Certificado</button>
        <button type="button" class="btn btn-primary" style="margin-left: 10px;">Certificado Firmado</button>
        <button type="button" class="btn btn-danger" style="margin-left: 10px;">Eliminar</button>
        </div>
        <hr style="border-top: 2px solid green; margin: 20px 0;">
        <div class="form-field" style="margin-top: 20px;">
          <div style="display: flex;">
            <div style="flex: 1;">
              <label for="adjuntar-archivos">Adjuntar archivos al cumplimiento (opcional)</label>
            </div>
            <div style="display: flex; align-items: center;">
              <button type="button" class="btn btn-secondary" style="margin-right: 10px;">Agregar +</button>
              <button type="button" class="btn btn-primary">Subir</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="table-container mb-3" style="border-radius: 10px; border: 2px solid black;">
  <div class="bg-danger text-white p-3 mb-3" style="border-radius: 10px;">
    <h4>Datos Adicionales - Recursos Humanos</h4>
  </div>
  <div class="form-container" style="padding: 20px; box-sizing: border-box;">
    <div class="form-field">
      <label for="numero_resolucion">Numero de resolución</label>
      <input type="text" id="numero_resolucion" name="numero_resolucion">
    </div>
    <div class="form-field">
      <label for="fecha_resolucion">Fecha resolución</label>
      <input type="date" id="fecha_resolucion" name="fecha_resolucion">
    </div>
    <div class="form-field">
      <label for="monto_mensualizado">Total Horas a pagar per.</label>
      <input type="text" id="monto_mensualizado" name="monto_mensualizado">
    </div>
    <div class="form-field">
      <label for="monto_bruto_valor_hora">Total a pagar</label>
      <input type="text" id="monto_bruto_valor_hora" name="monto_bruto_valor_hora">
    </div>
    <div class="form-field">
      <label for="cargar_resolucion">Cargar la Resolución, impresa, firmada y escaneada</label>
      <input type="file" id="cargar_resolucion" name="cargar_resolucion">
    </div>
    <div class="form-field">
      <button type="button" class="btn btn-primary">Guardar</button>
    </div>
  </div>
</div>

<style>
  .form-container {
    display: flex;
    flex-wrap: wrap;
  }

  .form-field {
    margin-right: 10px; /* Espacio entre los campos */
    margin-bottom: 10px; /* Espacio hacia abajo */
    flex: 1 1 300px; /* Tamaño mínimo y máximo de cada campo */
  }

  label {
    display: block;
    margin-bottom: 5px;
  }
</style>

<div class="table-container mb-3" style="border-radius: 10px; border: 2px solid black;">
    <div class="bg-warning text-white p-3 mb-3" style="border-radius: 10px;">
        <h4>Boleta</h4>
    </div>
    <div class="form-container" style="padding: 20px; box-sizing: border-box;">
    <div class="form-field">
      <label for="numero_resolucion">N° Boleta</label>
      <input type="text" id="id_boleta" name="n_boleta">
    </div>
    <div class="form-field">
      <label for="cargar_resolucion">Cargar Boleta</label>
      <input type="file" id="cargar_boleta" name="cargar_boleta">
    </div>
    <div class="form-field">
      <button type="button" class="btn btn-primary">Guardar</button>
    </div>
    <div class="form-field">
      <button type="button" class="btn btn-danger">Eliminar</button>
    </div>
  </div>
</div>

<div class="table-container mb-3" style="border-radius: 10px; border: 2px solid black;">
  <div class="p-3 mb-3" style="border-radius: 10px; background-color: cyan">
    <h4>Datos Adicionales - Finanzas</h4>
  </div>
  <div class="form-container" style="padding: 20px; box-sizing: border-box;">
    <div class="form-field">
      <label for="numero_resolucion">Numero de resolución</label>
      <input type="text" id="numero_resolucion" name="numero_resolucion" readonly>
    </div>
    <div class="form-field">
      <label for="fecha_resolucion">Fecha resolución</label>
      <input type="date" id="fecha_resolucion" name="fecha_resolucion" readonly>
    </div>
    <div class="form-field">
      <label for="monto_mensualizado">Total Horas a pagar per.</label>
      <input type="text" id="monto_horas_per" name="monto_horas_per"readonly> 
    </div>
    <div class="form-field">
      <label for="monto_bruto_valor_hora">Total a pagar</label readonly>
      <input type="text" id="total_pagado" name="Total_pagar">
    </div>
    <div class="form-field">
      <label for="numero_resolucion">N° Boleta</label>
      <input type="text" id="id_boleta" name="n_boleta">
    </div>
    <div class="form-field">
      <label for="monto_mensualizado">Total Horas pagadas per.</label>
      <input type="text" id="horas_pagadas" name="horas_pagadas">
    </div>
    <div class="form-field">
      <label for="monto_bruto_valor_hora">Total pagado</label>
      <input type="text" id="monto_total_pagado" name="monto_total_pagado">
    </div>
    <div class="form-field">
      <label for="fecha_resolucion">Fecha del pago</label>
      <input type="date" id="fecha_pago" name="fecha_pago">
    </div>
    <div class="form-group col-md-3">
              <label for="period">Mes Contable:</label>
              <select class="form-control" id="month_period">
                <option>Seleccione</option>
                <option>Enero - Febrero</option>
                <option>Marzo - Abril</option>
                <option>Mayo - Junio</option>
                <option>Julio - Agosto</option>
                <option>Septiembre - Octubre</option>
                <option>Noviembre - Diciembre</option>
                <option>Diciembre - Enero</option>
              </select>
            </div>
    <div class="form-field">
      <button type="button" class="btn btn-primary">Guardar</button>
    </div>
  </div>
</div>

@endsection
