<div>
    <h3>Prestaciones</h3>

    @include('indicators.rem.partials.admin.nav')

    <div class="mb-3">
        <table class="table table-sm table-bordered">
            <tr>
                <th>CODIGOS</th>
                <th>descripcion</th>
                <th>serie</th>
                <th>hoja</th>
                <th>year</th>
            </tr>
            <tr>
                <td>18010100</td>
                <td>EXAMENES DE DIAGNOSTICO - HEMATOLOGICOS</td>
                <td>BM</td>
                <td>BM18</td>
                <td>2024</td>
            </tr>
            <tr>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
            </tr>
        </table>
        <label for="exampleFormControlTextarea1" class="form-label">Pegar diccionario glosa directo desde el excel, solo las columnas según ejemplo de arriba</label>
        <textarea wire:model="prestaciones" class="form-control" id="exampleFormControlTextarea1" rows="10"></textarea>
    </div>
    <button type="submit" class="btn btn-primary" wire:click="process">Procesar</button>

    <pre>

@if($process)
<textarea name="" id="" cols="140" rows="30">
{{ $truncate_query }}

@foreach($process as $query)
{{ $query }}
@endforeach
</textarea>
@endif
    </pre>
</div>
