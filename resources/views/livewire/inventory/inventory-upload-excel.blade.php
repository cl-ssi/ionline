<div>
    @section('title', 'Subir Excel')

    @include('inventory.nav', [
        'establishment' => $establishment,
    ])

    <h4>Seleccionar Excel para cargar inventarios</h4>

    @include('layouts.bt4.partials.flash_message')

    <form wire:submit.prevent="processExcel" enctype="multipart/form-data">


        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input @error('excelFile') is-invalid @enderror"
                    id="excelFile" wire:model="excelFile" accept=".xlsx,.xls" required>
                <label class="custom-file-label" for="excelFile" data-browse="Examinar">
                {{ optional($excelFile)->getClientOriginalName() }}
                </label>
                @error('excelFile')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group-append">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"><i class="fas fa-fw fa-upload"></i> Cargar Archivo</button>
            </div>
        </div>
        <div class="text-right" wire:loading wire:target="excelFile">Cargando...</div>
    </form>


    <div class="mt-4">
        <p>El formato para cargar el excel es el siguiente: 
        <a href="{{ asset('upload-template/carga_inventario.xlsx') }}"
            target="_blank">Descargar Formato Excel</a>
        </p>
    </div>

</div>
