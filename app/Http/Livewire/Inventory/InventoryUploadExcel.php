<?php

namespace App\Http\Livewire\Inventory;

use Livewire\WithFileUploads;
use App\Models\Establishment;
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryMovement;
use App\Models\Parameters\Place;
use App\Models\Unspsc\Product;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\User;

class InventoryUploadExcel extends Component
{

    use WithFileUploads;

    public Establishment $establishment;
    public $excelFile;

    public function processExcel()
    {
        
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls',
        ]);

        //$path = $this->excelFile->path();        

        $data = collect(Excel::toArray([], $this->excelFile->path(),'gcs')[0])
            ->skip(2) // Omitir las primeras dos filas (encabezados)
            ->filter(function ($row) {
                // Filtrar las filas que contienen datos
                return !empty(array_filter($row));
            });

        $inventories = [];

        $msg = "";
        $rows_ok = 0;
        $rows_fail = 0;

        foreach ($data as $key => $row) {

            //verificar que los usuarios del excel sean válidos.
            if(!$row[10]){
                $msg .= "El usuario de la fila " .  ($key+1) . " no se ha ingresado. <br>";$rows_fail+=1;
                continue;
            }else{
                $user_using = User::where('id',$row[10])->first();
                if(!$user_using){
                    $msg .= "El usuario de la fila " .  ($key+1) . " no se ha encontrado. <br>";$rows_fail+=1;
                    continue;
                }
            }
            //verificar que los responsables del excel sean válidos.
            if(!$row[11]){
                $msg .= "El responsable de la fila " .  ($key+1) . " no se ha ingresado. <br>";$rows_fail+=1;
                continue;
            }else{
                $user_responsible = User::where('id',$row[11])->first();
                if(!$user_responsible){
                    $msg .= "El responsable de la fila " .  ($key+1) . " no se ha encontrado. <br>";$rows_fail+=1;
                    continue;
                }
            }
            //verificar que los unspsc_product_id del excel sean válidos.
            if(!$row[2]){
                $msg .= "El unspsc product_id de la fila " .  ($key+1) . " no se ha ingresado. <br>";$rows_fail+=1;
                continue;
            }else{
                $unspsc_product = Product::where('code',$row[2])->first();
                if(!$unspsc_product){
                    $msg .= "El unspsc product_id de la fila " . ($key+1) . " no se ha encontrado. <br>";$rows_fail+=1;
                    continue;
                }
            }
            //verificar que los place_id del excel no sean vacios.
            if(!$row[9]){
                $msg .= "El lugar del producto de la fila " .  ($key+1) . " no se ha ingresado. <br>";$rows_fail+=1;
                continue;
            }else{
                $place = Place::where('id',$row[9])->first();
                if(!$place){
                    $msg .= "El lugar del producto de la fila " . ($key+1) . " no se ha encontrado. <br>";$rows_fail+=1;
                    continue;
                }
            }

            switch ($row[8]) {
                case "MALO": 
                case "Malo": 
                case "malo": 
                    $status = -1;
                    break;
                case "REGULAR":
                case "Regular":
                case "regular":
                    $status = 0;
                    break;
                case "BUENO":
                case "Bueno":
                case "bueno":
                    $status = 1;
                    break;
                default: 
                    $status = 0;
                    break;
            }

            $inventory = Inventory::updateOrCreate([
                'establishment_id' => $this->establishment->id,
                'number' => $row[0]
            ],[
                'establishment_id' => $this->establishment->id,
                'request_user_ou_id' => Auth::user()->organizationalUnit->id,
                'request_user_id' => Auth::user()->id,
                'number' => $row[0],
                'description' => $row[1],
                'unspsc_product_id' => $unspsc_product->id,
                'brand' => $row[3],
                'model' => $row[4],
                'serial_number' => $row[5],
                'useful_life' => $row[6],
                'po_code' => $row[7],
                'status' => $status,
                'place_id' => $place->id, 
                'user_using_id' => $user_using->id,
                'user_responsible_id' => $user_responsible->id,
                'observations' => $row[12],
                'po_price' => $row[13],
                'accounting_code_id' => $row[14],
                'dte_number' => $row[15],
            ]);

            InventoryMovement::updateOrCreate([
                'inventory_id' => $inventory->id,
            ],[
                'reception_confirmation' => 1,
                'reception_date' => ($row[16]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[16]) : null,
                // 'installation_date',
                'observations' => $row[12],
                'inventory_id' => $inventory->id,
                'place_id' => $place->id, 
                'user_responsible_ou_id' => $user_responsible->organizational_unit_id,
                'user_responsible_id' => $user_responsible->id,
                'user_using_ou_id' => $user_using->organizational_unit_id,
                'user_using_id' => $user_using->id
            ]);
            
            $rows_ok += 1;
        }

        // Limpiar la propiedad del archivo después de procesarlo
        $this->excelFile = null;

        if($msg!=""){
            session()->flash('warning', 'El archivo Excel se cargó exitosamente.<br><br>' . $msg);
        }else{
            session()->flash('success', 'El archivo Excel se cargó exitosamente.');
        }
    }


    public function render()
    {
        return view('livewire.inventory.inventory-upload-excel')->extends('layouts.bt4.app');
    }
}
