<div>
    <div class="table-responsive">
        <table class="table table-striped table-sm" id="TableFilter">
            <thead>
                <tr>
                    <th scope="col">Inventario</th>
                    <th scope="col">Servicio Clinico</th>
                    <th scope="col">Nombre Equipo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Accion</th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none">
                    <td class="text-center" colspan="8">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($medicalEquipment as $key => $equipment)
                    <tr wire:loading.remove>
                        <td>{{ $equipment->inventory_number }}</td>
                        <td>{{ $equipment->clinical_service }}</td>
                        <td>{{ $equipment->equipment_name }}</td>
                        <td>{{ $equipment->brand }}</td>
                        <td>{{ $equipment->model }}</td>
                        <td>{{ $equipment->serial }}</td>
                        <td>
                            <a class="btn btn-outline-secondary btn-sm"
                                href="{{ route('medical-equipment.edit', $equipment) }}">
                                <span class="fas fa-edit" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="8">
                            <em>
                                No hay registros
                            </em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <caption>
                Total de resultados: {{ $medicalEquipment->total() }}
            </caption>
        </table>
    </div>


</div>
