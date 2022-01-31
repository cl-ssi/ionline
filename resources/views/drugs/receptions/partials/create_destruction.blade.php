@can('Drugs: destroy drugs')
    <div class="card mt-4 d-print-none">
        <div class="card-body">

            <h5 class="card-title">Crear destrucción</h5>

            <form method="POST" class="form-horizontal" action="{{ route('drugs.destructions.store') }}">
                @csrf
                <input type="hidden" name="reception_id" value="{{ $reception->id }}">
                <div class="form-row">

                    <fieldset class="form-group col">
                        <label for="for_police">Policia</label>
                        <select name="police" id="for_police" class="form-control">
                            <option>Policía de Investigaciones</option>
                            <option>Carabineros de Chile</option>
                            <option>Armada de Chile</option>
                        </select>
                    </fieldset>

                    <fieldset class="form-group col-3">
                        <label for="for_destructed_at">Fecha Destrucción</label>
                        <input type="date" class="form-control" id="for_destructed_at" name="destructed_at" required="">
                    </fieldset>

                    <div class="col-2">
                        <label for="">&nbsp;</label>
                        <button type="submit" class="form-control btn btn-primary"><i class="fas fa-trash"></i> Destruir</button>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col"> <strong>Responsable</strong> <br>{{ $manager }}</div>
                    <div class="col"> <strong>Ministro de fe</strong> <br>{{ $observer }}</div>
                    <div class="col"> <strong>Ministro de fe juridico</strong> <br> {{ $lawyer_observer}}</div>
                </div>

            </form>
            <strong>Destrucciones eliminadas:</strong>
            @foreach($trashedDestructions as $td)
                {{ $td->destructed_at->format('d-m-Y') }} -
            @endforeach
        </div>

    </div>
@endcan
