<div>
    <!-- @include('finance.payments.partials.nav') -->

    <div class="row mb-3">
        <div class="col-6">
            <h3 class="mb-3">Mis Documentos Tributarios Electrónicos</h3>
        </div>
        <div class="col-6 text-end">
            <a class="btn btn-success d-inline" href="{{ route('finance.dtes.upload-single-bhe') }}">Subir Boleta Honorarios</a>
        </div>
    </div>


    <table class="table table-sm table-bordered" wire:loading.class="text-muted">
        <thead>
            <tr>
                <th>ID</th>
                <th width="55px">Estb.</th>
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>FR</th>
                <th>Recepción</th>
                <th>Bodega</th>
                <th>Pagado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dtes as $dte)
            <tr class="{{ $dte->rowClass }}">
                    <td class="text-center">
                        {{ $dte->id }}
                    </td>
                    <td>
                        {{ $dte->establishment?->alias }}
                    </td>
                    <td class="small">
                        @include('finance.payments.partials.dte-info')
                    </td>
                    <td class="small">
                        @livewire('finance.get-purchase-order', ['dte' => $dte], key($dte->id))
                    </td>
                    <td class="small">
                        @include('finance.payments.partials.fr-info')

                        {{ $dte->requestForm?->contractManager?->tinyName }} 
                        {{ $dte->contractManager?->tinyName }}
                        <br>
                        {{ $dte->estado_reclamo }}
                    </td>
                    <td class="small">
                        <!-- Nuevo módulo de Recepciones -->
                        @include('finance.payments.partials.receptions-info')
                    </td>

                    <td class="small">
                        -- pendiente
                    </td>
                    <td>
                        @if($dte->tgrPayedDte)
                            <i class="fas fa-thumbs-up text-success"></i>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $dtes->links() }}

</div>