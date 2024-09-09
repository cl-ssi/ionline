<?php

namespace App\Livewire\Inventory;

use App\Http\Requests\Inventory\UpdateInventoryRequest;
use App\Models\Establishment;
use App\Models\Finance\AccountingCode;
use App\Models\Inv\Inventory;
use App\Models\Inv\Classification;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class InventoryEdit extends Component
{
    public $inventory;
    public $establishment;
    public $accountingCodes;
    public $internal_description;

    public $old_number;
    public $number_inventory;
    public $status;
    public $classification_id;
    public $brand;
    public $model;
    public $serial_number;
    public $useful_life;
    public $depreciation;
    public $accounting_code_id;
    public $observations;
    public $sameProductItems;
    public $classifications;

    public $oldItemInventory;
    public $data_preview;

    public $observation_delete;

    public $po_code;

    public function render()
    {
        return view('livewire.inventory.inventory-edit');
    }

    public function mount(Inventory $inventory, Establishment $establishment)
    {
        $this->inventory = $inventory;
        $this->establishment = $establishment;

        /**
         * The establishment is not the same as the establishment of the inventory item, aborts a 404
         */
        if($this->inventory->establishment_id != $this->establishment->id) {
            abort(404);
        }

        $this->number_inventory = $this->inventory->number;
        $this->useful_life = $this->inventory->useful_life;
        $this->status = ($this->inventory->status === null) ? '1' : $this->inventory->status;
        $this->depreciation = $this->inventory->depreciation;
        $this->brand = $this->inventory->brand;
        $this->model = $this->inventory->model;
        $this->serial_number = $this->inventory->serial_number;
        $this->observations = $this->inventory->observations;
        $this->accounting_code_id = $this->inventory->accounting_code_id;
        $this->classification_id = $this->inventory->classification_id;
        $this->internal_description = $inventory->internal_description ?? $inventory->description;
        $this->old_number = $inventory->old_number;
        $this->po_code = $this->inventory->po_code;

        $this->accountingCodes = AccountingCode::all();
        $this->classifications = CLassification::where('establishment_id',$this->establishment->id)->orderBy('name')->get();

        /**
         * Obtiene todos los productos que sean del mismo codigo onu
         */
        $this->sameProductItems = Inventory::where('establishment_id', $establishment->id)
            ->with(['responsible','place','product'])
            ->where('unspsc_product_id', $this->inventory->unspsc_product_id)
            ->get();

    }

    public function rules()
    {
        return (new UpdateInventoryRequest($this->inventory))->rules();
    }

    /**
     * Generate Code
     */
    public function generateCode()
    {
        if($this->inventory->unspscProduct)
        {
            $this->number_inventory = $this->inventory->unspscProduct->code . '-' . $this->inventory->id;
        }
    }

    public function searchFusion()
    {
        $this->oldItemInventory = Inventory::query()
            ->whereNumber($this->number_inventory)
            ->where('id', '!=', $this->inventory->id)
            ->first();

        $sameEstablishment = isset($this->oldItemInventory) ? ($this->oldItemInventory->establishment_id == $this->inventory->establishment_id) : false;
        $sameProduct = isset($this->oldItemInventory) ? ($this->oldItemInventory->unspsc_product_id == $this->inventory->unspsc_product_id) : false;

        if(isset($this->oldItemInventory) && $sameEstablishment && $sameProduct)
        {
            $this->brand = isset($this->oldItemInventory->brand) ? $this->oldItemInventory->brand : $this->inventory->brand;
            $this->model = isset($this->oldItemInventory->model) ? $this->oldItemInventory->model : $this->inventory->model;
            $this->serial_number = $this->oldItemInventory->serial_number;

            $this->data_preview['request_form'] = isset($this->oldItemInventory->requestForm) ? $this->oldItemInventory->requestForm : $this->inventory->requestForm;
            $this->data_preview['purchase_order'] = isset($this->oldItemInventory->purchaseOrder) ? $this->oldItemInventory->purchaseOrder : $this->inventory->purchaseOrder;
            $this->data_preview['control'] = isset($this->oldItemInventory->control) ? $this->oldItemInventory->control : $this->inventory->control;
            $this->data_preview['control']['store'] = isset($this->oldItemInventory->control) ? $this->oldItemInventory->control->store : null;
            $this->data_preview['control']['isConfirmed'] = isset($this->oldItemInventory->control) ? $this->oldItemInventory->control->isConfirmed() : false;

            $this->dispatch('updateDataPreview', data_preview: $this->data_preview);
        }
        else
        {
            $this->oldItemInventory = null;
        }
    }

    public function update()
    {
        /**
         * If oldItemInventory is set or Inventory fusion
         */
        if(isset($this->oldItemInventory))
        {
            /**
             * Fusion of the new item with the old
             */
            $dataFusion['useful_life'] = isset($this->oldItemInventory->useful_life) ? $this->oldItemInventory->useful_life : $this->inventory->useful_life;
            $dataFusion['brand'] = isset($this->oldItemInventory->brand) ? $this->oldItemInventory->brand : $this->inventory->brand;
            $dataFusion['model'] = isset($this->oldItemInventory->model) ? $this->oldItemInventory->model : $this->inventory->model;
            $dataFusion['old_number'] = $this->inventory->old_number;

            $this->oldItemInventory->update($dataFusion);

            /**
             * Delete the new item
             */
            $this->inventory->delete();

            /**
             * Show message & redirect
             */
            session()->flash('success',  'El item del inventario fue fusionado exitosamente.');
            return redirect()->route('inventories.pending-inventory', $this->oldItemInventory->establishment);
        }
        else
        {
            /**
             * Update the inventory
             */
            $dataValidated = $this->validate();
            $dataValidated['number'] = $dataValidated['number_inventory'];
            $dataValidated['internal_description'] = $this->internal_description; ;
            $dataValidated['po_code'] = $this->po_code;
            $dataValidated['old_number'] = $this->old_number;
            $this->inventory->update($dataValidated);

            /**
             * Show message
             */
            session()->flash('success', 'El item del inventario fue editado exitosamente.');
            return;
        }
    }

    public function deleteItemInventory()
    {
        /**
         * Validate the inputs
         */
        $validator = Validator::make([
            'observation_delete' => $this->observation_delete,
        ], [
            'observation_delete' => 'required|string|min:2|max:250',
        ]);

        if($validator->fails())
        {
            session()->flash('danger', 'Debe ingresar la observación para eliminar');
            return;
        }

        /**
         * Update the inventory
         */
        $this->inventory->update([
            'number' => null,
            'observation_delete' => $this->observation_delete,
            'user_delete_id' => auth()->id(),
        ]);


        $this->inventory->movements()->delete();
        $this->inventory->delete();

        session()->flash('success', 'El item del inventario fue eliminado definitivamente.');
        return redirect()->route('inventories.index', $this->inventory->establishment);
    }

    public function unInventory()
    {
        /**
         * Eliminate inventory movements
         */
        foreach($this->inventory->movements as $movement)
        {
            $movement->delete();
        }

        /**
         * Update inventory
         */
        $this->inventory->update([
            'old_number' => $this->inventory->number
        ]);

        /**
         * Set the number to null
         */
        $this->inventory->update([
            'number' => null,
        ]);

        session()->flash('success', 'El item del inventario fue desinventariado.');

        return redirect()->route('inventories.index', $this->inventory->establishment);
    }
}
