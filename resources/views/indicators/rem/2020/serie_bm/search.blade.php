<!--    Exportar a Excel     -->
<script type="text/javascript">
var tableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8"></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
    }
})()
</script>

<div class="form-group">
    <form method="POST" action="{{ route('indicators.rems.year.serie.nserie.index', [$year, $serie, $nserie]) }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-2">
                <label>* Establecimiento: </label>
            </div>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="establecimiento[]" data-live-search="true" multiple="" data-size="10" title="Seleccione..." multiple data-actions-box="true" id="establecimiento">
                    <?php
                    $query = 'SELECT id_establecimiento, alias_estab
                              FROM 2019establecimientos
                              WHERE comuna_id_comuna=1';
                    $registros = DB::connection('mysql_rem')->select($query);
                    ?>
                    <optgroup label="Alto Hospicio">
                      @foreach($registros as $registro)
                        <option value="{{ $registro->id_establecimiento }}" @if (in_array($registro->id_establecimiento, $establecimientos) && $establecimientos != null) selected="selected" @endif>{{ $registro->alias_estab }}</option>
                      @endforeach
                    </optgroup>

                    <?php
                    $query = 'SELECT id_establecimiento, alias_estab
                              FROM 2019establecimientos
                              WHERE comuna_id_comuna=2';
                    $registros = DB::connection('mysql_rem')->select($query);
                    ?>
                    <optgroup label="Camiña">
                      @foreach($registros as $registro)
                        <option value="{{ $registro->id_establecimiento }}" @if (in_array($registro->id_establecimiento, $establecimientos) && $establecimientos != null) selected="selected" @endif>{{ $registro->alias_estab }}</option>
                      @endforeach
                    </optgroup>

                    <?php
                    $query = 'SELECT id_establecimiento, alias_estab
                              FROM 2019establecimientos
                              WHERE comuna_id_comuna=3';
                    $registros = DB::connection('mysql_rem')->select($query);
                    ?>
                    <optgroup label="Colchane">
                      @foreach($registros as $registro)
                        <option value="{{ $registro->id_establecimiento }}" @if (in_array($registro->id_establecimiento, $establecimientos) && $establecimientos != null) selected="selected" @endif>{{ $registro->alias_estab }}</option>
                      @endforeach
                    </optgroup>

                    <?php
                    $query = 'SELECT id_establecimiento, alias_estab
                              FROM 2019establecimientos
                              WHERE comuna_id_comuna=4';
                    $registros = DB::connection('mysql_rem')->select($query);
                    ?>
                    <optgroup label="Huara">
                      @foreach($registros as $registro)
                        <option value="{{ $registro->id_establecimiento }}" @if (in_array($registro->id_establecimiento, $establecimientos) && $establecimientos != null) selected="selected" @endif>{{ $registro->alias_estab }}</option>
                      @endforeach
                    </optgroup>

                    <?php
                    $query = 'SELECT id_establecimiento, alias_estab
                              FROM 2019establecimientos
                              WHERE comuna_id_comuna=5';
                    $registros = DB::connection('mysql_rem')->select($query);
                    ?>
                    <optgroup label="Iquique">
                      @foreach($registros as $registro)
                        <option value="{{ $registro->id_establecimiento }}" @if (in_array($registro->id_establecimiento, $establecimientos) && $establecimientos != null) selected="selected" @endif>{{ $registro->alias_estab }}</option>
                      @endforeach
                    </optgroup>

                    <?php
                    $query = 'SELECT id_establecimiento, alias_estab
                              FROM 2019establecimientos
                              WHERE comuna_id_comuna=6';
                    $registros = DB::connection('mysql_rem')->select($query);
                    ?>
                    <optgroup label="Pica">
                      @foreach($registros as $registro)
                        <option value="{{ $registro->id_establecimiento }}" @if (in_array($registro->id_establecimiento, $establecimientos) && $establecimientos != null) selected="selected" @endif>{{ $registro->alias_estab }}</option>
                      @endforeach
                    </optgroup>

                    <?php
                    $query = 'SELECT id_establecimiento, alias_estab
                              FROM 2019establecimientos
                              WHERE comuna_id_comuna=7';
                    $registros = DB::connection('mysql_rem')->select($query);
                    ?>
                    <optgroup label="Pozo Almonte">
                      @foreach($registros as $registro)
                        <option value="{{ $registro->id_establecimiento }}" @if (in_array($registro->id_establecimiento, $establecimientos) && $establecimientos != null) selected="selected" @endif>{{ $registro->alias_estab }}</option>
                      @endforeach
                    </optgroup>
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-2">
                <label>* Periodo: </label>
            </div>
            <div class="col-sm-10">
              <select class="form-control selectpicker" name="periodo[]" multiple="" title="Seleccione..." multiple data-actions-box="true" id="periodo">
                  <optgroup label="2020">
                      <option value="1" @if (in_array(1, $periodo) && $periodo!=null) selected="selected" @endif>Enero</option>
                      <option value="2" @if (in_array(2, $periodo) && $periodo!=null) selected="selected" @endif>Febrero</option>
                      <option value="3" @if (in_array(3, $periodo) && $periodo!=null) selected="selected" @endif>Marzo</option>
                      <option value="4" @if (in_array(4, $periodo) && $periodo!=null) selected="selected" @endif>Abril</option>
                      <option value="5" @if (in_array(5, $periodo) && $periodo!=null) selected="selected" @endif>Mayo</option>
                      <option value="6" @if (in_array(6, $periodo) && $periodo!=null) selected="selected" @endif>Junio</option>
                      <option value="7" @if (in_array(7, $periodo) && $periodo!=null) selected="selected" @endif>Julio</option>
                      <option value="8" @if (in_array(8, $periodo) && $periodo!=null) selected="selected" @endif>Agosto</option>
                      <option value="9" @if (in_array(9, $periodo) && $periodo!=null) selected="selected" @endif>Septiembre</option>
                      <option value="10" @if (in_array(10, $periodo) && $periodo!=null) selected="selected" @endif>Octubre</option>
                      <option value="11" @if (in_array(11, $periodo) && $periodo!=null) selected="selected" @endif>Noviembre</option>
                      <option value="12" @if (in_array(12, $periodo) && $periodo!=null) selected="selected" @endif>Diciembre</option>
                  </optgroup>
              </select>
            </div>
        </div>
        <br>
        <div class="row">

            <div class="col-sm-2">
                <?php if (!in_array(0, $establecimientos) AND !in_array(0, $periodo)){ ?>
                <button type="button" class="btn btn-outline-success"
                    onclick="tableToExcel('contenedor', '{{ strtoupper(collect(request()->segments())->last()) }}')">
                    <i class="fas fa-file-excel"></i> Exportar
                </button>
                <?php } ?>
            </div>

            <div class="col-sm-10" >
                <input class="form-control btn btn-primary" type="submit" value="Consultar">
            </div>
        </div>
        <br>
    </form>
</div>

@section('custom_js')

<script src="{{ asset('js/show_hide_tab.js') }}"></script>

@endsection
