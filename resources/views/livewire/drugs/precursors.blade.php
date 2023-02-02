<div>
    @section('title', 'Ingresar Recepción')

    @include('drugs.nav')

    <div>

        <div class="left" style="float: left;">
            <img src="{{ asset('images/logo_rgb.png') }}" width="120" alt="Logo servicio de salud"><br>
            <div class="left seis" style="padding-bottom: 6px; color: #999"></div>
        </div>
        <div style="float: right; font-size: 18px;">
            <br>
            <br>
            <br>
            <strong>Número:</strong> <br>
            <strong>Fecha:</strong> {{ now()->toDateString() }}
        </div>
    </div>


    <div style="clear: both; padding-bottom: 10px"></div>

    <h3 class="mb-3 mt-3">
        Precursores
    </h3>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Acta</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th class="text-right" width="180px">Peso Neto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($precursors as $precursor)
            <tr>
                <td>{{ $precursor->reception->id }}</td>
                <td>{{ $precursor->substance->name }}</td>
                <td>{{ $precursor->description }}</td>
                <td class="text-right">{{ money($precursor->net_weight)}} {{ $precursor->substance->unit }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br><br><br>

    <table class="table table-sm text-center mt-4">
        <tr>
            <td width="50%">
                <strong>Quien entrega</strong><br>
                {{ auth()->user()->shortName }}
            </td>
            <td>
                <strong>Quien recibe</strong><br>
                
            </td>
        </tr>
    </table>
</div>
