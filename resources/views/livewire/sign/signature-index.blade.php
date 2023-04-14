<div>
    <h3>
        Solicitudes de firmas y distribución
    </h3>

    <div class="row my-2">
        <div class="col-2">
            <label for="document-type">Filtrar por</label>
            <select
                class="form-control"
                id="document-type"
                wire:model="filterBy"
            >
                <option value="all">Todas</option>
                <option value="pending">Pendientes</option>
                <option value="signed">Firmadas</option>
                <option value="rejected">Rechazadas</option>
            </select>
        </div>
        <div class="col">
            <label for="search">Buscar</label>
            <input
                type="text"
                class="form-control"
                id="search"
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
                    <th>Firmante</th>
                    <th>Materia</th>
                    <th>Descripcion</th>
                    <th>Creador</th>
                    <th>Estado</th>
                    <th nowrap>Firmas</th>
                    <th>Ver</th>
                    <th>Anexos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($signatureFlows as $signatureFlow)
                    <tr>
                        <td class="text-center">{{ $signatureFlow->id }}</td>
                        <td class="text-center">
                            {{ $signatureFlow->signature->document_number->format('Y-m-d') }}
                        </td>
                        <td>
                            <b>{{ $signatureFlow->signer->tinny_name }}</b>
                            <br>
                            <small>
                                @if($signatureFlow->signature->flows->firstWhere('signer_id', auth()->id())->column_position == 'left')
                                    {{ $signatureFlow->signature->column_left_visator == true ? 'Visador' : 'Firmante' }}
                                @endif
                                @if($signatureFlow->signature->flows->firstWhere('signer_id', auth()->id())->column_position == 'center')
                                    {{ $signatureFlow->signature->column_center_visator == true ? 'Visador' : 'Firmante' }}
                                @endif
                                @if($signatureFlow->signature->flows->firstWhere('signer_id', auth()->id())->column_position == 'right')
                                    {{ $signatureFlow->signature->column_right_visator == true ? 'Visador' : 'Firmante' }}
                                @endif
                            </small>
                        </td>
                        <td>{{ $signatureFlow->signature->subject }}</td>
                        <td>{{ $signatureFlow->signature->description }}</td>
                        <td>{{ $signatureFlow->signature->user->tinny_name }}</td>
                        <td>{{ $signatureFlow->signature->status }}</td>
                        <td nowrap>
                            @foreach($signatureFlow->signature->firms as $firm)
                            {{-- {{ $firm->signer->initials }} - {{ $firm->signer->tinny_name }} - {{ $firm->row_position }} --}}
                            <span
                                class="d-inline-bloc img-thumbnail border-dark bg-{{ $firm->status_color }} text-{{ $firm->status_color_text }} text-monospace rounded-circle"
                                tabindex="0"
                                data-toggle="tooltip"
                                title=""
                            >{{ substr($firm->signer->initials, 0, 2) }}</span>&nbsp;
                            @endforeach
                        </td>
                        <td>
                            <a
                                href="{{ $signatureFlow->signature->link }}"
                                class="btn btn-primary btn-sm"
                                title="Ver Documento"
                                target="_blank"
                            >
                                <span class="fas fa-fw fa-file" aria-hidden="true"></span>
                            </a>
                        </td>
                        <td>
                        </td>
                        <td>
                            <button
                                class="btn btn-sm btn-primary @if(! $signatureFlow->signature->canSign) disabled @endif"
                            >
                                Firmar
                            </button>
                            <br>
                        </td>
                    </tr>
                @empty
                <tr class="text-center">
                    <td colspan="11">
                        <em>No hay registros</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $signatureFlows->links() }}
    </div>
</div>
