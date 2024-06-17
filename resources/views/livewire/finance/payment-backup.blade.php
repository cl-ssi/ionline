<div>
    {{-- Do your work, then step back. --}}
    @include('finance.payments.partials.nav')

    <h3>Respaldos en PDF de Sigfe</h3>

    <form wire:submit.prevent="search">
        <div class="row g-2 mb-3">
            <div class="col-md-1">
                <label for="for-id" class="form-label">ID</label>
                <input type="text" class="form-control" wire:model.defer="filters.id" placeholder="id">
            </div>
            <div class="col-md-2">
                <label for="for-emisor" class="form-label">Rut</label>
                <input type="text" class="form-control" wire:model.defer="filters.emisor" placeholder="rut emisor">
            </div>
            <div class="col-md-2">
                <label for="for-folio" class="form-label">Folio Pago</label>
                <input type="text" class="form-control" wire:model.defer="filters.folio_pago" placeholder="folio pago">
            </div>
            <!-- Agrega más campos según tus necesidades -->
            <div class="col-md-1">
                <label for="search" class="form-label">&nbsp;</label>
                <button class="btn btn-outline-secondary form-control" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>


    <table class="table table-sm table-bordered" wire:loading.class="text-muted">

        <thead>
            <tr>
                <th>ID</th>
                <th width="55px">Estb.</th>
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>FR</th>
                <th>Recepción/Adjuntos</th>
                <th>Folio Pago</th>
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
                    <td>{{$dte->tgrPayedDte?->folio}}</td>
                    <td>
                        @livewire('finance.upload-pdf', ['dteId' => $dte->id, 'type' => 'comprobante_pago'], key('upload-pdf-' . $dte->id))
                    </td>
                    <td>
                        @if($dte->comprobantePago && $dte->comprobantePago->allApprovalsOk() && $dte->comprobantePago->approvals->last())
                            <a class="btn btn-sm btn-outline-danger" target="_blank" 
                            href="{{ route('documents.signed.approval.pdf', $dte->comprobantePago->approvals->last()) }}"
                            >
                                <i class="fas fa-fw fa-file-pdf"></i>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <div wire:loading.remove>
        {{ $dtes->links() }}
    </div>



</div>
