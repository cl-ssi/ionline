<div>
    <style>
        .bg-image-HAH {
            width: 340px;
            height: 340px;
            background-image: url('{{ asset('images/inventario_HAH_nuevo.png') }}');
            background-size: 340px;
        }

        .bg-image-SST {
            width: 340px;
            height: 340px;
            background-image: url('{{ asset('images/inventario_SST_nuevo.png') }}');
            background-size: 340px;
        }

        .qr {
            padding-top: 111px;
            padding-left: 6px;
        }

        .code {
            padding-top: 8px;
            text-align: center;
            font-size: 19px;
            font-weight: bold;
        }
    </style>

    <div class="bg-image-{{ $inventory->establishment->alias }} mb-3">
        <div class="qr text-center">
            {!! $inventory->qr !!}
        </div>
        <div class="code">
            {{ $inventory->number }}
        </div>
    </div>



    <div class="row mb-3 g-2">
        <div class="col-2 border-bottom">
            <label class="fw-bold" for="code">Código Producto</label>
            <div>
                {{ $inventory->unspscProduct->code }}
            </div>
        </div>
        <div class="col-3 border-bottom">
            <label class="fw-bold" for="product">Producto</label>
            <div>
                {{ $inventory->unspscProduct->name }}
            </div>
        </div>
        <div class="col-7 border-bottom">
            <label class="fw-bold" for="description">Descripción <small>(especificación técnica)</small></label>
            <div>
                {{ $inventory->product ? $inventory->product->name : $inventory->description }}
            </div>
        </div>
    </div>

    <div class="row mb-3 g-2">
        <div class="col-2 border-bottom">
            <label class="fw-bold" for="number">Nro. Inventario</label>
            <div>
                {{ $inventory->number }}
            </div>
        </div>
        <div class="col-3 border-bottom">
            <label class="fw-bold" for="brand">Marca</label>
            <div>
                {{ $inventory->brand }}
            </div>
        </div>
        <div class="col-2 border-bottom">
            <label class="fw-bold" for="model">Modelo</label>
            <div>
                {{ $inventory->model }}
            </div>
        </div>
        <div class="col-3 border-bottom">
            <label class="fw-bold" for="serial_number">Número de serie</label>
            <div>
                {{ $inventory->serial_number }}
            </div>
        </div>
        <div class="col-2 border-bottom">
            <label class="fw-bold" for="status">Estado</label>
            <div>
                {{ $inventory->estado }}
            </div>
        </div>
    </div>

    <div class="row mb-3 g-2">
        <div class="col-2 border-bottom">
            <label class="fw-bold" for="useful_life">Vida útil</label>
            <div>
                {{ $inventory->useful_life }}
            </div>
        </div>
        <div class="col-3 border-bottom">
            <label class="fw-bold" for="depreciation">Depreciación</label>
            <div>
                {{ $inventory->depreciation }}
            </div>
        </div>
        <div class="col-2 border-bottom">
            <label class="fw-bold" for="accounting_code_id">Cuenta contable</label>
            <div>
                {{ $inventory->accounting_code_id }}
            </div>
        </div>
    </div>

    @if ($inventory->control && $inventory->control->requestForm)
        <div class="row mb-3 g-2 ">
            <fieldset class="col-md-3">
                <label class="fw-bold" for="date-reception"
                    class="form-label">
                    Formulario Requerimiento
                </label>
                <div>
                    <a class="btn btn-primary btn-block"
                        href="{{ route('request_forms.show', $inventory->control->requestForm) }}"
                        target="_blank">
                        <i class="fas fa-file-alt"></i> #{{ $inventory->control->requestForm->id }}
                    </a>
                </div>
            </fieldset>
        </div>
    @endif

    @if ($inventory->po_id)
        <div class="row mb-3 g-2">

            <fieldset class="col-md-2 border-bottom">
                <label class="fw-bold" for="oc"
                    class="form-label">
                    OC
                </label>
                <div>
                    {{ $inventory->po_code }}
                </div>
            </fieldset>
            <fieldset class="col-md-3 border-bottom">
                <label class="fw-bold" for="date-oc"
                    class="form-label">
                    Fecha OC
                </label>
                <div>
                    {{ $inventory->po_date }}
                </div>
            </fieldset>
            <fieldset class="col-md-2 border-bottom">
                <label class="fw-bold" for="value-oc"
                    class="form-label">
                    Valor
                </label>

                <div>
                    ${{ money($inventory->po_price) }}
                </div>
            </fieldset>
        </div>
    @endif

    <h5 class="mt-3">Historial del ítem</h5>
    @livewire('inventory.movement-index', ['inventory' => $inventory])
</div>
