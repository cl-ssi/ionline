@extends('layouts.app')

@section('title', 'Maqueta Honorario')

@section('content')


<h3 class="mb-3">Perfil del Funcionario</h3>

<div class="personal-data-table" style="border-radius: 10px; margin: 20px;">
<div class="p-3 mb-3" style="border-radius: 10px; border: 2px solid black; background-color: white;">
      <h4>Datos Personales</h4>
    </div>
  <div class="row" >
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
  <div class="row">
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
  <div class="row">
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
  <div class="row">
    <div class="col-md-2">
      <label for="profesion">Profesión:</label>
    </div>
    <div class="col-md-4">
      <select class="form-control selectpicker" data-live-search="true" name="profession_id" data-size="5" id="profesion">
        <option value="">Todos</option>
        <option value="1">Desarrollador de software</option>
        <option value="2">Diseñador gráfico</option>
        <option value="3">Ingeniero mecánico</option>
        <option value="4">Abogado</option>
        <option value="5">Contador</option>
      </select>
    </div>
    <div class="col-md-2">
      <label for="establecimiento">Establecimiento:</label>
    </div>
    <div class="col-md-4">
      <select class="form-control" data-live-search="true" name="establishment_id" data-size="5" id="establecimiento">
            <option value="">Todos</option>
            <option value="1">Hospital A</option>
            <option value="2">Hospital B</option>
            <option value="3">Clínica C</option>
            <option value="4">Consultorio D</option>
            <option value="5">Centro médico E</option>
          </select>
        </td>
        <td><label for="unidad">Unidad:</label></td>
        <td>
          <select class="form-control" data-live-search="true" name="responsability_center_ou_id" data-size="5" id="unidad">
            <option value="">Todos</option>
            <option value="1">Unidad 1</option>
            <option value="2">Unidad 2</option>
          </select>
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
              <label for="period">Periodo:</label>
              <select class="form-control" id="period">
                <option>Seleccione</option>
                <option>Enero - Febrero</option>
                <option>Marzo - Abril</option>
                <option>Mayo - Junio</option>
                <option>Julio - Agosto</option>
                <option>Septiembre - Octubre</option>
                <option>Noviembre - Diciembre</option>
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

<div class="table-container mb-3" style="border-radius: 10px; border: 2px solid black;">
    <div class="bg-warning text-white p-3 mb-3" style="border-radius: 10px;">
        <h4>Firmas de resolución</h4>
    </div>
    <table class="table table-bordered table-sm w-100" style="border-radius: 10px;">
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
          <td>Creado</td>
          <td></td>
          </tr>
          <tr>
          <td>2022-04-11</td>
          <td>S.A.M.U.</td>
          <td>Funcionario</td>
          <td>Norma Constanza Dueñas Peña</td>
          <td>Responsable</td>
          <td>Aceptado</td>
          <td>por Claudio Fuentes</td>
          </tr>
          <tr>
          <td>2022-04-06</td>
          <td>S.A.M.U.</td>
          <td>Médico Jefe</td>
          <td>Maria Veronica Astudillo Sanchez</td>
          <td>Supervisor</td>
          <td>Aceptado</td>
          <td></td>
          </tr>
          <tr>
          <td>2022-03-02</td>
          <td>Planificación y Gestion RRHH</td>
          <td>Profesional</td>
          <td>Eduardo Javier</td>
          <td>Visador</td>
          <td>Aceptada</td>
          <td></td>
        </tr>
      </tbody>
    </table>
</div>

<div class="table-container mb-3" style="border-radius: 10px; border: 2px solid black;">
  <div class="bg-danger text-white p-3 mb-3" style="border-radius: 10px;">
    <h4>Datos Adicionales - Recursos Humanos</h4>
  </div>
  <div class="form-container">
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
        <h4 class="d-flex w-100">Cumplimientos Solicitudes de Contratación</h4>
    </div>
    <table class="table table-bordered table-sm w-100" style="border-radius: 10px;">
        <thead>
        <tr>
            <th colspan="10"></th>
                <th></th>
            <th colspan="3" class="text-center">Visados</th>
        </tr>
            <tr> 
                <th>Id</th>
                <th>Nro.Res</th>
                <th>Tipo</th>
                <th>T.Contrato</th>
                <th>C.Responsabilidad</th>
                <th>F.Solicitud</th>
                <th>Rut</th>
                <th>Funcionario</th>
                <th>F. Inicio</th>
                <th>F. Término</th>
                <!-- <th scope="col">Estado Solicitud</th> -->
                <th>Acción</th>
                <th>Resp.</th>
                <th>RRHH</th>
                <th>Finanzas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>476</td>
                <td>Tipo</td>
                <td>Horas Extra</td>
                <td>Aprobado</td>
                <td>Cwkjd</td>
                <td>01-01-2023</td>
                <td>12345678-9</td>
                <td>01-01-2023</td>
                <td>01-01-2023</td>
                <td>Action</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td>476</td>
                <td>Tipo</td>
                <td>Horas Extra</td>
                <td>Aprobado</td>
                <td>Cwkjd</td>
                <td>01-01-2023</td>
                <td>12345678-9</td>
                <td>01-01-2023</td>
                <td>01-01-2023</td>
                <td>Action</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>476</td>
                <td>Tipo</td>
                <td>Horas Extra</td>
                <td>Aprobado</td>
                <td>Cwkjd</td>
                <td>01-01-2023</td>
                <td>12345678-9</td>
                <td>01-01-2023</td>
                <td>01-01-2023</td>
                <td>Action</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td>476</td>
                <td>Tipo</td>
                <td>Horas Extra</td>
                <td>Aprobado</td>
                <td>Cwkjd</td>
                <td>01-01-2023</td>
                <td>12345678-9</td>
                <td>01-01-2023</td>
                <td>01-01-2023</td>
                <td>Action</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-container mb-3" style="border-radius: 10px; border: 2px solid black;">
  <div class="bg-danger text-white p-3 mb-3" style="border-radius: 10px;">
    <h4>Datos Adicionales - Recursos Humanos</h4>
  </div>
  <div class="form-container">
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
    <div class="form-container">
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
  <div class="form-container">
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
      <input type="text" id="monto_horas_per" name="monto_horas_per">
    </div>
    <div class="form-field">
      <label for="monto_bruto_valor_hora">Total a pagar</label>
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
