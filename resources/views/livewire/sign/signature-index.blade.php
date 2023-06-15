<div>
    <h3>
        Solicitudes de firmas y distribución
    </h3>

    <div class="form-row g-1 my-2">
        <div class="col-3">
            <label for="document-type">Filtrar por</label>
            <select
                class="form-control"
                id="document-type"
                wire:model="filterBy"
            >
                <option value="all">Todas</option>
                <option value="pending">Pendientes</option>
                <option value="signedAndRejected">Firmadas y Rechazadas</option>
            </select>
        </div>
        <div class="col">
            <label for="search">Buscar</label>
            <input
                type="text"
                class="form-control"
                id="search"
                wire:model.debounce="search"
                wire:model.debounce.1500ms="search"
                placeholder="Ingresa una materia o una descripción"
            >
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Creador</th>
                    <th class="text-center">Fecha Solicitud</th>
                    <th class="text-center" nowrap>Nro</th>
                    <th>Materia</th>
                    <th>Descripción</th>
                    <th class="text-center">Firmas</th>
                    <th>Anexos</th>
                    <th class="text-center" nowrap>
                        <button
                            data-toggle="modal"
                            title="Firmar multiples"
                            data-target="#sign-multiple"
                            class="btn btn-sm btn-block btn-primary"
                            @if($selectedSignatures->isEmpty()) disabled @endif
                        >
                            <i class="fas fa-signature"></i> Firmar
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($signatures as $index => $signature)
                    <tr>
                        <td class="text-center">
                            {{ $signature->id }}
                        </td>
                        <td class="text-center">
                            <span
                                class="d-inline-bloc img-thumbnail border-dark bg-default text-monospace rounded-circle
                                    bg-{{ $signature->status_color }}
                                    text-{{ $signature->status_color_text }}"
                                tabindex="0"
                                data-toggle="tooltip"
                                title="{{ $signature->user->short_name }}"
                            >{{ $signature->user->twoInitials }}</span>&nbsp;
                        </td>
                        <td class="text-center">
                            {{ $signature->document_number->format('Y-m-d') }}
                        </td>
                        <td class="text-center" nowrap>
                            @if($signature->isCompleted() && ! $signature->isEnumerate())
                                @livewire('sign.enumerate-signature', [
                                    'signature' => $signature
                                ])
                            @endif

                            @if ($signature->isEnumerate() && $signature->isCompleted())
                                {{ $signature->number }}
                            @endif
                        </td>
                        <td>
                            {{ $signature->subject }}
                        </td>
                        <td>
                            {{ $signature->description }}
                        </td>
                        <td style="padding: 0 !important; margin: 0 !important;">
                            <table class="table table-sm small table-signature" style="margin: 0 !important; padding: 0 !important">
                                <tbody style="border: none">
                                    <tr>
                                        <td class="text-center" width="33%" style="height: 100%; border: 1px solid white">
                                            @foreach($signature->leftSignatures as $itemSigner)
                                                <span
                                                    class="img-thumbnail border-dark
                                                        {{ $signature->leftBorderEndorse }}
                                                        {{ $signature->leftVisatorClass }}
                                                        bg-{{ $itemSigner->status_color }}
                                                        text-{{ $itemSigner->status_color_text }}
                                                        text-monospace rounded-circle"
                                                    tabindex="0"
                                                    data-toggle="tooltip"
                                                    title="{{ $itemSigner->signer->short_name }}"
                                                >{{ $itemSigner->signer->twoInitials }}</span>
                                                <div class="my-2"></div>
                                            @endforeach
                                        </td>
                                        <td class="text-center" width="33%" style="border: 1px solid white">
                                            @foreach($signature->centerSignatures as $itemSigner)
                                                <span
                                                    class="img-thumbnail border-dark
                                                        {{ $signature->centerBorderEndorse }}
                                                        {{ $signature->centerVisatorClass }}
                                                        bg-{{ $itemSigner->status_color }}
                                                        text-{{ $itemSigner->status_color_text }}
                                                        text-monospace rounded-circle"
                                                    tabindex="0"
                                                    data-toggle="tooltip"
                                                    title="{{ $itemSigner->signer->short_name }}"
                                                >{{ $itemSigner->signer->twoInitials }}</span>
                                                <div class="my-2"></div>
                                            @endforeach
                                        </td>
                                        <td class="text-center" width="33%" style="border: 1px solid white">
                                            @foreach($signature->rightSignatures as $itemSigner)
                                                <span
                                                    class="img-thumbnail border-dark
                                                        {{ $signature->rightBorderEndorse }}
                                                        {{ $signature->rightVisatorClass }}
                                                        bg-{{ $itemSigner->status_color }}
                                                        text-{{ $itemSigner->status_color_text }}
                                                        text-monospace rounded-circle"
                                                    tabindex="0"
                                                    data-toggle="tooltip"
                                                    title="{{ $itemSigner->signer->short_name }}"
                                                >{{ $itemSigner->signer->twoInitials }}</span>
                                                <div class="my-2"></div>
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <th>
                            @foreach($signature->annexes as $annex)
                                @if($annex->isLink())
                                    <a class="annex" href="{{ $annex->url }}" target="_blank">
                                        <i class="fas fa-link" title="Enlace"></i>&nbsp
                                    </a>
                                @endif
                                @if($annex->isFile())
                                    <a class="annex" href="{{ $annex->link_file }}" target="_blank">
                                        <i class="fas fa-paperclip" title="Archivo"></i>&nbsp
                                    </a>
                                @endif
                            @endforeach
                        </th>
                        <td nowrap>
                            <div class="form-row text-center">
                                <div class="col-2 text-center">
                                    @if($signature->isPending() AND ! $signature->isRejected() AND $signature->isSignedForMe)
                                        <input
                                            type="checkbox"
                                            wire:click='updateSelected({{ $signature->id }})'
                                        >
                                    @endif
                                </div>
                                <div class="col-8 text-center">
                                    @if($signature->isCompleted())
                                        <a
                                            class="btn btn-sm btn-primary"
                                            title="Ver documento"
                                            target="_blank"
                                            class="btn @if($signature->isEnumerate()) btn-success @else btn-primary @endif"
                                            href="{{ route('v2.documents.show.signed.file', $signature) }}"
                                        >
                                            <i class="fas fa-file"></i>
                                        </a>
                                    @endif

                                    @if($signature->isPending())
                                        @livewire('sign.sign-document', [
                                            'signatureId' => $signature->id,
                                            'link' => $signature->link_signed_file,
                                            'folder' => 'ionline/sign/signed/',
                                            'disabled' => (! $signature->canSignature),
                                            'filename' => $signature->id.'-'.$signature->flows->firstWhere('signer_id', auth()->id())->id,
                                            'user' => auth()->user(),
                                            'row' => $signature->flows->firstWhere('signer_id', auth()->id())->row_position + 1,
                                            'column' => $signature->flows->firstWhere('signer_id', auth()->id())->column_position,
                                            'route' => 'v2.documents.signatures.update',
                                            'routeParams' => [
                                                'signature' => $signature->id,
                                                'user' => auth()->id(),
                                                'filename' => $signature->id.'-'.$signature->flows->firstWhere('signer_id', auth()->id())->id.'.pdf'
                                                ]
                                            ]
                                        , key($signature->id))
                                    @endif

                                    @if($signature->isPending() AND $signature->isSignedForMe)
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            data-toggle="modal"
                                            title="Rechazar documento"
                                            data-target="#rejected-signature-to-{{ $signature->id }}"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>

                                        @include('sign.modal-rejected-signature')
                                    @endif

                                    @if($signature->isAuthCreator() AND $signature->isPending())
                                        <button
                                            class="btn btn-sm btn-danger"
                                            data-toggle="modal"
                                            title="Eliminar solicitud"
                                            wire:click="deleteRequestSignature({{ $signature }})"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                <tr class="text-center">
                    <td colspan="9">
                        <em>No hay registros</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col">
            {{ $signatures->links() }}
        </div>
        <div class="col text-right">
            Total de Registros: {{ $signatures->total() }}
        </div>
    </div>

    @include('sign.modal-multiple-signature')

</div>

@section('custom_css')
    <style type="text/css">
        .border-en-cadena {
            border: 2px solid black !important;
            border-style: solid !important;
        }

        .border-sin-cadena {
            border: 2px solid black !important;
            border-style: dashed !important;
        }

        .border-opcional {
            border: 2px solid black !important;
            border-style: dotted !important;
        }

        .table-signature td {
            border-bottom: none;
            border-top: none;
        }

        .annex:hover{
            text-decoration: none;
        }
    </style>
@endsection
