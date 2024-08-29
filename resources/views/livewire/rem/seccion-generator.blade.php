<div>
    <!-- <script src="https://cdn.tiny.cloud/1/ktzops2hqsh9irqr0b17eqfnkuffe5d3u0k4bcpzkc1kfssx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
    <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
    <!-- <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script> -->
    <script src="{{ asset('js/tinymce/tinymce.5.10.min.js') }}" referrerpolicy="origin"></script>

    <style>
        table td{
            border: 1px solid black;
        }
    </style>

    <h3>
        REM {{ $seccion->nserie }} Sección {{ $seccion->name }}
        <a href="{{ route('indicators.rem.admin.seccion') }}" class="btn btn-outline-primary btn-sm">Volver</a>
    </h3>

    <div wire:ignore class="mb-2">
        <textarea class="form-control" wire:model.live="tabla" name="message" id="message" cols="30" rows="15"></textarea>
    </div>

    <center>
        <button wire:click="generar" class="btn btn-primary">Generar</button>
    </center>
    <br>

    {!! $tabla_final !!}
    
    <br>
    

    <div class="mb-3">
        <label for="for-cols" class="form-label">BD Cols</label>
        <input type="text" class="form-control " id="cols" wire:model.live="seccion.cols" disabled>
    </div>
    <div class="mb-3">
        <label for="for-cols" class="form-label">Cols</label>
        <input type="text" class="form-control {{ $seccion->cols == $cols ? 'is-valid' : 'is-invalid' }}" id="cols" wire:model.live="cols">
    </div>
    <div class="mb-3">
        <label for="for-cols" class="form-label">BD Cods</label>
        <input type="text" class="form-control " id="cols" wire:model.live="seccion.cods" disabled>
    </div>
    <div class="mb-3">
        <label for="for-cod" class="form-label">Cods</label>
        <input type="text" class="form-control {{ $seccion->cods == $cods ? 'is-valid' : 'is-invalid' }}" id="cods" wire:model.live="cods">
    </div>

    <hr>


    <div class="row">
        <div class="col-md-10">
            <div class="mb-3">
                <label for="for-supergroups" class="form-label">Supergroups</label>
                <input type="text" class="form-control" id="supergroups" wire:model.live="seccion.supergroups">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-check form-switch">
                </br>
                <input class="form-check-input" type="checkbox" role="switch" id="for-supergroups_inline" wire:model.live="seccion.supergroups_inline">
                <label class="form-check-label" for="for-supergroups_inline">Supergroups Inline</label>
            </div>
        </div>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="for-discard_group" wire:model.live="seccion.discard_group">
        <label class="form-check-label" for="for-discard_group">Discard Group</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="for-totals" wire:model.live="seccion.totals">
        <label class="form-check-label" for="for-totals">Totales</label>
    </div>

    <div class="mb-3">
        <label for="for-supergroups" class="form-label">Totals_by_prestacion</label>
        <input type="text" class="form-control" id="supergroups" wire:model.live="seccion.totals_by_prestacion">
    </div>

    <div class="mb-3">
        <label for="for-supergroups" class="form-label">Totals_by_group</label>
        <input type="text" class="form-control" id="supergroups" wire:model.live="seccion.totals_by_group">
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="for-totals_first" wire:model.live="seccion.totals_first">
        <label class="form-check-label" for="for-totals_first">Totales Primero</label>
    </div>

    <div class="row">
        <div class="col-md-10">
            <div class="mb-3">
                <label class="form-label" for="for-subtotals">Subtotales</label>
                <input class="form-control" type="text" id="for-subtotals" wire:model.live="seccion.subtotals">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-check form-switch">
                <br>
                <input class="form-check-input" type="checkbox" role="switch" id="for-subtotals_first" wire:model.live="seccion.subtotals_first">
                <label class="form-check-label" for="for-subtotals_first">Subtotales Primero</label>
            </div>
        </div>
    </div>


    <div class="mb-3">
        <label for="for-tfoot" class="form-label">Tfoot</label>
        <textarea class="form-control" id="for-tfoot" wire:model.live="seccion.tfoot" rows="6"></textarea>
    </div>

    <table class="mb-3 table-bordered border-secondary">
        {!! $seccion->thead !!}
    </table>


    Total Columnas: {{ $columnas }}<br>

    @if($cabecera)
        <table class="mb-3">
            {!! $thead !!}
        </table>

        <div class="row mb-3">
            <div class="col">
                <textarea class="form-control" id="" cols="50" rows="20" wire:model.live="seccion.thead" disabled></textarea>
            </div>
            <div class="col">
                <textarea class="form-control {{ $seccion->thead == $thead ? 'is-valid' : 'is-invalid' }}" id="" cols="50" rows="20" wire:model.live="thead"></textarea>
            </div>
        </div>

    @endif

    <center>
        <a href="{{ route('indicators.rem.admin.seccion') }}" class="btn btn-outline-primary ">Volver</a>
        <button type="submit" class="btn btn-primary" wire:click="save">Guardar</button>
        <a href="{{ route('indicators.rem.admin.generator', $nextRecord) }}" class="btn btn-secondary">Siguiente</a>
    </center>

    @push('scripts')
        <script>
            tinymce.init({
                selector: '#message',
                language: 'es_MX',
                toolbar: "removeformat",
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
</div>
