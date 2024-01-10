@extends('layouts.bt4.app')
@section('title', 'Reporte de Solicitudes de Idoneidad')
@section('content')
    @include('suitability.nav')
    <h3 class="mb-3">Reporte de Solicitudes de Idoneidad @if ($includeTrashed) (Incluye eliminados) @endif</h3>
    <form method="GET" class="form-horizontal" action="{{ $route }}">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="for_from">Desde:</label>
                    <input type="datetime-local" id="from" name="from" class="form-control datetimepicker" required
                        value="{{ $request->input('from') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="for_to">Hasta:</label>
                    <input type="datetime-local" id="to" name="to" class="form-control datetimepicker" required
                        value="{{ $request->input('to') }}">
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-primary mr-3">Generar reporte</button>
                @if (!empty($psirequests) && count($psirequests) > 0)
                    <a class="btn btn-outline-success btn-sm" id="downloadLink" onclick="exportF(this)">Descargar en excel
                        resultados de búsqueda</a>
                @endif
            </div>
        </div>
    </form>


    @if (!empty($psirequests))
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-responsive text-center align-middle" id="tabla_solicitudes">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Run</th>
                        <th>Colegio</th>
                        <th>RBD</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Cargo</th>
                        <th>Estado</th>
                        <th>Fecha Solicitud</th>
                        <th>Correo</th>
                        @if ($includeTrashed)
                        <th>Fecha y Hora de eliminación</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 1;
                    @endphp
                    @forelse ($psirequests as $psirequest)
                        <tr>
                            <td>{{ $counter }}</td>
                            <td>{{ $psirequest->id ?? '' }}</td>
                            <td>{{ $psirequest->user->runFormat ?? '' }}</td>
                            <td>{{ $psirequest->school->name ?? '' }}</td>
                            <td>{{ $psirequest->school->rbd ?? '' }}</td>
                            <td>{{ $psirequest->user->name ?? '' }}</td>
                            <td>{{ $psirequest->user->fathers_family ?? '' }}</td>
                            <td>{{ $psirequest->user->mothers_family ?? '' }}</td>
                            <td>{{ $psirequest->job ?? '' }}</td>
                            <td>{{ $psirequest->status ?? '' }}</td>
                            <td>{{ $psirequest->created_at ?? '' }}</td>
                            <td>{{ $psirequest->user->email ?? '' }}</td>
                            <td>{{ $psirequest->deleted_at ?? '' }}</td>
                        </tr>
                        @php
                        $counter++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="14">No se encontraron solicitudes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

@endsection

@section('custom_js')
    <script type="text/javascript">
        let date = new Date()
        let day = date.getDate()
        let month = date.getMonth() + 1
        let year = date.getFullYear()
        let hour = date.getHours()
        let minute = date.getMinutes()

        function exportF(elem) {
            var table = document.getElementById("tabla_solicitudes");
            var html = table.outerHTML;
            var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
            var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
            elem.setAttribute("href", url);
            elem.setAttribute("download", "reporte_solicitudes_consolidado_" + day + "_" + month + "_" + year + "_" + hour +
                "_" + minute + ".xls"); // Choose the file name
            return false;
        }
    </script>


@endsection
