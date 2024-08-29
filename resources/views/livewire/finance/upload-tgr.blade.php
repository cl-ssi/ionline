<div>
    @include('finance.payments.partials.nav')
    

    @include('layouts.bt5.partials.flash_message')
    <h3 class="mb-3">Cargar archivo de TGR con reporte de Pagos a Proveedores</h3>
    <a href="{{ asset('upload-template/formato_pago_proveedores.xls') }}" target="_blank">Descargar formato del archivo de Pagos a Proveedores</a> 
    <br><br>
    <form wire:submit="upload">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <div class="input-group mb-3">
            <input type="file" class="form-control" id="dte_file" wire:model.live="tgrs" accept=".xls">
            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                <i class="fas fa-fw fa-cloud-upload-alt"></i> Cargar Archivo
            </button>
        </div>
        <span class="form-text text-muted">Archivo xls de reporte de TGR</span>
        @error('dtes') <div class="alert alert-danger" role="alert">{{ $message }}</div> @enderror
    </form>

    <hr>
    <h3 class="mb-3">Cargar archivo de SIGFE con Cartera Financiera Contable</h3>
    <a href="{{ asset('upload-template/formato_cartera_financiera_contable.xls') }}" target="_blank">Descargar formato del archivo de Cartera Financiera Contable</a> 
    <br><br>
    <form wire:submit="uploadAccountingPortfolio">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="dte_file" wire:model.live="portfolios" accept=".xls,.xlsx">
            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                <i class="fas fa-fw fa-cloud-upload-alt"></i> Cargar Archivo
            </button>
        </div>
        <span class="form-text text-muted">Archivo xls de cartera financiera de TGR</span>
        @error('portfolios') <div class="alert alert-danger" role="alert">{{ $message }}</div> @enderror
    </form>

    <hr>

    <h3 class="mb-3">Cargar archivo de SIGFE Comparativo de Requerimientos</h3>
    <a href="{{ asset('upload-template/formato_comparativo_de_requerimientos.xlsx') }}" target="_blank">Descargar formato del archivo SIGFE Comparativo de Requerimientos</a> 
    <br><br>

    <form wire:submit="uploadComparativeRequirement">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="dte_file" wire:model.live="requirements" accept=".xls,.xlsx">
            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                <i class="fas fa-fw fa-cloud-upload-alt"></i> Cargar Archivo
            </button>
        </div>
        <span class="form-text text-muted">Archivo xls de comparativo de requerimientos</span>
        @error('requirements') <div class="alert alert-danger" role="alert">{{ $message }}</div> @enderror
    </form>
</div>
