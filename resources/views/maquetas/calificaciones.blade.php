@extends('layouts.bt5.app')

@section('title', 'Maqueta Calificaciones')

@section('content')

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">
            <i class="bi bi-plus-circle"></i>
            Informes de desempeño
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-list"></i>
            Mis informes de desempeño
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-card-checklist"></i>
            Administrador de informes de desempeño
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-gear"></i>
        </a>
    </li>
</ul>

<h3 class="mb-3">Informe de desempeño</h3>

<div class="mb-3">
    <label class="form-label" for="newField">Periodo</label>
    <select class="form-select" id="newField">
        <option value=""></option>
        <option value="Prestaciones medicas" selected>2024</option>
        <option value="Subsidios">2023</option>
    </select>
</div>


<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Unidad</th>
            <th class="table-primary text-center">Oct-Dic</th>
            <th class="table-primary text-center">Ene-Mar</th>
            <th class="text-center">Abr-Jun</th>
            <th class="text-center">Jul-Sep</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Alvaro Torres Fuchslocher</td>
            <td>Depto de tecnologías de la información y...</td>
            <td class="text-center"><a class="btn btn-success btn-sm" href=""><i class="bi bi-file-check"></i></a></td>
            <td class="text-center"><button class="btn btn-success btn-sm"><i class="bi bi-file-check"></i></button></td>
            <td class="text-center"><button class="btn btn-secondary btn-sm disabled"><i class="bi bi-file-check"></i></button></td>
            <td class="text-center"><button class="btn btn-secondary btn-sm disabled"><i class="bi bi-file-check"></i></button></td>
        </tr>
        <tr>
            <td>Oscar M. Zavala Cortés</td>
            <td>Depto de tecnologías de la información y...</td>
            <td class="text-center"><a class="btn btn-success btn-sm" href=""><i class="bi bi-file-check"></i></a></td>
            <td class="text-center"><button class="btn btn-outline-success btn-sm"><i class="bi bi-file-check"></i></button></td>
            <td class="text-center"><button class="btn btn-secondary btn-sm disabled"><i class="bi bi-file-check"></i></button></td>
            <td class="text-center"><button class="btn btn-secondary btn-sm disabled"><i class="bi bi-file-check"></i></button></td>
        </tr>
        <tr>
            <td>Jorge Inca Miranda López</td>
            <td>Depto de tecnologías de la información y...</td>
            <td class="text-center"><a class="btn btn-success btn-sm" href=""><i class="bi bi-file-check"></i></a></td>
            <td class="text-center"><button class="btn btn-outline-success btn-sm"><i class="bi bi-file-check"></i></button></td>
            <td class="text-center"><button class="btn btn-secondary btn-sm disabled"><i class="bi bi-file-check"></i></button></td>
            <td class="text-center"><button class="btn btn-secondary btn-sm disabled"><i class="bi bi-file-check"></i></button></td>
        </tr>


    </tbody>
</table>

<br><br><hr>

<h4 class="mb-3">Informe de desempeño</h4>

<form>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Periodo</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="inputEmail3" value="2024 Ene-Mar" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputPassword3" class="col-sm-3 col-form-label">Nombre Funcionario</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="inputPassword3" value="Alvaro Torres Fuchslocher" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputPassword3" class="col-sm-3 col-form-label">Unidad organizacional</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="inputPassword3" value="Departamento de tecnologías de ....." disabled>
        </div>
    </div>

    <br>

    <h5 for="rend">1. Factor Rendimiento</h5>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Cantidad de trabajo</label>
        <div class="col-sm-9">
            <textarea name="" id="" class="form-control" rows="2"></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Calidad del trabajo</label>
        <div class="col-sm-9">
            <textarea name="" id="" class="form-control" rows="2"></textarea>
        </div>
    </div>

    <h5 for="rend">2. Factor Condiciones Personales</h5>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Conocimiento del trabajo</label>
        <div class="col-sm-9">
            <textarea name="" id="" class="form-control" rows="2"></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Interés por el trabajo</label>
        <div class="col-sm-9">
            <textarea name="" id="" class="form-control" rows="2"></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Capacidad trabajo en grupo</label>
        <div class="col-sm-9">
            <textarea name="" id="" class="form-control" rows="2"></textarea>
        </div>
    </div>

    <h5 for="rend">3. Factor Comportamiento Funcinario</h5>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Asistencia</label>
        <div class="col-sm-9">
            <textarea name="" id="" class="form-control" rows="2"></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Puntualidad</label>
        <div class="col-sm-9">
            <textarea name="" id="" class="form-control" rows="2"></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Cumplimiento normas e instrucciones</label>
        <div class="col-sm-9">
            <textarea name="" id="" class="form-control" rows="2"></textarea>
        </div>
    </div>

    <br><br><br>

    <div class="row mb-3 text-center">
        <div class="col-sm-4">
            Firma  <br>
            Del creador
        </div>
        <div class="col-sm-4">
            Toma de Conocimiento del Funcionario <br>
            
        </div>
        <div class="col-sm-4">
            Fecha Notifiación <br>
        </div>
    </div>

    <div class="d-grid">
        <br>
        <button class="btn btn-success btn-lg" id="submitButton" type="submit">Finalizar</button>
    </div>
</form>


<br><br><hr>

<div class="row">
    <div class="offset-md-3 col-md-5">
        <div class="alert alert-success" role="alert">
            <strong>Notificación por correo al funcionario</strong> <br>
            Estimado funcionario<br>
            Su jefatura ha creado un informe de desempeño para usted.
            Puede revisarlo a través del siguiente link <br>
            <button class="btn btn-primary">Mis informes de desempeño</button>
        </div>
    </div>
</div>



<br><br><br>
<h3 class="mb-3 mt-3">Mis Informes de Desempeño</h3>
<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Periodo</th>
            <th>Jefatura</th>
            <th>Informe</th>
            <th>Toma de conocimiento</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>123</td>
            <td>Oct-Dic</td>
            <td>José Donoso Carrera</td>
            <td class="text-center"><a class="btn btn-success btn-sm" href=""><i class="bi bi-file-check"></i></a></td>
            <td class="text-success">
                2023-12-12 13:23:69<br>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Observación" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-primary" type="button" id="button-addon2">
                        <i class="bi bi-floppy"></i>
                    </button>
                </div>
            </td>
        </tr>
        <tr>
            <td>123</td>
            <td>Ene-Mar</td>
            <td>José Donoso Carrera</td>
            <td class="text-center"><a class="btn btn-success btn-sm" href=""><i class="bi bi-file-check"></i></a></td>
            <td class="text-secondary">
                Pendiente
            </td>
        </tr>

    </tbody>
</table>




<br><br><br>
<h3 class="mb-3 mt-3">Administrador Informes de Desempeño</h3>
<!--table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Beneficio</th>
            <th>Documentos</th>
            <th width="240">Estado</th>
            <th>Transferencia</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>123</td>
            <td>2024-01-12</td>
            <td>Prestamos - Prestamo Habitacional</td>
            <td>
                <ul>
                    <li><a href="#">Boleta de la casa</a></li>
                    <li><a href="#">Bono isapre</a></li>
                </ul>
            </td>
            <td>
                <div class="input-group mb-3">
                    <button class="btn btn-outline-success" type="button" id="inputGroupFileAddon03">Aceptada</button>
                    <button class="btn btn-outline-danger" type="button" id="inputGroupFileAddon03">Rechazada</button>
                </div>
            </td>
            <td>
                <button class="btn btn-success">Registrar transferencia y notificar</button>

            </td>
        </tr>
        <tr>
            <td>123</td>
            <td>2024-01-12</td>
            <td>Prestamos - Prestamo Habitacional</td>
            <td>
                <ul>
                    <li><a href="#">Boleta de la casa</a></li>
                    <li><a href="#">Bono isapre</a></li>
                </ul>
            </td>
            <td>
                <div class="input-group mb-3">
                    <button class="btn btn-success" type="button" id="inputGroupFileAddon03">Aceptada</button>
                    <button class="btn btn-outline-danger" type="button" id="inputGroupFileAddon03">Rechazada</button>
                </div>
            </td>
            <td>
                2023-12-12
            </td>
        </tr>
        <tr>
            <td>124</td>
            <td>2024-01-26</td>
            <td>Prstaciones médicas - Medicamentos</td>
            <td>
                <ul>
                    <li><a href="#">Receta médica original</a></li>
                </ul>
            </td>
            <td>
                <div class="input-group mb-3">
                    <button class="btn btn-outline-success" type="button" id="inputGroupFileAddon03">Aceptada</button>
                    <button class="btn btn-danger" type="button" id="inputGroupFileAddon03">Rechazada</button>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Observación" aria-label="Recipient's username" aria-describedby="button-addon2" value="La receta no pertenece al beneficiario o a las cargas">
                    <button class="btn btn-primary" type="button" id="button-addon2">
                        <i class="bi bi-floppy"></i>
                    </button>
                </div>
            </td>
            <td>

            </td>
        </tr>
    </tbody>
</table-->



<br><br><br>

<pre>
Calificación
=====================
Cada 4 meses, (3 veces por año) Informe de precalificación (en palabras) con fundamento "Funcionario hace su trabajo bla bla bla"
 "Toma conocimiento" + Observaciones (Incoporar Observaciones para descargo.)
Teniendo el informe y la nota de la junta.
Octubre a Diciembre (Primer Informe) (Ver si subimos los PDF o rehacemos las calificaciones)

Pre calificacion 1 / 2 / 3 / Calificación Final (con nota)

Calificación final, firma de todos los integrantes de la comisión

Funcionario firma calificación final, Acepta (Conforme) o Aceptar (No estoy conforme. Aplear a la nota)

Apelación incluye, carta a la directora, directora puede: Subir o mantener la nota (No bajar)
Opciones directora (NO al lugar la apelación o aumentar)

Alejandra puede "modificar" la nota, siempre mantener nota de la junta y añadir la nota de la directora

Informe Notas Final.


</pre>
@endsection