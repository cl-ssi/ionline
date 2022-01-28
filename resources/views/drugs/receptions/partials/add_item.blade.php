@can('Drugs: edit receptions')
<div class="card mt-4 d-print-none">
    <div class="card-body">

        <h5 class="card-title">Agregar Item</h5>

        <form method="POST" class="form-horizontal" action="{{ route('drugs.receptions.storeitem',$reception->id) }}">
            @csrf
            <div class="form-row">

                <fieldset class="form-group col-2">
                    <label for="for_nue">NUE</label>
                    <input type="text" class="form-control" id="for_nue" placeholder="N°" name="nue">
                </fieldset>

                <fieldset class="form-group col-4">
                    <label for="for_substance">Sustancia</label>
                    <select name="substance_id" id="for_substance" class="form-control">
                        @foreach($substances as $substance)
                        <option value="{{ $substance->id }}">{{ $substance->name }}</option>
                        @endforeach
                    </select>
                </fieldset>

                <fieldset class="form-group col-2">
                    <label for="for_sample_number">N° Muestras *</label>
                    <input type="text" class="form-control" id="for_sample_number" placeholder="Número de Muestras" name="sample_number" required="">
                </fieldset>

                <fieldset class="form-group col-2">
                    <label for="for_document_weight">Peso Oficio</label>
                    <input type="text" class="form-control" id="for_document_weight" placeholder="Peso Oficio" name="document_weight">
                </fieldset>


            </div>

            <div class="form-row">
                <fieldset class="form-group col">
                    <label for="for_gross_weight">Peso Bruto *</label>
                    <input type="text" class="form-control" id="for_gross_weight" placeholder="Peso Bruto" name="gross_weight" required="">
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_net_weight">Peso Neto</label>
                    <input type="text" class="form-control" id="for_net_weight" placeholder="Peso Neto" name="net_weight" required>
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_sample">Muestra *</label>
                    <input type="text" class="form-control" id="for_sample" placeholder="Peso Muestra" name="sample" required="">
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_countersample">Contramuestra *</label>
                    <input type="text" class="form-control" id="for_countersample" placeholder="Peso Contramuestra" name="countersample" required="">
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_equivalent">Equivalente</label>
                    <input type="text" class="form-control" id="for_equivalent" placeholder="(opcional)" name="equivalent">
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_estimated_net_weight">Peso Neto Estimado</label>
                    <input type="text" class="form-control" id="for_estimated_net_weight" placeholder="Neto Estimado" name="estimated_net_weight" required>
                </fieldset>

            </div>

            <div class="form-row">
                <fieldset class="form-group col">
                    <label for="for_description">Descripción</label>
                    <textarea name="description" class="form-control" id="for_description" rows="3" required="required"></textarea>
                </fieldset>
                
                <div class="col-2">
                    <label for="">&nbsp;</label>
                    <button type="submit" class="btn btn-primary form-control"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </div>

        </form>
    </div>
</div>


@endcan
