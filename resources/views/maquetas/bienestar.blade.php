@extends('layouts.bt5.app')

@section('title', 'Maqueta Bienestar')

@section('content')

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">
            <i class="bi bi-plus-circle"></i>
            Nueva solicitud
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-list"></i>
            Mis solicitudes
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-card-checklist"></i>
            Administrador de solicitudes
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-gear"></i>
            Mantenedor de beneficios
        </a>
    </li>
</ul>

<h3 class="mb-3">Bienestar - Nueva solicitud de beneficios</h3>

<form id="contactForm">
    <div class="mb-3">
        <label class="form-label" for="newField">Beneficio</label>
        <select class="form-select" id="newField">
            <option value=""></option>
            <option value="Prestaciones medicas">Prestaciones medicas</option>
            <option value="Subsidios" selected>Subsidios</option>
            <option value="Prestamos">Prestamos</option>
            <option value="Cabañas">Cabañas</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label" for="newField1">Nombre del subsidio</label>
        <select class="form-select" id="newField1">
            <option value=""></option>
            <option value="Matrimonio">Matrimonio</option>
            <option value="Nacimiento">Nacimiento</option>
            <option value="Fallecimiento">Fallecimiento</option>
            <option value="Indendio y/o catastrofe">Indendio y/o catastrofe</option>
            <option value="Educacion - Prekinder">Educacion - Prekinder</option>
            <option value="Educacion - Kinder">Educacion - Kinder</option>
            <option value="Educación - Básica">Educación - Básica</option>
            <option value="Educación - Básica">....</option>
            <option value="Becas">Becas</option>
            <option value="Bono navidad">Bono navidad</option>
        </select>
    </div>

    <h4 class="mb-3">Atención odontológica - Condiciones</h4>

    <table class="table table-bordered table-sm">
        <tr>
            <th>Descripción</th>
            <th>Tope anual</th>
            <th>Documentos de respaldo</th>
        </tr>
        <tr>
            <td>
                <ul>
                    <li>100%</li>
                    <li>$ 100.000 por imponente</li>
                    <li>$ 80.000 por las cargas en total</li>
                    <li>5 veces máximo por año</li>
                </ul>
            </td>
            <td class="text-end">
                $ 180.000  <br>
                <span class="text-secondary">Utilizado: $ 110.000</span><br>
                <span class="text-success ">Disponible: $ 70.000</span>
            </td>
            <td>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Copia Bono entregado (Solicitar en fonasa o isapre)</label>
                    <input class="form-control" type="file" id="formFile">

                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Boleta o factura indicando el detalle de la atención</label>
                    <input class="form-control" type="file" id="formFile">
                    <div id="passwordHelpBlock" class="form-text">
                        Nota: Adjuntar programa
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <h5>
        Confirme sus datos bancarios (estos datos están en user_bank_accounts)
    </h5>
    <div class="row g-2 mb-3">
        <div class="col-md-3">
            <label for="exampleInputEmail1" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="col-md-3">
            <label for="banco" class="form-label">Banco</label>
            <select class="form-select" aria-label="Default select example">
                <option selected>Seleccionar</option>
                <option value="1">Banco de Chile</option>
                <option value="2">Banco Estado</option>
                <option value="3">Banco Santander</option>
            </select>
        </div>
        <!-- tipos de cuenta-->
        <div class="col-md-3">
            <label for="banco" class="form-label">Tipo de cuenta</label>
            <select class="form-select" aria-label="Default select example">
                <option selected>Seleccionar</option>
                <option value="1">Cuenta Corriente</option>
                <option value="2">Cuenta Vista</option>
                <option value="3">Cuenta de Ahorro</option>
            </select>
        </div>
        <!-- numero de cuenta-->
        <div class="col-md-3">
            <label for="exampleInputEmail1" class="form-label">
                Número de cuenta
            </label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
    </div>

    <div class="d-grid">
        <button class="btn btn-success btn-lg" id="submitButton" type="submit">Finalizar</button>
    </div>
</form>


<br><br><hr>

<div class="row">
    <div class="offset-md-3 col-md-5">
        <div class="alert alert-success" role="alert">
            <strong>Notificación por correo al funcionario</strong> <br>
            Estimado funcionario hemos recibido su solicitud de beneficio "Bla bla bla", en este momento se encuentra "En revisión"<br>
            Puede revisar el estado de su solicitud en <button class="btn btn-primary">Mis solicitudes</button>
        </div>
    </div>
</div>



<br><br><br>
<h3 class="mb-3 mt-3">Mis Solicitudes</h3>
<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Beneficio</th>
            <th>Documentos</th>
            <th width="250">Estado</th>
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
            <td class="text-secondary">En revisión</td>
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
            <td class="text-success">Aceptado</td>
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
            <td class="text-danger">
                Rechazado
                <div id="passwordHelpBlock" class="form-text">
                    Nota: La receta no pertenece al beneficiario o a las cargas
                </div>
            </td>
        </tr>
    </tbody>
</table>




<br><br><br>
<h3 class="mb-3 mt-3">Administrador de Solicitudes</h3>
<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Beneficio</th>
            <th>Documentos</th>
            <th width="240">Estado</th>
            <th>Monto aprobado</th>
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
            <td class="text-end">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="80.000">
                    <button class="btn btn-primary" type="button" id="button-addon2">
                        <i class="bi bi-floppy"></i>
                    </button>
                </div>
                <span class="text-secondary">Utilizado: $ 110.000</span><br>
                <span class="text-success ">Disponible: $ 70.000</span>
            </td>

            <td>
                <button class="btn btn-outline-primary">Registrar transferencia</button>
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
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="1400000">
                    <button class="btn btn-primary" type="button" id="button-addon2">
                        <i class="bi bi-floppy"></i>
                    </button>
                </div>
                <label for="cuotas">Cuotas</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="3">
                    <button class="btn btn-primary" type="button" id="button-addon2">
                        <i class="bi bi-floppy"></i>
                    </button>
                </div>

            </td>
            <td>
                <input type="text" class="form-control" value="500000" disabled><button class="btn btn-success" disabled>Transfe. el 2023-12-12</button>
                <input type="text" class="form-control" value="500000" ><button class="btn btn-outline-primary">Registrar transferencia</button>
                <input type="text" class="form-control" value="400000" ><button class="btn btn-outline-primary">Registrar transferencia</button>
                
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
                <div class="input-group mb-3">
                    <input type="text" class="form-control">
                    <button class="btn btn-primary" type="button" id="button-addon2">
                        <i class="bi bi-floppy"></i>
                    </button>
                </div>
            </td>
            <td>

            </td>
        </tr>
    </tbody>
</table>



<br><br><br>

<pre>
Bienestar (SS aconcagua dice que está trabajando en la integracion sirh)
======================================
Ingreso de Solicitudes: 
(estudiar beneficios para armar la tabla con los campos que permitan cumplir con las reglas de negocio)
- Listado de Prestaciones 
    - Prestamo
    - Vivienda
    - Beneficio por enfermedades catastróficas (ej: tope de 30 funcionarios anual)
    - Fallecimiento
    - Lentes. (Existe las reglas de negocio, Ej: 1 solicitud de lentes por año)
(Esconder las opciones que la persona ya ocupó o bien el tope de funcionarios ya se completó)

- Respuesta automatica de recepción de la solicitud
- Solicitud incompleta, se rechaza y se hace una nueva.
- Luego viene el proceso interno
- Finalmente la transferencia al funcionario a la cuenta bancaria (Notificación, de transferencia realizada)

</pre>
@endsection