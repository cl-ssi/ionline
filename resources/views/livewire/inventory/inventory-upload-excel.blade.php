<div>
    @section('title', 'Subir Excel')

    @include('inventory.nav', [
        'establishment' => $establishment,
    ])

    <h4>Seleccionar Excel para cargar inventarios</h4>

    @include('layouts.bt5.partials.flash_message')

    <form wire:submit="processExcel"
        enctype="multipart/form-data">

        <div class="mb-3">
            <label for="formFile"
                class="form-label"> Cargar Archivo</label>

            <div class="input-group mb-3">
                <input type="file"
                    class="form-control @error('excelFile') is-invalid @enderror"
                    id="excelFile"
                    wire:model.live="excelFile"
                    accept=".xlsx,.xls"
                    required>

                <button type="submit"
                    class="btn btn-primary"
                    wire:loading.attr="disabled">
                    <i class="fa fa-spinner fa-spin" wire:loading></i>
                    <i class="fas fa-fw fa-upload " wire:loading.class="d-none"></i> 
                    Cargar Archivo
                </button>
            </div>

            @error('excelFile')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

    </form>


    <div class="mt-4">
        <p>El formato para cargar el excel es el siguiente:
            <a href="{{ asset('upload-template/carga_inventario.xlsx') }}"
                target="_blank">Descargar Formato Excel</a>
        </p>
    </div>


    <hr class="mb-3 mt-3">

    <h3>Descargar Base de Datos</h3>

    <a href="{{ route('inventories.export-excel',$establishment) }}">Base de datos</a>

</div>
