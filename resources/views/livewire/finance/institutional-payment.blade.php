<div>
    {{-- Do your work, then step back. --}}
    @include('finance.payments.partials.nav')

    <h3>Pagos Institucionales</h3>

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
            <div class="col-md-1">
                <label for="for-folio" class="form-label">Folio DTE</label>
                <input type="text" class="form-control" wire:model.defer="filters.folio" placeholder="folio">
            </div>
            <div class="col-md-2">
                <label for="for-folio" class="form-label">Folio Comp</label>
                <input type="text" class="form-control" wire:model.defer="filters.folio_compromiso" placeholder="compromiso">
            </div>
            <div class="col-md-2">
                <label for="for-folio" class="form-label">Folio Dev</label>
                <input type="text" class="form-control" wire:model.defer="filters.folio_devengo"  placeholder="devengo">
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
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>FR</th>
                <th>Adjuntos</th>
                <th>Recepción</th>
                <th>SIGFE</th>
                <th>Folio Pago</th>
                <th>Pdf Pago</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($dtes as $dte)
                <tr>
                    <td class="small text-center">
                        {{ $dte->id }}
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
                        @include('finance.payments.partials.fr-files')
                        <hr>
                        <form wire:submit.prevent="save">
                            <div class="form-group form-inline">
                                <input class="form-control"
                                    type="file"
                                    wire:model="support_file"
                                    id="support_file" hidden/>
                                <label
                                    for="support_file"
                                    style="cursor: pointer;"
                                    class="text-light bg-secondary px-2 py-1 rounded border-1">
                                    <i class="fas fa-file"></i>
                                </label>
                                <button type="submit" class="text-light bg-primary px-2 py-1 rounded border-1">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                    <td class="small">
                         <!-- Nuevo módulo de Recepciones -->
                        @include('finance.payments.partials.receptions-info')
                    </td>
                    <td class="small">
                        <!-- SIGFE Compromiso y Devengo -->
                        <small>Compromiso</small>
                        @livewire('finance.sigfe-folio-compromiso',
                        [
                            'dte' => $dte,
                            'onlyRead' => 'true'
                        ],
                        key($dte->id))
                        @livewire('finance.sigfe-archivo-compromiso',
                        [
                            'dte' => $dte,
                            'onlyRead' => 'true'
                            ], key($dte->id))
                        <hr>
                        <small>Devengo</small>
                        @livewire('finance.sigfe-folio-devengo', [
                            'dte' => $dte,
                            'onlyRead' => 'true'
                        ], key($dte->id))
                        <hr>
                        @livewire('finance.sigfe-archivo-devengo',
                        [
                            'dte' => $dte,
                            'onlyRead' => 'true'
                        ], key($dte->id))
                    </td>

                    <td class="small">{{$dte->tgrPayedDte?->folio}}</td>
                    <td class="small">
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
