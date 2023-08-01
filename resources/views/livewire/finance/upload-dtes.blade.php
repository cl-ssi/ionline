<form wire:submit.prevent="upload">

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ active('finance.dtes.index') }}" href="{{ route('finance.dtes.index') }}">Ver dtes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ active('finance.dtes.upload') }}" href="{{ route('finance.dtes.upload') }}">Cargar archivo</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.index') }}" href="{{ route('finance.payments.index') }}">Estados de Pago</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.review') }}" href="{{ route('finance.payments.review') }}">Bandeja de Revisión de Pago</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.ready') }}" href="{{ route('finance.payments.ready') }}">Bandeja de Pendientes para Pago</a>
        </li>
    </ul>

    
    <h3 class="mb-3">Cargar archivo de Acepta con reporte de DTEs</h3>

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="input-group mb-3">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="dte_file" wire:model="dtes">
            <label class="custom-file-label" for="dte_file" data-browse="Examinar">{{ optional($dtes)->getClientOriginalName() }}</label>
            <small id="emailHelp" class="form-text text-muted">Archivo xls de reporte de acepta, máximo 2mb.</small>
        </div>
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"> <i class="fas fa-fw fa-upload"></i> Cargar Archivo</button>
        </div>
    </div>

    @error('dtes') <span class="error">{{ $message }}</span> @enderror

</form>