<div>
    <style>
        .organigrama ol {
            counter-reset: item
        }

        .organigrama li {
            display: block
        }

        .organigrama li:before {
            content: counters(item, ".") " ";
            counter-increment: item
        }
    </style>
    <h3 class="mb-3">Organigrama Unidades Sirh</h3>

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="establecimiento">Establecimiento</label>
            <div class="input-group">
                <select class="form-select" wire:model.live="establishment">
                    <option value="125">SST</option>
                    <option value="130">HETG</option>
                    <option value="127">HAH</option>
                </select>
            </div>
            <div class="form-text">125 DSST, 130 HETG, 127 HAH</div>
        </div>
    </div>

    <!-- resources/views/livewire/unidades-index.blade.php -->
    <div class="organigrama">
        <ol>
            @foreach ($arbol as $unidad)
                @include('partials.unidad', ['unidad' => $unidad])
            @endforeach
        </ol>
    </div>
</div>
