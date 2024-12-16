<div>
    {{-- Do your work, then step back. --}}
    @include('finance.payments.partials.nav')

    <h3>Pagos Institucionales</h3>

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
            <div class="col-md-1">
                <label for="for-folio" class="form-label">Folio DTE</label>
                <input type="text" class="form-control" wire:model="filters.folio" placeholder="folio">
            </div>
            <div class="col-md-2">
                <label for="for-folio" class="form-label">Folio Comp</label>
                <input type="text" class="form-control" wire:model="filters.folio_compromiso" placeholder="compromiso">
            </div>
            <div class="col-md-2">
                <label for="for-folio" class="form-label">Folio Dev</label>
                <input type="text" class="form-control" wire:model="filters.folio_devengo"  placeholder="devengo">
            </div>
            <div class="col-md-2">
                <label for="for-folio" class="form-label">Folio Pago</label>
                <input type="text" class="form-control" wire:model="filters.folio_pago" placeholder="folio pago">
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
                <th scope="col">ID</th>
                <th scope="col">Archivos Asociados</th>
                <th scope="col">Receptor</th>
                <th scope="col">Adjuntos</th>
                <th scope="col">SIGFE</th>
                <th scope="col">Fecha de Pago</th>
                <th scope="col">Pdf Pago sin Firma</th>
                <th scope="col">Pdf Pago con Firma</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($dtes as $dte)
                <tr>
                    <td class="small text-center">
                        {{ $dte->id }}
                    </td>
                    <td class="small">
                        <small>Documento</small>
                            @if($dte->emisor)
                                @include('finance.payments.partials.dte-info')
                            @else
                                <div wire:key="document-upload-pdf-{{$dte->id}}">
                                    @livewire('finance.upload-pdf', ['dteId' => $dte->id, 'type' => 'documento'], key('document-upload-pdf-' . $dte->id))
                                </div>
                                <hr>
                            @endif
                        <small>Resolucion</small>
                        <div wire:key="resolucion-upload-pdf-{{$dte->id}}">
                            @livewire('finance.upload-pdf', ['dteId' => $dte->id, 'type' => 'resolucion'], key('resolucion-upload-pdf-' . $dte->id))
                        </div>
                        <hr>
                        <small>Comprobante Bancario</small>
                        <div wire:key="bank-upload-pdf-{{$dte->id}}">
                            @livewire('finance.upload-pdf', ['dteId' => $dte->id, 'type' => 'comprobante_bancario'], key('bank-upload-pdf-' . $dte->id))
                        </div>
                    </td>
                    <td class="small">
                        @if($dte->receptions)
                            <div>
                                @include('finance.payments.partials.receptions-info')
                            </div>
                        @else
                        {{$dte->receptor}}
                        @endif
                    </td>
                    <td class="small">
                        <div class="container">
                            @foreach($dte->filesPdf as $file)
                                <div wire:key="dte-{{$dte->id}}-list-pdf-{{$file->id}}">
                                    @livewire('finance.list-pdf', ['dteId' => $dte->id, 'file'=> $file], key('dte-' . $dte->id . '-list-pdf-' . $file->id))
                                </div>
                            @endforeach
                        </div>
                        <div wire:key="attachment-upload-pdf-{{$dte->id}}">
                            @livewire('finance.upload-pdf', ['dteId' => $dte->id, 'type' => 'adjunto', 'approval' => 'false', 'small' => 'true'], key('attachment-upload-pdf-' . $dte->id))
                        </div>
                    </td>
                    <td class="small">
                        <div>
                            <!-- SIGFE Compromiso y Devengo -->
                            <small>Compromiso</small>
                            <div wire:key="compromiso-folio-{{$dte->id}}">
                                @livewire('finance.sigfe-folio-compromiso', ['dte' => $dte, 'onlyRead' => 'true'], key('compromiso-folio-' . $dte->id))
                            </div>
                            <div wire:key="compromiso-file-{{$dte->id}}">
                                @livewire('finance.sigfe-archivo-compromiso', ['dte' => $dte, 'onlyRead' => 'true'], key('compromiso-file-' . $dte->id))
                            </div>
                            <hr>
                            <small>Devengo</small>
                            <div wire:key="devengo-folio-{{$dte->id}}">
                                @livewire('finance.sigfe-folio-devengo', ['dte' => $dte, 'onlyRead' => 'true'], key('devengo-folio-' . $dte->id))
                            </div>
                            <hr>
                            <div wire:key="devengo-file-{{$dte->id}}">
                                @livewire('finance.sigfe-archivo-devengo', ['dte' => $dte, 'onlyRead' => 'true'], key('devengo-file-' . $dte->id))
                            </div>
                        </div>
                    </td>
                    <td class="small">
                        <div wire:key="fecha_{{$dte->id}}">
                            @if ($dte->fecha)
                                {{$dte->fecha}}
                                <button type="button" class="btn btn-primary btn-sm mt-2" wire:loading.attr="disabled" wire:click="delete({{$dte->id}}, 'fecha')"><i class="fa fa-trash"></i></button>
                            @else
                                <form class="form-inline" wire:submit="save({{$dte->id}})">
                                    <div class="input-group">
                                        <input class="form-control fs-6" type="date" wire:model="fecha.{{$dte->id}}">
                                        <button type="submit" class="btn btn-outline-primary btn-sm" wire:loading.attr="disabled"><i class="fas fa-save"></i></button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </td>
                    <td class="small" wire:key="upload-pdf-{{$dte->id}}">
                        @livewire('finance.upload-pdf', ['dteId' => $dte->id, 'type' => 'comprobante_pago'], key('upload-pdf-' . $dte->id))
                    </td>
                    <td class="small">
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
