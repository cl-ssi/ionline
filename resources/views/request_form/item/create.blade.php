<div class="card mt-4 d-print-none">
    <div class="card-body">

        <h5 class="card-title">Agregar Item</h5>

        <form method="POST" class="form-horizontal" action="{{ route('request_forms.items.store', $requestForm) }}">
            @csrf

            <div class="form-row">
                <div class="form-group col-8">
                    <label for="foritem">Articulo:</label>
                    <input type="text" class="form-control form-control-sm" id="foritem" placeholder="Escriba..." name="item" required>
                </div>
                <div class="form-group col-4">
                    <div class="form-group col">
                        <label for="forquantity">Cantidad:</label>
                        <input type="number" class="form-control form-control-sm" id="forquantity" placeholder="Ej: 10" name="quantity" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12">
                  <label for="forspecification">Especificaciones Técnicas</label>
                  <textarea class="form-control form-control-sm" id="forspecification" name="specification" rows="2" required></textarea>
                </div>
            </div>

            <button class="btn btn-primary btn-sm float-right mr-3" type="submit">
                <i class="fas fa-save"></i> Enviar
            </button>

        </form>
    </div>
</div>
