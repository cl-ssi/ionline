<div>
<script src="https://cdn.tiny.cloud/1/ktzops2hqsh9irqr0b17eqfnkuffe5d3u0k4bcpzkc1kfssx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    @push('scripts')
        <script>
            tinymce.init({
                selector: '#message',
                language: 'es_MX',
                //theme: 'modern',
                plugins: [
                    'code','table'
                ],
                forced_root_block: false,
                setup: function (editor) {
                    editor.on('init change', function () {
                        editor.save();
                    });
                    editor.on('change', function (e) {
                        @this.set('tabla', editor.getContent());
                    });
                }
            });
        </script>
    @endpush

    <style>
        table td{
            border: 1px solid black;
            /* border-collapse: collapse; */
        }
    </style>

    <h3>
        Secciones 2024 {{ $seccion->nserie }} {{ $seccion->name }}
        <a href="{{ route('indicators.rem.seccion') }}" class="btn btn-outline-primary btn-sm">Volver</a>
    </h3>

    <div wire:ignore>
        <textarea class="form-control" wire:model="tabla" name="message" id="message" cols="30" rows="15"></textarea>
    </div>

    <button wire:click="generar" class="btn btn-primary">Generar</button>
    <br>

    {!! $tabla_final !!}
    
    <br>
    
    <div class="mb-3">
        <label for="for-cols" class="form-label">Cols</label>
        <input type="text" class="form-control" id="cols" wire:model="cols">
    </div>
    <div class="mb-3">
        <label for="for-cod" class="form-label">Codigos</label>
        <input type="text" class="form-control" id="cods" wire:model="codigos">
    </div>
    <!-- <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div> -->
    <button type="submit" class="btn btn-primary" wire:click="save">Guardar</button>

    Total Columnas: {{ $columnas }}<br>

    @if($cabecera)
    <table>
        @foreach($cabecera as $row)
            <tr>
                @foreach($row as $col)
                    <td {!! $col['attributos'] !!}>{!! $col['valor'] !!}</td>
                @endforeach
            </tr>
        @endforeach
    </table>


<textarea class="form-control" id="" cols="50" rows="20" wire:model="thead"></textarea>

    @endif

    <br>

</div>
