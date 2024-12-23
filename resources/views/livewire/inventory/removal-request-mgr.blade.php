<div>
    @include('layouts.bt5.partials.flash_message')
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('inventories.removal-request-mgr') }}">Solicitudes de Baja de Inventario</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" wire:click="showRemoved" href="#">Inventarios Dados de Baja</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" wire:click="showRejected" href="#">Inventarios Rechazados la Baja</a>
        </li>        
    </ul>
    <div class="form-row">
            <div class="col">
                <h3 class="mb-3">Listado de Solicitudes de Baja de Inventario Pendiente</h3>
            </div>
    </div>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Nro. Inventario</th>
                <th>Producto/Especie</th>
                <th>Ubicación</th>
                <th>Lugar</th>
                <th>Responsable</th>
                <th>Fecha y Hora Solicitud de Baja</th>
                <th>Motivo Solicitud de Baja</th>
                @if($showRemoved or $showRejected)
                    @if($showRemoved)
                    <th>Aprobado Baja de Inventario por</th>
                    <th>Fecha y Hora de Baja de Inventario</th>
                    @endif
                    @if($showRejected)
                    <th>Rechazo de Solicitud de Baja de Inventario por</th>
                    <th>Fecha y Hora de Rechazo de Solicitud</th>
                    @endif
                @else
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $inventory)
            <tr>
                <td>
                    <small class="text-monospace">
                        {{ $inventory?->number }}
                        <br>
                        {{ $inventory?->old_number }}
                    </small>
                </td>
                <td>
                        {{ optional($inventory?->unspscProduct)->name }}
                        <br>
                        <small>
                            @if($inventory?->product)
                                {{ $inventory->product->name }}
                            @else
                                {{ $inventory?->description }}
                            @endif
                        </small>
                    </td>
                    <td>
                        @if($inventory->place)
                            {{ optional($inventory->place)->location->name }}
                        @endif
                    </td>
                    <td>
                        {{ optional($inventory->place)->name }}
                    </td>
                    <td>
                        {{ optional($inventory->responsible)->tinyName }}
                    </td>
                    <td>
                        {{ $inventory->removal_request_reason_at }}
                    </td>
                    <td>
                        {{ $inventory->removal_request_reason }}
                    </td>
                    @if($showRemoved or $showRejected)
                        <td>
                            {{ optional($inventory->removedUser)->tinyName }}
                        </td>
                        <td>
                            {{ $inventory->removed_at }}
                        </td>
                    @else
                        <td>
                            <button class="btn btn-success" wire:click="approval({{ $inventory->id }})">
                                <i class="fas fa-thumbs-up"></i>
                                Aprobar
                            </button>
                            <br><br><br>
                            <button class="btn btn-danger" wire:click="reject({{ $inventory->id }})">
                                <i class="fas fa-thumbs-down"></i>
                                Rechazar
                            </button>
                        </td>
                    @endif
            </tr>

            @endforeach
        </tbody>
    </table>

</div>
