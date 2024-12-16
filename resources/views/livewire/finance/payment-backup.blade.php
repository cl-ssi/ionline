<div>
    {{-- Do your work, then step back. --}}
    @include('finance.payments.partials.nav')

    <h3>Pagos TGR</h3>

    <form wire:submit="search">
        <div class="row g-2 mb-3">
            <div class="col-md-1">
                <label for="for-id" class="form-label">ID</label>
                <input type="text" class="form-control" wire:model="filters.id" placeholder="id">
            </div>
            <div class="col-md-2">
                <label for="for-emisor" class="form-label">Rut</label>
                <input type="text" class="form-control" wire:model="filters.emisor" placeholder="rut emisor">
            </div>

            <div class="col-md-2">
                <label for="for-folio" class="form-label">N° Folio Pago</label>
                <input type="text" class="form-control" wire:model="filters.folio_pago" placeholder="folio pago">
            </div>

            <div class="col-md-2">
                <label for="for-folio" class="form-label">Estado Folio Pago</label>
                <select class="form-select" wire:model="filters.estado_folio_pago">
                    <option value="Todos">Todos</option>
                    <option value="Sin Folio">Sin Folio</option>
                    <option value="Con Folio">Con Folio</option>
                </select>
            </div>


            <div class="col-md-2">
                <label for="for-folio" class="form-label">PDF Pago Sin Firma</label>
                <select class="form-select" wire:model="filters.sin_firma">
                    <option value="Todos">Todos</option>
                    <option value="Subidos">Subidos</option>
                    <option value="Sin Subir">Sin Subir</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="for-folio" class="form-label">PDF Pago Firmado</label>
                <select class="form-select" wire:model="filters.firmado">
                    <option value="Todos">Todos</option>
                    <option value="Pendientes">Pendientes</option>
                    <option value="Firmados">Firmados</option>
                </select>
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
                <th>SIGFE</th>
                <th>Folio Pago</th>
                <th>Comprobante de Pago</th>
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

                        {{ $dte->requestForm?->contractManager?->tinyName }}
                        {{ $dte->contractManager?->tinyName }}
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
                        <div>
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
                        </div>
                    </td>
                    <td>{{$dte->tgrPayedDte?->folio}}</td>
                    <td>
                        @livewire('finance.upload-pdf', ['dteId' => $dte->id, 'type' => 'comprobante_pago', 'approval' => 'false'], key('upload-pdf-' . $dte->id))
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <div wire:loading.remove>
        {{ $dtes->links() }}
    </div>



</div>
