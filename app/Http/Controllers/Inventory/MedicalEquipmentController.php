<?php

namespace App\Http\Controllers\Inventory;

use App\Exports\EquipmentExport;
use App\Http\Controllers\Controller;
use App\Models\Inv\MedicalEquipment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MedicalEquipmentController extends Controller
{
    public function create()
    {
        return view('inventory.medical-equipment.create');
    }

    public function store(Request $request)
    {
        $clinical_service = $request->clinical_service;
        $precint = $request->precint;
        $class = $request->class;
        $subclass = $request->subclass;
        $equipment_name = $request->equipmentName;
        $brand = $request->brand;
        $model = $request->model;
        $serial = $request->serial;
        $inventory_number = $request->inventoryNumber;
        $adquisition_year = $request->adquisition_year;
        $lifespan = $request->lifespan;
        $remaining_lifespan = $request->remaining_lifespan;
        $ownership = $request->ownership;
        $state = $request->state;
        $level = $request->level;
        $under_warranty = $request->under_warranty;
        $warranty_expiration_year = $request->warranty_expiration_year;

        $medical_equipment = new MedicalEquipment();
        $medical_equipment->clinical_service = $clinical_service;
        $medical_equipment->precint = $precint;
        $medical_equipment->class = $class;
        $medical_equipment->subclass = $subclass;
        $medical_equipment->equipment_name = $equipment_name;
        $medical_equipment->brand = $brand;
        $medical_equipment->model = $model;
        $medical_equipment->serial = $serial;
        $medical_equipment->inventory_number = $inventory_number;
        $medical_equipment->adquisition_year = $adquisition_year;
        $medical_equipment->lifespan = $lifespan;
        $medical_equipment->remaining_lifespan = $remaining_lifespan;
        $medical_equipment->ownership = $ownership;
        $medical_equipment->state = $state;
        $medical_equipment->level = $level;
        $medical_equipment->under_warranty = $under_warranty;
        $medical_equipment->warranty_expiration_year = $warranty_expiration_year;

        $medical_equipment->save();
        return redirect()->route('medical-equipment.index')->with('info', 'El equipo medico ' . $medical_equipment->equipment_name . ' ha sido creado.');
    }

    public function index(Request $request)
    {
        $equipment = MedicalEquipment::all();

        return view('inventory.medical-equipment.index', compact('equipment'));
    }

    public function edit(MedicalEquipment $equipment)
    {
        return view('inventory.medical-equipment.edit', compact('equipment'));
    }

    public function update(Request $request)
    {
        $clinical_service = $request->clinical_service;
        $precint = $request->precint;
        $class = $request->class;
        $subclass = $request->subclass;
        $equipment_name = $request->equipmentName;
        $brand = $request->brand;
        $model = $request->model;
        $serial = $request->serial;
        $inventory_number = $request->inventoryNumber;
        $adquisition_year = $request->adquisition_year;
        $lifespan = $request->lifespan;
        $remaining_lifespan = $request->remaining_lifespan;
        $ownership = $request->ownership;
        $state = $request->state;
        $level = $request->level;
        $under_warranty = $request->under_warranty;
        $warranty_expiration_year = $request->warranty_expiration_year;

        $medical_equipment = new MedicalEquipment();
        $medical_equipment->clinical_service = $clinical_service;
        $medical_equipment->precint = $precint;
        $medical_equipment->class = $class;
        $medical_equipment->subclass = $subclass;
        $medical_equipment->equipment_name = $equipment_name;
        $medical_equipment->brand = $brand;
        $medical_equipment->model = $model;
        $medical_equipment->serial = $serial;
        $medical_equipment->inventory_number = $inventory_number;
        $medical_equipment->adquisition_year = $adquisition_year;
        $medical_equipment->lifespan = $lifespan;
        $medical_equipment->remaining_lifespan = $remaining_lifespan;
        $medical_equipment->ownership = $ownership;
        $medical_equipment->state = $state;
        $medical_equipment->level = $level;
        $medical_equipment->under_warranty = $under_warranty;
        $medical_equipment->warranty_expiration_year = $warranty_expiration_year;

        $medical_equipment->save();
        return redirect()->route('medical-equipment.index')->with('info', 'El equipo medico ' . $medical_equipment->equipment_name . ' ha sido actualizado.');
    }

    public function destroy(MedicalEquipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('medical-equipment.index')->with('success', 'El equipo medico ' . $equipment->brand . ' ha sido eliminado');
    }

    public function export()
    {
        return Excel::download(new EquipmentExport, 'equipo-listado.xlsx');
    }
}
