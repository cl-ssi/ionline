<div>
    <h3>Recepción {{ $reception->id }}</h3>

    <div class="text-center">
        <h3 class="spinner-border"
            role="status"
            wire:loading>
        </h3>
    </div>

    <table class="table table-bordered table-sm">
        <tr>
            <th>ID</th>
            <td>{{ $reception->id }}</td>
            <td>
                <button wire:click="deleteReception"
                    @class([
                        'btn',
                        'btn-danger',
                        'form-control',
                        'disabled' => $reception->items->isNotEmpty(),
                    ])>
                    Eliminar Recepcion
                </button>
            </td>
        </tr>

        <tr>
            <th>Autor</th>
            <td>{{ $reception->creator->shortName }}</td>
            <td width="200"></td>
        </tr>

        <tr>
            <th>Fecha acta</th>
            <td>{{ $reception->date?->format('Y-m-d') }}</td>
            
            <td>
                @if($reception->purchase_order)
                    @if ($reception->rejected == false)
                        <a href="{{ route('finance.receptions.create', ['reception_id' => $reception->id, 'control_id' => '0']) }}"
                            @class([
                                'btn',
                                'btn-primary',
                                'form-control',
                                'disabled' => $reception->items->isNotEmpty(),
                            ])>
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    @endif
                @endif
            </td>
            
        </tr>

        <tr>
            <th>Items</th>
            <td>
                {{ $reception->items->count() }}
            </td>
            <td>
                @if ($reception->items->isNotEmpty())
                    <button wire:click="deleteItems"
                        @class([
                            'btn',
                            'btn-danger',
                            'form-control',
                            'disabled' => $reception->approvals->isNotEmpty(),
                        ])>
                        Eliminar items
                    </button>
                @endif
            </td>
        </tr>

        <tr>
            <th>Aprobaciones</th>
            <td>
                @if ($reception->rejected)
                    <span class="badge bg-danger">Rechazada</span>
                @else
                    @foreach ($reception->approvals as $approval)
                        <span style="width=50px;"
                            @class([
                                'd-inline-bloc',
                                'img-thumbnail',
                                'rounded-circle',
                                'bg-success' => $approval->status,
                                'text-white' => $approval->status,
                                'border-dark',
                            ])
                            tabindex="0"
                            data-toggle="tooltip"
                            title="Fecha: ">
                            <small>
                                @if ($approval->approver)
                                    {{ $approval->approver->initials }}
                                @elseif($approval->sentToOu)
                                    {{ $approval->sentToOu->currentManager?->user->initials }}
                                @elseif($approval->sentToUser)
                                    {{ $approval->sentToUser->initials }}
                                @endif
                            </small>
                        </span> &nbsp;
                    @endforeach
                @endif
            </td>
            <td>
                @if ($reception->approvals->isNotEmpty())
                    <button wire:click="deleteApprovals"
                        @class([
                            'btn',
                            'btn-danger',
                            'form-control',
                            'disabled' => $reception->numeration,
                        ])>
                        Eliminar Aprobaciones
                    </button>
                @endif
            </td>
        </tr>

        <tr>
            <th>Número</th>
            <td>
                @if ($reception->rejected == false)
                    @if ($reception->numeration and $reception->numeration->number)
                        <a class="btn btn-outline-danger"
                            href="{{ route('documents.partes.numeration.show_numerated', $reception->numeration) }}"
                            target="_blank">
                            <i class="bi bi-file-pdf"></i> {{ $reception->numeration->number }}
                        </a>
                    @endif
                @endif
            </td>
            <td>
                @if ($reception->numeration)
                    <button class="btn btn-danger form-control"
                        wire:click="deleteNumber">
                        Eliminar número
                    </button>
                @endif
            </td>
        </tr>

    </table>



    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>OC</th>
                <th>Proveedor</th>
                <th>Items</th>
                <th>Total</th>
                <th>Responsable</th>
                <th>Orig.</th>
                <th>Adjuntos</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td nowrap>
                    {{ $reception->purchase_order }}
                </td>
                <td>
                    @if ($reception->purchaseOrder)
                        {{ $reception->purchaseOrder?->json->Listado[0]->Proveedor->Nombre }}
                    @else
                        {{ $reception->dte?->razon_social_emisor }}
                    @endif
                </td>
                <td class="text-center">
                    {{ $reception->items->count() }}
                </td>
                <td class="text-end" nowrap>
                    $ {{ money($reception->total) }}
                </td>
                <td>
                    {{ $reception->responsable?->shortName }}
                </td>

                <td>
                    @if ($reception->rejected == false)
                        @if ($reception->signedFileLegacy )
                            <a href="{{ route('file.download', $reception->signedFileLegacy) }}"
                                class="btn btn-outline-secondary"
                                target="_blank">
                                <i class="bi bi-file-pdf-fill"></i>
                            </a>
                        @else
                            <a href="{{ route('finance.receptions.show', $reception->id) }}"
                                class="btn btn-outline-success"
                                target="_blank">
                                <i class="bi bi-file-pdf-fill"></i>
                            </a>
                        @endif
                    @endif
                </td>
                <td>
                    @if ($reception->supportFile )
                        <a href="{{ route('file.download', $reception->supportFile) }}"
                            target="_blank">
                            <i class="fas fa-paperclip"></i>
                        </a>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
