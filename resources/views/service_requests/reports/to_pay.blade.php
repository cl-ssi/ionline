@extends('layouts.app')

@section('title', 'Reporte para pagos')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte para pagos</h3>

<form class="form-inline mb-3" action="">

    <div class="row">
    
        <div class="form-group mx-sm-3 mb-2">
            <label for="forWeek" class="sr-only">Password</label>
            <input type="week" value="{{ $current_week }}" class="form-control" id="forWeek" name="week">
        </div>
        
        <button type="submit" class="btn btn-primary mb-2">Seleccionar</button>

    </div>
</form>

<div class="alert alert-warning" role="alert">
    <pre>foreach de fulfillment en rango de fechas y que tenga boleta y resolucion cargada y no tenga información de pagos</pre>
</div>

<h3 class="mb-3 mt-3">Pendientes de pago</h3>
<table class="table table-sm table-bordered">
    <tr>
        <th>Nombre</th>
        <th>Rut</th>
        <th>Periodo</th>
        <th>Certificado</th>
        <th>Boleta</th>
        <th>Resolución</th>
        <th></th>
    </tr>
    <tr>
        <td>Alvaro Torres</td>
        <td>15287582-7</td>
        <td>Febrero 2021</td>
        <td> 
            <a href="">
            <i class="fas fa-paperclip"></i>
            </a>
        </td>
        <td> 
            <a href="">
            <i class="fas fa-paperclip"></i>
            </a>
        </td>
        <td> 
            <a href="">
            <i class="fas fa-paperclip"></i>
            </a>
        </td>
        <td>
            <a href="">
            <i class="fas fa-edit"></i>
            </a>
        </td>
    </tr>
</table>

<hr>

<h3 class="mb-3 mt-3">Pagados</h3>
<table class="table table-sm table-bordered">
    <tr>
        <th>Nombre</th>
        <th>Rut</th>
        <th>Periodo</th>
        <th>Certificado</th>
        <th>Boleta</th>
        <th>Resolución</th>
        <th>Fecha de pago</th>
        <th></th>
    </tr>
    <tr>
        <td>Alvaro Torres</td>
        <td>15287582-7</td>
        <td>Febrero 2021</td>
        <td> 
            <a href="">
            <i class="fas fa-paperclip"></i>
            </a>
        </td>
        <td> 
            <a href="">
            <i class="fas fa-paperclip"></i>
            </a>
        </td>
        <td> 
            <a href="">
            <i class="fas fa-paperclip"></i>
            </a>
        </td>
        <td>16-03-2021</td>
        <td>
            <a href="">
            <i class="fas fa-edit"></i>
            </a>
        </td>
    </tr>
</table>
@endsection

@section('custom_js')


@endsection
