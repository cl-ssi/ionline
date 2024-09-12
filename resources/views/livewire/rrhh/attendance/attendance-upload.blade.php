<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <h1>Cargar Asistencia</h1>
    <div class="alert alert-info" role="alert">
        <ul>
            <li>
                Exportar el archivo de asistencia desde Sirh, utilizando la opción: Format "Tab-separated text".
            </li>
            <li>
                Corregir febrero en el archivo de texto exportado de SIRH, ya que está mal escrito.
            </li>
        </ul>
    </div>
    <form wire:submit="save" class="row">
        <div class="col-md-6">
            <div class="input-group">
                <input type="file" class="form-control" wire:model.live="attendanceFile">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <i class="fa fa-spinner fa-spin" wire:loading></i>
                    <i class="bi bi-upload" wire:loading.remove></i>
                </button>
            </div>
            @error('attendanceFile')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
    </form>

    <br>

    @if (!empty($missingUserIds))
        <div class="alert alert-warning">
            <p>Los siguientes usuarios no se encontraron en el sistema:</p>
            <ul>
                @foreach ($missingUserIds as $userId)
                    <li>{{ $userId }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
