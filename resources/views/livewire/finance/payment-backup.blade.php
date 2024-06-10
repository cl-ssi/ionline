<div>
    {{-- Do your work, then step back. --}}
    @include('finance.payments.partials.nav')

    <h3>Respaldos en PDF de Sigfe</h3>
    <table class="table table-sm table-bordered" wire:loading.class="text-muted">

        <thead>
            <tr>
                <th>ID</th>
                <th width="55px">Estb.</th>
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>FR</th>
                <th>Recepción/Adjuntos</th>
                <th>Pdf Pago sin Firma</th>
                <th>Pdf Pago con Firma</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($dtes as $dte)
                <tr>
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

                        {{ $dte->requestForm?->contractManager?->tinnyName }} 
                        {{ $dte->contractManager?->tinnyName }}
                        <br>
                        
                        <!-- Si tiene administrador de contrato mostrar el avion para enviar notificación -->
                        @if($dte->requestForm?->contractManager?->id OR $dte->contract_manager_id)
                            @if($dte->confirmation_send_at AND $dte->receptions->isEmpty())
                                <i class="fas fa-paper-plane"></i> 
                                {{ $dte->confirmation_send_at }}
                            @else
                                <button type="button" 
                                    class="btn btn-sm btn-primary" 
                                    wire:click="sendConfirmation({{ $dte->id }})">
                                    <i class="fas fa-fw fa-paper-plane"></i>
                                </button>
                            @endif
                        @endif

                        {{ $dte->estado_reclamo }}
                    </td>
                    <td class="small">
                         <!-- Nuevo módulo de Recepciones -->
                        @include('finance.payments.partials.receptions-info')
                    </td>
                    <td>
                        @livewire('finance.upload-pdf', ['dteId' => $dte->id, 'type' => 'comprobante_pago'], key('upload-pdf-' . $dte->id))
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <div wire:loading.remove>
        {{ $dtes->links() }}
    </div>



</div>
