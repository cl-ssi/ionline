<div>
    <h3 class="mb-3">Crear un acta de recepción conforme</h3>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active"
                aria-current="page"
                href="#">Con Orden de Compra</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
                href="#">Cenabast</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
                href="#">Sin Orden de Compra</a>
        </li>
    </ul>

    <div class="row mb-3 g-2">
        <div class="col-md-4">
            <label for="reception-date">Orden de compra</label>
            <div class="input-group">
                <input type="text"
                    class="form-control"
                    placeholder="Orden de compra"
                    aria-label="Orden de compra"
                    aria-describedby="purchase-order"
                    wire:model.debounce="purchaseOrderCode">
                <button class="btn btn-outline-primary"
                    wire:click="getPurchaseOrder">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="reception-date">Fecha Recepción</label>
                <input type="datetime-local"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="number">Número de acta</label>
                <input type="text"
                    class="form-control">
                <div class="form-text">Dejar en blanco para autogenerar</div>
            </div>
        </div>
    </div>


    @if ($purchaseOrder)
        <div class="mb-3">
            <h4>Actas creadas para esta OC:</h4>
            <ul>
                <li>
                    <a href="#">Acta ID: 2123 fecha: 2023-11-01</a>
                </li>
                <li>
                    <a href="#">Acta ID: 2234 fecha: 2023-11-02</a>
                </li>
            </ul>
        </div>

        <h4>Tipo de recepción</h4>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                        type="radio"
                        name="inlineRadioOptions"
                        id="inlineRadio1"
                        value="option1">
                    <label class="form-check-label"
                        for="inlineRadio1">Recepcionar la OC Completa</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                        type="radio"
                        name="inlineRadioOptions"
                        id="inlineRadio2"
                        value="option2">
                    <label class="form-check-label"
                        for="inlineRadio2">Recepcionar la OC Parcial</label>
                </div>
                <div class="form-check form-switch form-check-inline float-end">
                    <input class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="flexSwitchCheckDefault">
                    <label class="form-check-label"
                        for="flexSwitchCheckDefault">Marcar la Orden de Compra como Completada</label>
                    <div class="form-text">No se recibirán más items de esta Orden de Compra</div>
                </div>
            </div>
        </div>



        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Cantidad / Unidad</th>
                    <th>Especificaciones Comprador</th>
                    <th>Especificaciones Proveedor</th>
                    <th>Precio Unitario</th>
                    <th>Descuento</th>
                    <th>Cargos</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrder->json->Listado[0]->Items->Listado as $item)
                    <tr class="table-secondary ">
                        <td class="text-center">
                            {{ $item->CodigoCategoria }}
                            <button class="btn btn-sm btn-primary">
                                <i class="bi bi-plus"></i>
                            </button>
                        </td>
                        <td>{{ $item->Producto }}</td>
                        <td style="text-align: right;">
                            {{ $item->Cantidad }} {{ $item->Unidad }}
                        </td>
                        <td>{{ $item->EspecificacionComprador }}</td>
                        <td>{{ $item->EspecificacionProveedor }}</td>
                        <td style="text-align: right;">{{ money($item->PrecioNeto) }}</td>
                        <td style="text-align: right;">{{ money($item->TotalDescuentos) }}</td>
                        <td style="text-align: right;">{{ money($item->TotalCargos) }}</td>
                        <td style="text-align: right;">{{ money($item->Cantidad * $item->PrecioNeto) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Acta 2123
                        </td>
                        <td>
                            <select name=""
                                id=""
                                class="form-select">
                                @for ($i = 1; $i <= $item->Cantidad; $i++)
                                    <option>{{ $i }}</option>
                                @endfor
                            </select>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="mb-2">Firmantes</h4>
        <div class="row text-center">
            <div class="col">
                @livewire('search-select-user')
                <div class="row mt-1 mb-2 g-2">
                    <div class="col">
                        <button class="btn btn-outline-primary form-control">
                            <i class="bi bi-plus"></i>
                            Agregar firmante
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn btn-outline-success form-control">
                            <i class="bi bi-plus"></i>
                            Agregarme a mi
                        </button>
                    </div>
                </div>

                {{ auth()->user()->shortName }}
                <button class="btn btn-sm btn-danger">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="col">
                @livewire('search-select-user')
                <div class="row mt-1 mb-2 g-2">
                    <div class="col">
                        <button class="btn btn-outline-primary form-control">
                            <i class="bi bi-plus"></i>
                            Agregar firmante
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn btn-outline-success form-control">
                            <i class="bi bi-plus"></i>
                            Agregarme a mi
                        </button>
                    </div>
                </div>


            </div>
            <div class="col">
                @livewire('search-select-user')
                <div class="row mt-1 mb-2 g-2">
                    <div class="col">
                        <button class="btn btn-outline-primary form-control">
                            <i class="bi bi-plus"></i>
                            Agregar firmante
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn btn-outline-success form-control">
                            <i class="bi bi-plus"></i>
                            Agregarme a mi
                        </button>
                    </div>
                </div>


            </div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-10">
                <img src="{{ asset('/images/logo_rgb_' . auth()->user()->organizationalUnit->establishment->alias . '.png') }}"
                    height="109"
                    alt="Logo de la institución">
            </div>
            <div class="col-2 align-self-end fs-5">
                Número: <b>123</b> <br>
                Fecha: <b>12-11-2023</b>
            </div>
        </div>

        <h3 class="text-center">Acta de recepción conforme</h3>

        <table class="table table-sm table-bordered mb-3">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Cantidad / Unidad</th>
                    <th>Especificaciones Comprador</th>
                    <th>Especificaciones Proveedor</th>
                    <th>Precio Unitario</th>
                    <th>Descuento</th>
                    <th>Cargos</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <br>
        <br>
        <br>

        <div class="row text-center mt-3">
            <div class="col">
                <b>{{ auth()->user()->shortName }}</b><br>
                {{ auth()->user()->organizationalUnit->name }}<br>
                {{ auth()->user()->organizationalUnit->establishment->name }}<br>
            </div>
            <div class="col">

            </div>
            <div class="col">

            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 text-end">
                <button class="btn btn-primary">Crear</button>
            </div>
        </div>
    @endif
</div>
