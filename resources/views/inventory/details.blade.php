@extends('layouts.app')

@section('title', 'Inventario Detalle')

@section('content')

@include('inventory.nav')

<h3 class="mb-3">
    Detalle del ítem
</h3>

<div class="form-row mb-3">
    <fieldset class="col-md-2">
        <label for="code" class="form-label">
            Código
        </label>
        <input type="text" class="form-control form-control" id="code" value="56101504" disabled readonly>
    </fieldset>

    <fieldset class="col-md-3">
        <label for="product" class="form-label">
            Producto (Articulo)
        </label>
        <input type="text" class="form-control form-control" id="product" value="Sillas" disabled readonly>
    </fieldset>

    <fieldset class="col-md-7">
        <label for="description" class="form-label">
            Descripción (especificación técnica)
        </label>
        <input type="text" class="form-control form-control" id="description" value="Silla de escritorio ergonomica" disabled readonly>
    </fieldset>
</div>

<div class="form-row mb-3">


    <fieldset class="col-md-2">
        <label for="number-inventory" class="form-label">
            Nro. Inventario
        </label>
        <input type="text" class="form-control form-control" id="number-inventory" value="INV-1111111" >
    </fieldset>

    <fieldset class="col-md-1">
        <label for="useful-life" class="form-label">
            Vida útil
        </label>
        <input type="text" class="form-control form-control" id="useful-life" value="1 año" >
    </fieldset>

    <fieldset class="col-md-2">
        <label for="number-inventory" class="form-label">
            Estado
        </label>
        <select class="form-control form-control">
            <option>Bueno</option>
            <option>Regular</option>
            <option>Malo</option>
        </select>
    </fieldset>

    <fieldset class="col-md-3">
        <label for="number-inventory" class="form-label">
            Depreciación
        </label>
        <input type="text" class="form-control form-control" value="Calculo pendiente">
    </fieldset>


</div>

<div class="form-row mb-3">
    <fieldset class="col-md-3">
        <label for="brand" class="form-label">
            Marca
        </label>
        <input type="text" class="form-control form-control" id="brand" value="Acme" >
    </fieldset>

    <fieldset class="col-md-3">
        <label for="model" class="form-label">
            Modelo
        </label>
        <input type="text" class="form-control form-control" id="model" value="47FA" >
    </fieldset>

    <fieldset class="col-md-3">
        <label for="serial-number" class="form-label">
            Número de Serie
        </label>
        <input type="text" class="form-control form-control" id="serial-number" value="1112223344-0">
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-md-2">
        <label for="oc" class="form-label">
            OC
        </label>
        <input type="text" class="form-control form-control" id="oc" value="1057448-165-AG22" disabled readonly>
    </fieldset>

    <fieldset class="col-md-2">
        <label for="date-" class="form-label">
            Fecha Compra OC
        </label>
        <input type="text" class="form-control form-control" id="date-" value="2022-06-02" disabled readonly>
    </fieldset>

    <fieldset class="col-md-2">
        <label for="value" class="form-label">
            Valor OC
        </label>
        <input type="text" class="form-control form-control" id="value" value="$28000" disabled readonly>
    </fieldset>

    <fieldset class="col-md-1">
        <label for="subtitle" class="form-label">
            Subtítulo
        </label>
        <input type="text" class="form-control form-control" id="subtitle" value="22" disabled readonly>
    </fieldset>

    <fieldset class="col-md-3">
        <label for="subtitle" class="form-label">
            Centro Costo
        </label>
        <input type="text" class="form-control form-control" id="subtitle" value="???" disabled readonly>
    </fieldset>

    <fieldset class="col-md-2">
        <label for="date-reception" class="form-label">
            Ingreso bodega
        </label>
        <input type="text" class="form-control form-control" id="date-reception" value="2022-06-30" disabled readonly>
    </fieldset>



</div>

<div class="form-row mb-3">
    <fieldset class="col-md-3">
        <label for="serial-number" class="form-label">
            Financiamiento
        </label>
        <input type="text" class="form-control form-control" id="serial-number" value="Donación o Compra" disabled>
    </fieldset>

    <fieldset class="col-md-3">
        <label for="model" class="form-label">
            Proveedor
        </label>
        <input type="text" class="form-control form-control" id="model" value="Andigraf SA" disabled>
    </fieldset>


    <fieldset class="col-md-4">
        <label for="date-reception" class="form-label">
            Factura (o link)
        </label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFileLang" lang="es">
            <label class="custom-file-label" for="customFileLang" data-browse="Adjuntar">Seleccionar Archivo</label>
        </div>
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-md-12">
        <label for="serial-number" class="form-label">
                Observaciones
        </label>
        <textarea name="" id="" cols="30" rows="4" class="form-control"></textarea>
    </fieldset>
</div>


<h5>Registrar nuevo traslado y solicitud de recepción</h5>

<div class="form-row mb-3">

    <fieldset class="col-md-3">
        <label for="responsability" class="form-label">
            Responsable
        </label>
        <input type="text" class="form-control form-control" id="responsability" >
    </fieldset>

    <fieldset class="col-md-4">
        <label for="destinations" class="form-label">
            Ubicación
        </label>
        <input type="text" class="form-control form-control" id="destinations" >
    </fieldset>

    <fieldset class="col-md-2">
        <label for="reception-confirmation" class="form-label">
            Recepción
        </label>
        <input type="text" class="form-control form-control" id="reception-confirmation" disabled>
    </fieldset>

    <fieldset class="col-md-2">
        <label for="reception-confirmation" class="form-label">
            Instalación (opc)
        </label>
        <input type="text" class="form-control form-control" id="reception-confirmation" >
    </fieldset>

    <div class="col-md-1">
        <label for="reception-confirmation" class="form-label">
            &nbsp;
        </label>
        <button class="btn btn-primary form-control">
            <i class="fas fa-save"></i>
        </button>
    </div>
</div>

<div class="form-row mb-3">

    <fieldset class="col-md-3">
        <label for="responsability" class="form-label">
            Responsable
        </label>
        <input type="text" class="form-control form-control" id="responsability" value="Angelina Jolie" disabled readonly>
    </fieldset>

    <fieldset class="col-md-4">
        <label for="destinations" class="form-label">
            Ubicación
        </label>
        <input type="text" class="form-control form-control" id="destinations" value="Contabilidad, oficina 305" disabled readonly>
    </fieldset>

    <fieldset class="col-md-2">
        <label for="reception-confirmation" class="form-label">
            Recepción
        </label>
        <input type="text" class="form-control form-control" id="reception-confirmation" value="2022-12-19" disabled readonly>
    </fieldset>

    <fieldset class="col-md-2">
        <label for="reception-confirmation" class="form-label">
            Instalación (opc)
        </label>
        <input type="text" class="form-control form-control" id="reception-confirmation" disabled>
    </fieldset>

    <div class="col-md-1">
        <label for="reception-confirmation" class="form-label">
            &nbsp;
        </label>
        <button class="btn btn-success form-control disabled">
            <i class="fas fa-save"></i>
        </button>
    </div>

</div>

<div class="form-row mb-3">

    <fieldset class="col-md-3">
        <label for="responsability" class="form-label">
            Responsable
        </label>
        <input type="text" class="form-control form-control" id="responsability" value="Juan Perez" disabled readonly>
    </fieldset>

    <fieldset class="col-md-4">
        <label for="destinations" class="form-label">
            Ubicación
        </label>
        <input type="text" class="form-control form-control" id="destinations" value="Departamento TIC, oficina 211" disabled readonly>
    </fieldset>

    <fieldset class="col-md-2">
        <label for="reception-confirmation" class="form-label">
            Recepción
        </label>
        <input type="text" class="form-control form-control" id="reception-confirmation" value="2022-06-02" disabled readonly>
    </fieldset>

    <fieldset class="col-md-2">
        <label for="reception-confirmation" class="form-label">
            Instalación (opc)
        </label>
        <input type="text" class="form-control form-control" id="reception-confirmation" value="2022-06-02" disabled>
    </fieldset>

    <div class="col-md-1">
        <label for="reception-confirmation" class="form-label">
            &nbsp;
        </label>
        <button class="btn btn-success form-control disabled">
            <i class="fas fa-save"></i>
        </button>
    </div>
</div>

<h5 class="mt-3">Registrar baja del ítem</h5>

<div class="form-row mb-3">

    <fieldset class="col-md-2">
        <label for="reception-confirmation" class="form-label">
            Fecha de baja
        </label>
        <input type="text" class="form-control form-control" id="reception-confirmation" >
    </fieldset>

    <fieldset class="col-md-2">
        <label for="reception-confirmation" class="form-label">
            Nº de acta
        </label>
        <input type="text" class="form-control form-control" id="reception-confirmation" >
    </fieldset>

    <div class="col-md-1">
        <label for="reception-confirmation" class="form-label">
            &nbsp;
        </label>
        <button class="btn btn-danger form-control">
            <i class="fas fa-save"></i>
        </button>
    </div>
</div>

<h5 class="mt-3">Historial del ítem</h5>

<ul>
    <li>2021-11-05 - <a href="">Formulario de solicitud de compra</a>  </li>
    <li>2021-11-14 - <a href="">Orden de compra</a>  </li>
    <li>2021-11-30 - <a href="">Recepción en bodega</a>  </li>
    <li>2021-12-02 - Ingreso a inventario  </li>
    <li>2021-12-02 - Entrega a responsable <b>Juan Pérez</b> en <b>Oficina 211</b> - <b>Edificio A</b> </li>
    <li>2021-12-03 - Confirmación recepción responsable <b>Juan Pérez</b>  </li>
    <li>2021-12-06 - Instalación (opcional: por ejemplo para impresoras)  </li>
    <li>2022-12-19 - Traslado a <b>Oficina 305</b> - <b>Edificio B</b> - nuevo responsable <b>Angelina Jolie</b> </li>
    <li>2022-12-19 - Confirmación recepción responsable <b>Angelina Jolie</b>  </li>
    <li>2022-07-25 - <a href="">De baja a través de acta <b>123</b></a> </li>
</ul>

@endsection