@can('Drugs: edit receptions')
<div class="card mt-4 d-print-none">
    <div class="card-body">

        <h5 class="card-title">Editar Item</h5>

        <form method="POST" class="form-horizontal">
            @csrf
            @method('PUT')

            <div class="form-row">

                <fieldset class="form-group col-2">
                    <label for="for_nue">NUE</label>
                    <input type="text" class="form-control" id="for_nue" name="nue"
                    value="{{ $item->nue }}" required="required">
                </fieldset>

                <fieldset class="form-group col-4">
                    <label for="for_substance">Sustancia</label>
                    <select name="substance_id" id="for_substance" class="form-control">
                        @foreach($substances as $substance)
                        <option @if($item->substance_id == $substance->id) selected @endif
                         value="{{ $substance->id }}">{{ $substance->name }}</option>
                        @endforeach
                    </select>
                </fieldset>

                <fieldset class="form-group col-2">
                    <label for="for_sample_number">N° Muestras</label>
                    <input type="text" class="form-control" id="for_sample_number"
                    value="{{ $item->sample_number }}" name="sample_number" required="">
                </fieldset>

                <fieldset class="form-group col-2">
                    <label for="for_document_weight">Peso Oficio</label>
                    <input type="text" class="form-control" id="for_document_weight"
                    value="{{ $item->document_weight }}" name="document_weight" required="">
                </fieldset>



            </div>

            <div class="form-row">

                <fieldset class="form-group col">
                    <label for="for_gross_weight">Peso Bruto *</label>
                    <input type="text" class="form-control" id="for_gross_weight"
                    value="{{ $item->gross_weight }}" name="gross_weight" required="">
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_net_weight">Peso Neto</label>
                    <input type="text" class="form-control" id="for_net_weight"
                    value="{{ $item->net_weight }}" name="net_weight" >
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_sample">Muestra *</label>
                    <input type="text" class="form-control" id="for_sample"
                    value="{{ $item->sample }}" name="sample" required="">
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_countersample">Contramuestra</label>
                    <input type="text" class="form-control" id="for_countersample"
                    value="{{ $item->countersample }}" name="countersample" required="">
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_equivalent">Equivalente</label>
                    <input type="text" class="form-control" id="for_equivalent"
                    value="{{ $item->equivalent }}" name="equivalent">
                </fieldset>

                <fieldset class="form-group col">
                    <label for="for_estimated_net_weight">Peso Neto Estimado</label>
                    <input type="text" class="form-control" id="for_estimated_net_weight"
                    value="{{ $item->estimated_net_weight }}" name="estimated_net_weight"
                    >
                </fieldset>

            </div>

            <div class="form-row">
                <fieldset class="form-group col">
                    <label for="for_description">Descripción</label>
                    <textarea name="description" class="form-control" id="for_description" rows="3" required="required">{{ $item->description }}</textarea>
                </fieldset>

                <button type="submit" class="btn btn-primary nolabel"
                    formaction="{{ route('drugs.receptions.update_item', $item->id) }}">
                    <i class="fas fa-save"></i> Actualizar
                </button>
            </div>

        </form>
    </div>
</div>
@endcan
