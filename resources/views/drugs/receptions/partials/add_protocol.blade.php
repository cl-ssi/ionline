@can('Drugs: add protocols')
    @if($item->substance->id == 2 OR
        $item->substance->id == 10 OR
        $item->substance->id == 21 OR
        $item->substance->id == 15 OR
        $item->substance->id == 58 OR
        $item->substance->id == 18 )
        <div class="card mt-4 d-print-none">
            <div class="card-body">

                <h5 class="card-title">Agregar protocolo a item id: {{ $item->id }} {{ $item->substance->name }} Nue: {{ $item->nue }}</h5>

                @for ($i = 1; $i <= $item->sample_number; $i++)
                    @php($existe = false)
                    @foreach($item->protocols as $protocol)
                        @if($protocol->sample == $i)
                            @php($existe = $protocol)
                        @endif
                    @endforeach

                    @if($existe)
                        <div class="">
                            Muestra {{ $existe->sample }}: El <strong>{{ $existe->created_at->format('d-m-Y') }}</strong>
                            se creó protocolo número: <strong>{{ $existe->id }}</strong>
                            con resultado <strong>{{ $existe->result }}</strong>
                            <a href="{{ route('drugs.receptions.protocols.show', $existe->id )}}" target="_blank"> <i class="fas fa-file"></i></a>

                        </div>
                    @else
                        <form method="POST" class="form-horizontal" action="{{ route('drugs.receptions.store_protocol', $item) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="sample" value="{{ $i }}">
                            <div class="form-row align-items-center">
                                <!--div class="col-auto">
                                    <label for="for_id">N° Protocolo</label>
                                    <input type="text" class="form-control" id="for_id" name="id" required>
                                </div-->
                                <div class="col-auto">
                                    <label for="for_sample_number" class="sr-only">Numero de muestra</label>
                                    <input type="text" readonly class="form-control-plaintext" id="for_sample_number" value="Muestra {{ $i }}:">
                                </div>
                                <div class="col-auto">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="result" id="positivo{{ $i }}" value="Positivo" checked>
                                        <label class="form-check-label" for="positivo{{ $i }}">Positivo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="result" id="negativo{{ $i }}" value="Negativo">
                                        <label class="form-check-label" for="negativo{{ $i }}">Negativo</label>
                                    </div>
                                </div>
                                <div class="col-auto ml-4">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar</button>
                                </div>
                                <div class="col-auto">

                                </div>
                            </div>
                        </form>
                    @endif
                @endfor
            </div>
        </div>
    @endif
@endcan
