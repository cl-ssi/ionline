<?php

namespace App\Http\Livewire\Inventory;

use Livewire\WithFileUploads;
use App\Models\Establishment;
use App\Models\Inv\Inventory;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class InventoryUploadExcel extends Component
{

    use WithFileUploads;

    public $establishment;
    public $excelFile;
    public $showConfirmation = false;

    public function mount(Establishment $establishment)
    {
        //
        $this->establishment = $establishment;
    }

    public function processExcel()
    {
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls',
        ]);

        $path = $this->excelFile->getRealPath();

        $data = collect(Excel::toArray([], $path)[0])
            ->skip(2) // Omitir las primeras dos filas (encabezados)
            ->filter(function ($row) {
                // Filtrar las filas que contienen datos
                return !empty(array_filter($row));
            });

        $inventories = [];

        foreach ($data as $row) {
            $inventories[] = [
                'establishment_id' => $this->establishment->id,
                'number' => $row[1],
                'brand' => $row[4],
            ];
        }

        Inventory::insert($inventories);

        // Limpiar la propiedad del archivo después de procesarlo
        $this->excelFile = null;

        // Mostrar un mensaje de éxito o realizar cualquier otra acción necesaria
        $this->showConfirmation = true;
    }




    public function render()
    {
        return view('livewire.inventory.inventory-upload-excel')->extends('layouts.app');
    }
}
