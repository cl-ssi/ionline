@extends('layouts.bt4.app')

@section('title', 'Productos')

@section('content')


<div class="text-right">
    <button type="button" class="btn btn-sm btn-outline-primary"
            onclick="tableExcel('Movimientos')">
            Excel <i class="fas fa-download"></i>
    </button>
</div>


<!--form class="form-inline float-right" method="GET" action="{{ route('rrhh.users.index') }}">
    <div class="input-group mb-3">
        <input type="text" name="name" class="form-control" placeholder="Nombre del producto" autocomplete="off">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search" aria-hidden="true"></i></button>
        </div>
    </div>
</form-->



@endsection

@section('custom_js')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.18.0/dist/xlsx.full.min.js"></script>

<script>
    function tableExcel(filename, type, fn, dl) {
          var elt = document.getElementById('tabla_movimientos');
        //   const filename = 'REM'
          var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS", raw: false });
          return dl ?
            XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
        }
</script>
@endsection
