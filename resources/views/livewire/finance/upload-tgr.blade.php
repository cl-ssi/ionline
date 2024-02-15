<div>
    @include('finance.payments.partials.nav')
    

    @include('layouts.bt5.partials.flash_message')
    <h3 class="mb-3">Cargar archivo de TGR con reporte de de Pagos de a Proveedores</h3>
    <form wire:submit.prevent="upload">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <div class="input-group mb-3">
            <input type="file" class="form-control" id="dte_file" wire:model="tgrs" accept=".xls">
            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                <i class="fas fa-fw fa-cloud-upload-alt"></i> Cargar Archivo
            </button>
        </div>
        <span class="form-text text-muted">Archivo xls de reporte de TGR</span>
        @error('dtes') <div class="alert alert-danger" role="alert">{{ $message }}</div> @enderror
    </form>

    <hr>
    <h3 class="mb-3">Cargar archivo de TGR con Cartera Financiera Contable</h3>
    <form wire:submit.prevent="uploadAccountingPortfolio">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="dte_file" wire:model="portfolios" accept=".xls">
            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                <i class="fas fa-fw fa-cloud-upload-alt"></i> Cargar Archivo
            </button>
        </div>
        <span class="form-text text-muted">Archivo xls de cartera financiera de TGR</span>
        @error('portfolios') <div class="alert alert-danger" role="alert">{{ $message }}</div> @enderror
    </form>
</div>
