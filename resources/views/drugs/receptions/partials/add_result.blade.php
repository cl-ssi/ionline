@can('Drugs: add results from ISP')
    <div class="card mt-4 d-print-none">
        <div class="card-body">

            <h5 class="card-title">Agregar resultado a muestra N°: {{ $item->id }} {{ $item->substance->name }} Nue: {{ $item->nue }}</h5>

            <form method="POST" class="form-horizontal" action="{{ route('drugs.receptions.store_result', $item->id) }}">
                @csrf
                @method('PUT')
                <div class="form-row">

                    <fieldset class="form-group col-2">
                        <label for="for_result_number">N° de Documento</label>
                        <input type="number" class="form-control" id="for_result_number"
                        name="result_number" required="required" value="{{ $item->result_number }}">
                    </fieldset>

                    <fieldset class="form-group col-3">
                        <label for="for_result_date">Fecha Documento</label>
                        <input type="date" class="form-control" id="for_result_date"
                        name="result_date" required="required"
                        value="{{ isset($item->result_date) ? $item->result_date->format('Y-m-d') : '' }}" >
                    </fieldset>

                    <fieldset class="form-group col-4">
                        <label for="for_substance">Sustancia</label>
                        <select name="result_substance_id" id="for_substance" class="form-control">
                            @foreach($substancesFound as $substance)
                                <option @if($item->result_substance_id == $substance->id) selected @endif
                                 value="{{ $substance->id }}">{{ $substance->name }}</option>
                            @endforeach
                        </select>
                    </fieldset>

                    <button type="submit" class="btn btn-primary nolabel"><i class="fas fa-save"></i> Guardar</button>

                </div>

            </form>
        </div>
    </div>
@endcan
