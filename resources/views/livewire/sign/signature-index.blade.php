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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Fecha Solicitud</th>
                    <th nowrap>Nro</th>
                    <th>Materia</th>
                    <th>Descripción</th>
                    <th>Firmas</th>
                    <th>Anexos</th>
                    <th>Creador</th>
                    <th nowrap>Firmar</th>
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
                        <td nowrap>
                            <span
                                class="d-inline-bloc img-thumbnail border-dark
                                    bg-{{ $signature->status_color }}
                                    text-{{ $signature->status_color_text }}
                                    text-monospace rounded-circle"
                                tabindex="0"
                                data-toggle="tooltip"
                                title="{{ $signature->status_translate }}"
                            >&nbsp;&nbsp;</span>&nbsp;

                            @foreach($signature->signatures as $itemSigner)
                            {{-- {{ $firm->signer->initials }} - {{ $firm->signer->tinny_name }} - {{ $firm->row_position }} --}}
                            <span
                                class="d-inline-bloc img-thumbnail border-dark
                                    bg-{{ $itemSigner->status_color }}
                                    text-{{ $itemSigner->status_color_text }}
                                    text-monospace rounded-circle"
                                tabindex="0"
                                data-toggle="tooltip"
                                title="{{ $itemSigner->signer->short_name }}"
                            >{{ substr($itemSigner->signer->initials, 0, 2) }}</span>&nbsp;
                            @endforeach
                        </td>
                        <td>
                            Anexos
                        </td>
                        <td class="text-center">
                            <span
                                class="d-inline-bloc img-thumbnail border-dark bg-default text-monospace rounded-circle"
                                tabindex="0"
                                data-toggle="tooltip"
                                title="{{ $signature->user->short_name }}"
                            >{{ substr($signature->user->initials, 0, 2) }}</span>&nbsp;
                            <br>
                            {{-- <small>
                                @if($signature->flows->firstWhere('signer_id', auth()->id())->column_position == 'left')
                                    {{ $signature->column_left_visator == true ? 'Visador' : 'Firmante' }}
                                @endif
                                @if($signature->flows->firstWhere('signer_id', auth()->id())->column_position == 'center')
                                    {{ $signature->column_center_visator == true ? 'Visador' : 'Firmante' }}
                                @endif
                                @if($signature->flows->firstWhere('signer_id', auth()->id())->column_position == 'right')
                                    {{ $signature->column_right_visator == true ? 'Visador' : 'Firmante' }}
                                @endif
                            </small> --}}
                        </td>
                        <td nowrap>
                            @if($signature->isPending())
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm"
                                    data-toggle="modal"
                                    title="Firmar documento"
                                    data-target="#sign-to-id-{{ $signature->id }}"
                                    @if(! $signature->canSign or ! $signature->isSignedForMe) disabled @endif
                                >
                                    <i class="fas fa-signature"></i> Firmar
                                </button>

                                @include('sign.modal-show-document')
                            @endif
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
</div>
