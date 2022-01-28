<div class="card mt-3 mb-3 d-print-none">
    <div class="card-body">

        <h5 class="card-title">Crear reservado a ISPs</h5>

        <form method="POST" class="form-horizontal" action="{{ route('drugs.receptions.sample_to_isp.store', $reception ) }}">
            @csrf
            @method('POST')

            <div class="form-row">

                <fieldset class="form-group col-2">
                    <label for="for_number">N° de Documento</label>
                    <input type="number" class="form-control" id="for_number"
                        name="number" value="{{ $reception->sampleToIsp ? $reception->sampleToIsp->number : '' }}">
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_document_date">Fecha Documento</label>
                    <input type="date" class="form-control" id="for_document_date"
                        name="document_date"
                        value="{{ ($reception->sampleToIsp AND $reception->sampleToIsp->document_date) ? $reception->sampleToIsp->document_date->format('Y-m-d') : '' }}">
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_number">Observación</label>
                    <input type="text" class="form-control" id="for_observation"
                        name="observation" value="{{ $reception->sampleToIsp ? $reception->sampleToIsp->observation : '' }}">
                </fieldset>

                <fieldset class="form-group col-2">
                    <label for="for_envelope_weight">Peso sobre</label>
                    <input type="number" step="any" class="form-control" id="for_envelope_weight"
                        name="envelope_weight" required
                        value="{{ $reception->sampleToIsp ? $reception->sampleToIsp->envelope_weight : '' }}">
                </fieldset>

                <div class="col-1">
                    <label for="">&nbsp;</label>
                    <button type="submit" class="btn btn-primary form-control"><i class="fas fa-save"></i> </button>
                </div>

                @if($reception->sampleToIsp AND $reception->sampleToIsp->envelope_weight)
                <div class="col-1">
                    <label for="">&nbsp;</label>
                    <a class="btn btn-outline-secondary form-control" target="_blank"
                        href="{{ route('drugs.receptions.sample_to_isp.show', $reception )}}">
                        <i class="fas fa-file-alt"></i>
                    </a>
                </div>
                @endif
            </div>

        </form>
    </div>
</div>

<!--
<div class="card mt-3 mb-3 d-print-none">
    <div class="card-body">

        <h5 class="card-title">Agregar número de oficio reservado a ISPs</h5>

        <form method="POST" class="form-horizontal" action="{{ route('drugs.receptions.update', $reception ) }}">
            @csrf
            @method('PUT')

            <div class="form-row">

                <fieldset class="form-group col-2">
                    <label for="for_reservado_isp_number">N° de Documento</label>
                    <input type="number" class="form-control" id="for_reservado_isp_number"
                    name="reservado_isp_number" value="{{ $reception->reservado_isp_number }}" required>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_reservado_isp_date">Fecha Documento</label>
                    <input type="date" class="form-control" id="for_reservado_isp_date"
                    name="reservado_isp_date" value="{{ $reception->reservado_isp_date ? $reception->reservado_isp_date->format('Y-m-d') : '' }}" required>
                </fieldset>

                <button type="submit" class="btn btn-primary nolabel"><i class="fas fa-save"></i> Guardar</button>

            </div>

        </form>
    </div>
</div>
-->
