<div class="row g-2 mb-4">
    <div class="col-6 col-md-3">
        <label for="responsible">Responsable</label>
        <input type="text"
            wire:model="filter.responsible"
            class="form-control">
    </div>

    <div class="col-6 col-md-3">
        <label for="subject">Asunto</label>
        <input type="text"
            wire:model="filter.subject"
            class="form-control">
    </div>

    <div class="col-6 col-md-2">
        <label for="status">Estado</label>
        <select wire:model="filter.status"
            class="form-select">
            <option value=""></option>
            <option value="1">Terminado</option>
            <option value="0">Pendiente</option>
        </select>
    </div>

    <div class="col-1">
        <label for="buscar">&nbsp</label>
        <button class="btn btn-primary form-control"
            wire:click="search">
            <i class="bi bi-search"></i>
        </button>
    </div>
</div>

<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Solicitante</th>
            <th>Asunto</th>
            <th width="40%">Compromisos</th>
            <th width="130px"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($meetings as $meeting)
            <tr @class(['table-success' => $meeting->status])>
                <td>{{ $meeting->date }}</td>
                <td>
                    {{ $meeting->petitioner }}<br>
                    <small><b>Responsable</b>: 
                    {{ $meeting->responsible->shortName }}</small>
                </td>
                </td>
                <td>{{ $meeting->subject }}</td>
                <td>
                    @foreach ($meeting->compromises as $compromise)
                        <li>
                            <i class="{{ $compromise->statusIcon }}"></i>
                            {{ $compromise->name }} -
                            {{ $compromise->date?->format('Y-m-d') }}
                        </li>
                    @endforeach
                </td>
                <td>
                    <a class="btn btn-sm btn-outline-primary"
                        target="_blank"
                        href="{{ route('documents.lobby.show', $meeting) }}">
                        <i class="bi bi-file-earmark"></i>
                    </a>
                    <button type="button"
                        class="btn btn-sm btn-primary"
                        wire:click="form({{ $meeting }})">
                        <i class="bi bi-pencil-square"></i></button>
                    <button type="button"
                        class="btn btn-sm btn-danger"
                        onclick="confirm('¿Está seguro que desea borrar la reunión {{ $meeting->subject }}?') || event.stopImmediatePropagation()"
                        wire:click="delete({{ $meeting }})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
