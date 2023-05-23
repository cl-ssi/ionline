<div>
    @section('title', 'Subir Excel')

    @include('inventory.nav', [
        'establishment' => $establishment,
    ])

    <h4>Seleccionar Excel para cargar inventarios</h4>

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif
    </div>

    <form wire:submit.prevent="processExcel" enctype="multipart/form-data">
        <div class="form-group">
            <label for="excelFile">Seleccionar archivo Excel</label>
            <input type="file" class="form-control-file @error('excelFile') is-invalid @enderror" id="excelFile"
                wire:model="excelFile" accept=".xlsx,.xls">
            @error('excelFile')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Cargar Excel</button>
        </div>
    </form>

</div>