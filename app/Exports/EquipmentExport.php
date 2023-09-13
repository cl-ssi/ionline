<?php

namespace App\Exports;

use App\Http\Livewire\Inventory\MedicalEquipment\MedicalEquipmentIndex;
use App\Models\Inv\MedicalEquipment as InvMedicalEquipment;
use App\Models\MedicalEquipment;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, ShouldAutoSize};

class EquipmentExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return InvMedicalEquipment::all();
    }

    public function headings(): array
    {
        return [
            "ID", "Servicio Clinico", "Recinto", "Clase", "Subclase", "Nombre Equipo", "Marca", "Modelo", "Serial", "Numero Inventario", "Año Adquisición", "Vida Util", "Vida Util Remanante", "Dueño", "Estado", "Nivel", "Bajo Garantia", "Año Vencimiento Garantia"
        ];
    }

    public function map($equipment): array
    {
        return [
            $equipment->id,
            $equipment->clinical_service,
            $equipment->precint,
            $equipment->class,
            $equipment->subclass,
            $equipment->equipment_name,
            $equipment->brand,
            $equipment->model,
            $equipment->serial,
            $equipment->inventory_number,
            $equipment->adquisition_year,
            $equipment->lifespan,
            $equipment->remaining_lifespan,
            $equipment->ownership,
            $equipment->state,
            $equipment->level,
            $equipment->under_warranty,
            $equipment->warranty_expiration_year,
        ];
    }
}
