<div>
    @section('title', 'Subir Excel')

    @include('inventory.nav', [
        'establishment' => $establishment,
    ])

    <h4>Seleccionar Excel para cargar inventarios</h4>

    @include('layouts.bt5.partials.flash_message')

    <form wire:submit.prevent="processExcel" enctype="multipart/form-data">
        <div class="form-row">
            <div class="col-10">

                <div class="form-group">
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input @error('excelFile') is-invalid @enderror"
                            id="excelFile" wire:model="excelFile" accept=".xlsx,.xls" required>
                        <label class="custom-file-label" for="excelFile" data-browse="Examinar">Seleccionar archivo
                            Excel</label>
                        @error('excelFile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Cargar Excel</button>
                </div>
                <div wire:loading wire:target="excelFile">Cargando...</div>
            </div>
        </div>
    </form>


    <div class="mt-4">
        <p>El formato para cargar el excel es el siguiente:</p>
        <a href="{{ asset('upload-template/carga_inventario.xlsx') }}" class="btn btn-outline-secondary"
            target="_blank">Formato Excel</a>
    </div>

</div>
