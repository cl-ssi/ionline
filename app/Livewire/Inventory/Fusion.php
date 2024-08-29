<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryMovement;

class Fusion extends Component
{
    public $input_item_a;
    public $input_item_b;

    public $item_a;
    public $item_b;
    public $fusion;

    public $movements = [];

    protected $rules = [
        'input_item_a' => 'required',
        'input_item_b' => 'required',
    ];

    /**
     * Buscar Inventarios
     */
    public function search()
    {
        $this->validate();
        
        // $item_a = Inventory::find($this->input_item_a);
        // $item_b = Inventory::find($this->input_item_b);
        // $item_a = Inventory::where('number','LIKE','%'.$this->input_item_a.'%')->first();
        // $item_b = Inventory::where('number','LIKE','%'.$this->input_item_b.'%')->first();
        $item_a = Inventory::where('number',$this->input_item_a)->first();
        $item_b = Inventory::where('number',$this->input_item_b)->first();
        $this->item_a = $item_a;
        $this->item_b = $item_b;

        if (!$item_a) {
            $this->addError('input_item_a', 'El id no se encontró en la base de datos.');
        } 
        // else {
        //     $this->item_a = $item_a;
        // }

        if (!$item_b) {
            $this->addError('input_item_b', 'El id no se encontró en la base de datos.');
        } 
        // else {
        //     $this->item_b = $item_b;
        // }

    }

    
    
    /**
     * Fusion
     */
    public function fusion()
    {
        // $this->validate([
        //     'fusion.old_number' => 'required',
        // ]);

        //Fix Debugbar en produccion
        //app('debugbar')->log($this->fusion, $this->movements);

        // obtiene inventario de id (omite el primer caracter (A o B))
        $inventory = Inventory::find(substr($this->fusion['id'], 1));

        // si se seleccionó A, solo se modificarán los campos que contengan B (y viceversa)
        if($this->fusion['id'][0] == "A"){
            // Convierte a minúsculas y compara el primer carácter con 'b'
            $arrayFiltrado = array_filter($this->fusion, function($elemento) {
                return substr($elemento, 0, 1) === 'B';
            });
        }else{
            // Convierte a minúsculas y compara el primer carácter con 'b'
            $arrayFiltrado = array_filter($this->fusion, function($elemento) {
                return substr($elemento, 0, 1) === 'A';
            });
        }

        // Función para quitar siempre el primer carácter de los elementos filtrados del array
        $ArraySinPrimerCaracter = function (&$valor) {
            $valor = substr($valor, 1);
        };

        // Aplicar la función a cada valor del array usando array_walk (obtiene valores a modificar)
        array_walk($arrayFiltrado, $ArraySinPrimerCaracter);

        // se actualizan datos de tabla inv_inventories
        $inventory->update($arrayFiltrado);



        // datos de tabla movimientos
        // se verifica que datos se modificaran: si se selecciona A se modifican solo los de B, y viceversa
        if($this->fusion['id'][0] == "A"){
            $movimientosFiltrado = array_filter($this->movements, function($elemento) {
                return substr($elemento, 0, 1) === 'B';
            });
        }else{
            $movimientosFiltrado = array_filter($this->movements, function($elemento) {
                return substr($elemento, 0, 1) === 'A';
            });
        }
        // se quita primer parámetro
        array_walk($this->movements, $ArraySinPrimerCaracter);
        // se modifica fk
        foreach($this->movements as $movement){
            InventoryMovement::find($movement)->update(['inventory_id' => $inventory->id]);
        }

        // se elimina inventario no seleccionado
        if($this->fusion['id'][0] == "A"){
            $this->item_b->delete();
        }else{
            $this->item_a->delete();
        }

        // session()->flash('message', 'Se han fusionado correctamente los inventarios.');
        return redirect()->route('inventories.edit', ['inventory' => $inventory->id,
                                                      'establishment' => auth()->user()->organizationalUnit->establishment->id])
                                                      ->with('success', 'Se han fusionado correctamente los inventarios.');
        // se actualiza información
        // $this->search();
    }

    

    public function render()
    {
        if($this->fusion != null){
            if($this->fusion['id'][0] == "A"){
                $letra = "A";
                $item = $this->item_a;   
            }else{
                $letra = "B";
                $item = $this->item_b;
            }

            //Sin debugbar en prod
            // app('debugbar')->log($letra, $item);

            $this->fusion['old_number'] =           $letra.$item->old_number;
            $this->fusion['unspsc_product_id'] =    $letra.$item->unspsc_product_id;
            $this->fusion['product_id'] =           $letra.$item->product_id; 
            $this->fusion['description'] =          $letra.$item->description; 
            $this->fusion['internal_description'] = $letra.$item->internal_description;
            $this->fusion['brand'] =                $letra.$item->brand;
            $this->fusion['model'] =                $letra.$item->model;
            $this->fusion['serial_number'] =        $letra.$item->serial_number;
            $this->fusion['accounting_code_id'] =   $letra.$item->accounting_code_id;
            $this->fusion['status'] =               $letra.$item->status;
            $this->fusion['useful_life'] =          $letra.$item->useful_life;
            $this->fusion['depreciation'] =         $letra.$item->depreciation;
            $this->fusion['store_id'] =             $letra.$item->store_id;
            $this->fusion['classification_id'] =    $letra.$item->classification_id;
            $this->fusion['request_form_id'] =      $letra.$item->request_form_id;
            $this->fusion['budget_item_id'] =       $letra.$item->budget_item_id;
            $this->fusion['po_code'] =              $letra.$item->po_code;
            $this->fusion['po_date'] =              $letra.$item->po_date;
            $this->fusion['po_price'] =             $letra.$item->po_price;
            $this->fusion['dte_number'] =           $letra.$item->dte_number;
            $this->fusion['observations'] =         $letra.$item->observations;
            $this->fusion['removed_user_id'] =      $letra.$item->removed_user_id;
            $this->fusion['removed_at'] =           $letra.$item->removed_at;

            // se obtienen movimientos y se les añade el caracter de la selección
            $movements_array = $item->movements->pluck('id')->toArray();
            foreach ($movements_array as $clave => $elemento) {
                $movements_array[$clave] = $letra . $elemento;
            }

            $this->movements = $movements_array;
            
        }
        return view('livewire.inventory.fusion');
    }
}
