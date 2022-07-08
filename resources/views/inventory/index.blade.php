@extends('layouts.app')

@section('title', 'Inventario')

@section('content')

@include('inventory.nav')

<div class="form-row my-3">
    <fieldset class="col-sm-3">
        <label for="locations" class="form-label">Ubicaciones</label>
        <input type="text" id="locations" class="form-control" placeholder="Ingresa una ubicacion">
    </fieldset>

    <fieldset class="col-sm-3">
        <label for="places" class="form-label">Lugares</label>
        <input type="text" id="places" class="form-control"  placeholder="Ingresa un lugar">
    </fieldset>

    <fieldset class="col-sm-3">
        <label for="article" class="form-label">Articulo</label>
        <input type="text" id="article" class="form-control"  placeholder="Ingresa un articulo">
    </fieldset>

    <fieldset class="col-sm-3">
        <label for="responsability" class="form-label">Responsable</label>
        <input type="text" id="responsability" class="form-control"  placeholder="Ingresa un responsable">
    </fieldset>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th class="text-center">Nro. Inventario</th>
                <th>Producto</th>
                <th>Ubicacion</th>
                <th>Lugar</th>
                <th>Fecha Entrega</th>
                <th>Responsable</th>
                <th class="text-center">Valor</th>
                <th>Subtitulo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">
                    <small class="text-monospace">
                        INV-0000000
                    </small>
                </td>
                <td>
                    Archivadores de fichas
                    <br>
                    <small>
                        <span class="text-monospace">111222333</span>
                        - ESTANTE ARCHIVADOR 193X60X35 DE 4 REPISAS
                    </small>
                </td>
                <td>
                    SAMU
                </td>
                <td>
                    Oficina 211
                </td>
                <td class="text-center">2022-07-01</td>
                <td>Pedro Perez</td>
                <td class="text-center">$100</td>
                <td></td>
                <td class="text-center">
                    <a class="btn btn-sm btn-primary" href="#">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <small class="text-monospace">
                        INV-1111111
                    </small>
                </td>
                <td>
                    Papel para impresora del ordenador
                    <br>
                    <small>
                        <span class="text-monospace">444555666</span>
                        - RESMA DE PAPEL TAMAÑO OFICIO, 500 HOJAS
                    </small>
                </td>
                <td>
                    SAMU
                </td>
                <td>
                    Oficina 211
                </td>
                <td class="text-center">2022-07-01</td>
                <td>Pedro Perez</td>
                <td class="text-center">$100</td>
                <td></td>
                <td class="text-center">
                    <a class="btn btn-sm btn-primary" href="#">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <small class="text-monospace">
                        INV-2222222
                    </small>
                </td>
                <td>
                    Sillas
                    <br>
                    <small>
                        SILLA PARA ESCRITORIO ERGONOMICA
                    </small>
                </td>
                <td>
                    SAMU
                </td>
                <td>
                    Oficina 211
                </td>
                <td class="text-center">2022-07-01</td>
                <td>Pedro Perez</td>
                <td>$100</td>
                <td></td>
                <td class="text-center">
                    <a class="btn btn-sm btn-primary" href="#">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        </tbody>
        <caption>
            Total de resultados: 3
        </caption>
    </table>


    <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="#"><</a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">></a></li>
        </ul>
    </nav>
</div>

@endsection
