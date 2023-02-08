<!-- Modal -->
<div class="modal fade" id="processClosure-{{$requestForm->id}}" tabindex="-1" aria-labelledby="processClosureLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="processClosureLabel">Seleccione periodo para el nuevo suministro (opcional)</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form-{{$requestForm->id}}" action="{{ route('request_forms.create_provision', $requestForm->id) }}">
                    @csrf
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <label for="for_month">Mes:</label>
                            @php($months = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'])
                            <select name="month" class="form-control form-control-sm">
                                <option value="">Seleccione...</option>
                                @foreach($months as $month)
                                <option value="{{$month}}">{{$month}}</option>
                                @endforeach
                            </select>
                        </fieldset>
                        <fieldset class="form-group col-sm">
                            <label for="for_year">Año:</label>
                            <select name="year" class="form-control form-control-sm">
                                <option value="">Seleccione...</option>
                                @foreach(range($requestForm->created_at->year, now()->year + 1) as $year)
                                <option value="{{$year}}">{{$year}}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>
                    <button type="submit" class="btn btn-primary float-right btn-sm">Crear suministro</button>
                </form>
            </div>
        </div>
    </div>
</div>