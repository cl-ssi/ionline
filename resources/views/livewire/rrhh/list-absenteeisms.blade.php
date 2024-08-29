<div>
    <div class="row mb-3">
        <div class="col">
            <h3 class="">Ausentismos</h1>
        </div>
        <div class="col text-end">
            <a class="btn btn-primary" href="{{ route('rrhh.absenteeisms.create') }}">Crear Ausentismo</a>
            @if($activeTab == 'Todos los ausentismos')
            <button class="btn btn-secondary" wire:click="export">Exportar Datos</button>
            @endif
        </div>
    </div>

    @if (session('exportContent'))
        <div class="mb-3">
            <h4>Formato de archivo de importación de SIRH:</h4>
            <pre>{!! session('exportContent') !!}</pre>
        </div>
    @endif

    <ul class="nav nav-tabs justify-content-center mb-3">
        @canany(['Users: absenteeism user', 'Users: absenteeism admin'])
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'Mis ausentismos' ? 'active' : '' }}"
                    wire:click.prevent="setActiveTab('Mis ausentismos')" href="#">Mis ausentismos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'Ausentismos de mi unidad' ? 'active' : '' }}"
                    wire:click.prevent="setActiveTab('Ausentismos de mi unidad')" href="#">Ausentismos de mi
                    unidad</a>
            </li>
        @endcan
        @can('Users: absenteeism admin')
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'Todos los ausentismos' ? 'active' : '' }}"
                    wire:click.prevent="setActiveTab('Todos los ausentismos')" href="#">Todos los ausentismos</a>
            </li>
        @endcan
    </ul>

    <div class="row g-2 mb-3">
        <div class="col-md-4">
            <label for="tipo_de_ausentismo">Tipo de Ausentismo</label>
            <select wire:model.live="tipo_de_ausentismo" class="form-select">
                <option value="">Todos</option>
                @foreach ($absenteeismTypes as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="tipo_de_ausentismo">Aprobaciones</label>
            <select wire:model.live="con_aprobacion" class="form-select">
                <option value="">Todas</option>
                <option value="con">Con aprobación</option>
                <option value="sin">Sin aprobación</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="approval_status">Estado de aprobación</label>
            <select wire:model.live="approval_status" class="form-select">
                <option value="all">Todas</option>
                <option value="null">Pendiente</option>
                <option value="true">Aprobada</option>
                <option value="false">Rechazada</option>
            </select>
        </div>

    </div>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Rut</th>
                <th>Nombre</th>
                <th>Fecha inicio</th>
                <th>Fecha término</th>
                {{-- <th>Total días</th> --}}
                <th>Tipo de ausentismo</th>
                <th>Aprobación</th>
                @if ($activeTab == 'Todos los ausentismos')
                    <th>Sirh</th>
                @endif
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absenteeisms as $absenteeism)
                <tr>
                    <td>{{ $absenteeism->id }}</td>
                    <td>{{ $absenteeism->rut }}</td>
                    <td>{{ $absenteeism->user ? $absenteeism->user->shortName : $absenteeism->nombre }}</td>
                    <td>{{ $absenteeism->finicio->format('Y-m-d') }}</td>
                    <td>{{ $absenteeism->ftermino->format('Y-m-d') }}</td>
                    {{-- <td>{{ $absenteeism->total_dias_ausentismo }}</td> --}}
                    <td>{{ $absenteeism->tipo_de_ausentismo }}</td>
                    <td>
                        {{ $absenteeism->approval?->statusInWords }}
                    </td>
                    @if ($activeTab == 'Todos los ausentismos')
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="switch_{{ $absenteeism->id }}"
                                    wire:click="updateSirhAt({{ $absenteeism->id }})"
                                    @if ($absenteeism->sirh_at) checked @endif>
                            </div>
                        </td>
                    @endif
                    <td nowrap>
                        @if ($absenteeism->approval)
                            <a class="btn btn-primary btn-sm" target="_blank"
                                href="{{ route('rrhh.absenteeisms.show', $absenteeism) }}"><i class="bi bi-eye"></i>
                            </a>
                        @endif
                        @if ($absenteeism->approval && is_null($absenteeism->approval->status))
                            <button class="btn btn-danger btn-sm"
                                wire:click="deletePendingAbsenteeism({{ $absenteeism->id }})"
                                onclick="confirm('¿Estás seguro de que deseas eliminar este ausentismo? Esta acción no se puede deshacer.') || event.stopImmediatePropagation()">
                                <i class="bi bi-trash"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Mostrar los enlaces de paginación -->
    <div class="mt-3">
        {{ $absenteeisms->links() }}
    </div>
</div>
