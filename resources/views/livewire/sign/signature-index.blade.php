<div>
    <h3>
        Solicitudes de firmas y distribución
    </h3>

    <div class="row my-2">
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
                    <th class="text-center">Fecha Solicitud</th>
                    <th nowrap>Nro</th>
                    <th>Materia</th>
                    <th>Descripción</th>
                    <th class="text-center">Firmas</th>
                    <th class="text-center">Creador</th>
                    <th class="text-center">Firmar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($signatures as $signature)
                    <tr>
                        <td class="text-center">
                            {{ $signature->id }}
                        </td>
                        <td class="text-center">
                            {{ $signature->document_number->format('Y-m-d') }}
                        </td>
                        <td>
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
                        <td  style="padding: 0 !important; margin: 0 !important;">
                            <table class="table table-sm small table-signature" style="margin: 0 !important; padding: 0 !important;">
                                <tbody>
                                    <tr>
                                        <td class="text-center" width="33%" style="height: 100%">
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
                                        <td class="text-center" width="33%">
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
                                        <td class="text-center" width="33%">
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
                            @if($signature->isPending())
                                @livewire('sign.sign-document', [
                                    'signatureId' => $signature->id,
                                    'link' => $signature->link,
                                    'folder' => 'ionline/sign/signed/',
                                    'disabled' => (! $signature->canSign or ! $signature->isSignedForMe),
                                    'filename' => $signature->id.'-'.$signature->flows->firstWhere('signer_id', auth()->id())->id,
                                    'user' => auth()->user(),
                                    'x' => $signature->flows->firstWhere('signer_id', auth()->id())->x,
                                    'y' => $signature->flows->firstWhere('signer_id', auth()->id())->y,
                                    'route' => 'v2.documents.signatures.update',
                                    'routeParams' => [
                                        'signature' => $signature->id,
                                        'user' => auth()->id(),
                                        'filename' => $signature->id.'-'.$signature->flows->firstWhere('signer_id', auth()->id())->id.'.pdf'
                                    ]
                                ], key($signature->id))
                            @endif
                        </td>
                    </tr>
                @empty
                <tr class="text-center">
                    <td colspan="8">
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
    </style>
@endsection
