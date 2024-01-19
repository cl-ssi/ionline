@extends('layouts.bt4.app')
@section('title', 'Reporte en Formato SLEP')
@section('content')
    @include('suitability.nav')

    <div class="container mt-4">
        <form action="{{ route('suitability.reports.processSlepForm') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="year">Seleccione el año:</label>

                <select class="form-control" name="year" id="year">
                        <option value="">Seleccionar año</option>
                        @foreach($years as $yearOption)
                            <option value="{{ $yearOption }}" {{ ($selectedYear == $yearOption) ? 'selected' : '' }}>
                                {{ $yearOption }}
                            </option>
                        @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Generar Reporte SLEP</button>
        </form>



        @if($slepData->count() > 0 and $slepData)
            <div class="mt-4">
                <h2>Datos del informe SLEP</h2>
                <div>
                    <a class="btn btn-primary" id="downloadLink" onclick="exportF(this)">
                        <i class="fas fa-file-excel"></i> Descargar en Excel
                    </a>
                </div>
                <table class="table" id="tabla_slep">
                    <thead>
                        <tr>
                            <th>Cantidad</th>
                            <th>Colegio</th>
                            <th>Nombre</th>
                            <th>Rut</th>
                            <th>Categoria Idoneidad</th>
                            <th>Fecha Evaluación</th>
                            <th>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slepData as $key => $data)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $data->school->name }}</td>
                                <td>{{ $data->user->full_name }}</td>
                                <td nowrap>{{ $data->user->run_format }}</td>
                                <td>{{ $data->status }}</td>
                                <td>{{ $data->updated_at?->format('d-m-Y') }}</td>
                                <td>{{ $data->job }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        @else
            <!-- Mensaje si no hay datos -->
            <p class="mt-4">No hay datos disponibles para el informe SLEP.</p>
        @endif



    </div>
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
            var table = document.getElementById("tabla_slep");
            var html = table.outerHTML;
            var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
            var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
            elem.setAttribute("href", url);
            elem.setAttribute("download", "tabla_slep_generado_el_" + day + "_" + month + "_" + year + "_" + hour +
                "_" + minute + ".xls"); // Choose the file name
            return false;
        }
    </script>


@endsection