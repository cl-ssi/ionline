<?php

namespace App\Http\Livewire\Inventory;

use Livewire\WithFileUploads;
use App\Models\Establishment;
use App\Models\Inv\Inventory;
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

        $path = $this->excelFile->getRealPath();

        $data = collect(Excel::toArray([], $path)[0])
            ->skip(2) // Omitir las primeras dos filas (encabezados)
            ->filter(function ($row) {
                // Filtrar las filas que contienen datos
                return !empty(array_filter($row));
            });

        $inventories = [];

        $msg = "";
        foreach ($data as $key => $row) {

            //verificar que los usuarios del excel sean válidos.
            if(!$row[10]){
                $msg .= "El usuario de la fila " .  ($key+1) . " no se ha ingresado. Favor verificar \n";
                continue;
            }else{
                $user_using = User::where('id',$row[10])->first();
                if(!$user_using){
                    $msg .= "El usuario de la fila " .  ($key+1) . " no se ha encontrado. Favor verificar \n";
                    continue;
                }
            }
            //verificar que los responsables del excel sean válidos.
            if(!$row[11]){
                $msg .= "El usuario de la fila " .  ($key+1) . " no se ha ingresado. Favor verificar \n";
                continue;
            }else{
                $user_responsible = User::where('id',$row[11])->first();
                if($user_responsible->count()==0){
                    $msg .= "El responsable de la fila " .  ($key+1) . " no se ha encontrado. Favor verificar \n";
                    continue;
                }
            }
            //verificar que los unspsc_product_id del excel sean válidos.
            if(!$row[2]){
                $msg .= "El unspsc product_id de la fila " .  ($key+1) . " no se ha ingresado. Favor verificar \n";
                continue;
            }else{
                $unspsc_product = Product::where('code',$row[2])->first();
                if($unspsc_product){
                    $msg .= "El id de producto de la fila " . ($key+1) . " no se ha encontrado. Favor verificar \n";
                    continue;
                }
            }

            // $inventories[] = [
            //     'establishment_id' => $this->establishment->id,
            //     'request_user_ou_id' => Auth::user()->organizationalUnit->id,
            //     'request_user_id' => Auth::user()->id,
            //     'number' => $row[0],
            //     'description' => $row[1],
            //     'unspsc_product_id' => $unspsc_product->id,
            //     'brand' => $row[3],
            //     'model' => $row[4],
            //     'serial_number' => $row[5],
            //     'useful_life' => $row[6],
            //     'po_code' => $row[7],
            //     'status' => $row[8], //switch
            //     'place_id' => 41, //Se deja por defecto, HAH - $row[10], 
            //     'user_using_id' => $user_using->id,
            //     'user_responsible_id' => $user_responsible->id,
            //     'observations' => $row[12],
            //     'po_price' => $row[13],
            //     'accounting_code_id' => $row[14],
            //     'dte_number' => $row[15]
            // ];
        }

        // Inventory::insert($inventories);

        // Limpiar la propiedad del archivo después de procesarlo
        $this->excelFile = null;

        session()->flash('message', 'El archivo Excel se cargó exitosamente.');
        session()->flash('message', 'El archivo Excel se cargó exitosamente.');
        if($msg!=""){
            session()->flash('warning', $msg);
        }
    }


    public function render()
    {
        return view('livewire.inventory.inventory-upload-excel');
    }
}
