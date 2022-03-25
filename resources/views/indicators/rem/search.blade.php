<!-- <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"> -->
<!--    Exportar a Excel     -->
<!-- <script type="text/javascript">
    var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
            ,
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8"></head><body><table>{table}</table></body></html>'
            , base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            }
            , format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) {
                    return c[p];
                })
            }
        return function (table, name) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script> -->

@if(in_array($prestacion->serie, []))
<div class="alert alert-warning" role="alert">
    <i class="fas fa-info-circle"></i> Datos preliminares correspondiente al mes de Octubre 2021.
</div>
@endif

<div class="form-group">
    <form method="GET" action="{{ route('indicators.rem.show', [$year, $prestacion->serie, $prestacion->Nserie]) }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-2">
                <label>* Establecimiento: </label>
            </div>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="establecimiento[]" data-live-search="true" multiple="" data-size="10" title="Seleccione..." multiple data-actions-box="true" id="establecimiento" required>
                @php($temp = null)
                @foreach($establecimientos as $estab)
                    @if($estab->comuna != $temp) <optgroup label="{{$estab->comuna}}"> @endif
                    <option value="{{ $estab->Codigo }}" @if (isset($establecimiento) && in_array($estab->Codigo, $establecimiento)) selected @endif>{{ $estab->alias_estab }}</option>
                    @php($temp = $estab->comuna)
                    @if($estab->comuna != $temp) </optgroup> @endif
                @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-2">
                <label>* Periodo: </label>
            </div>
            <div class="col-sm-10">
              <select class="form-control selectpicker" name="periodo[]" title="Seleccione..." @if($prestacion->serie != 'P') multiple @endif data-actions-box="true" id="periodo" required>
                  <optgroup label="{{$year}}">
                      @php($months = array (1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'))
                      @foreach($months as $index => $month)
                      <option value="{{$index}}" @if (isset($periodo) && in_array($index, $periodo)) selected @endif @if($prestacion->serie == 'P' AND !in_array($index, [6,12])) disabled @endif>{{$month}}</option>
                      @endforeach
                  </optgroup>
              </select>
            </div>
        </div>
        <br>
        <div class="row">

            <div class="col-sm-2">
                @if($establecimiento AND $periodo)
                <button type="button" class="btn btn-outline-success"
                    onclick="tableExcel('REM {{$year}} - Serie {{$prestacion->Nserie}}')">
                    <i class="fas fa-file-excel"></i> Exportar
                </button>
                @endif
            </div>

            <div class="col">
                <input class="form-control btn btn-primary" type="submit" name="submit" value="Consultar">
            </div>
        </div>
        <br>
    </form>
</div>

@section('custom_js')

<script src="{{ asset('js/show_hide_tab.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.18.0/dist/xlsx.full.min.js"></script>

<script>
    function tableExcel(filename, type, fn, dl) {
          var elt = document.getElementById('contenedor');
        //   const filename = 'REM'
          var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS", raw: false });
          return dl ?
            XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
        }
</script>

@endsection
