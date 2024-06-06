<div>
    {{-- Do your work, then step back. --}}
    @include('finance.payments.partials.nav')

    <h3>Respaldos en PDF de Sigfe</h3>
    <table class="table table-sm table-bordered" wire:loading.class="text-muted">

        <thead>
            <tr>
                <th>ID</th>
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>FR</th>
                <th>Recepción/Adjuntos</th>
                <th width="90">Fecha Aceptación SII (días)</th>
                <th>Pdf Pago sin Firma</th>
                <th>Pdf Pago con Firma</th>
            </tr>
        </thead>

    </table>

    <div wire:loading.remove>
        {{ $dtes->links() }}
    </div>



</div>
