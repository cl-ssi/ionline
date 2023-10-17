<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Requests\Inventory\RegisterInventoryRequest;
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryMovement;
use App\Models\WebService\MercadoPublico;
use App\Services\PurchaseOrderService;
use App\User;
use App\Notifications\InventoryNewItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RegisterInventory extends Component
{
    public $search_product;
    public $type;
    public $description;
    public $number_inventory;
    public $brand;
    public $model;
    public $serial_number;
    public $status;
    public $observations;
    public $unspsc_product_id;
    public $user_responsible_id;
    public $user_using_id;
    public $place_id;

    public $po_search;
    public $po_id;
    public $po_code;
    public $po_date;
    public $po_price;
    public $request_form_id;
    public $request_form;
    public $deliver_date;
    public $useful_life;

    public $error;
    public $msg;
    public $collapse;

    protected $listeners = [
        'myUserUsingId',
        'myUserResponsibleId',
        'myPlaceId',
        'myProductId',
    ];

    public function mount()
    {
        $this->collapse = false;
        $this->status = 1;
        $this->po_code = null;
        if (Auth::user()->can('Inventory: manager'))
        {
            $this->type = 4;
            $this->user_using_id = null;
            $this->user_responsible_id = null;
        }
        else
        {
            $this->type = 1;
            $this->user_using_id = Auth::id();
            $this->user_responsible_id = null;
        }
    }

    public function rules()
    {
        return (new RegisterInventoryRequest())->rules();
    }

    public function render()
    {
        return view('livewire.inventory.register-inventory')->extends('layouts.bt4.app');
    }

    public function updatedSearchProduct()
    {
        $this->emit('searchProduct', $this->search_product);
    }

    public function updatedType($type)
    {
        switch ($type)
        {
			/** Soy Usuario */
            case 1:
                $this->user_using_id = Auth::id();
                $this->user_responsible_id = null;
                break;
			/** Soy Responsable */
			case 2:
                $this->user_responsible_id = Auth::id();
                $this->user_using_id = null;
                break;
            /** Soy usuario y responsable */
            case 3:
                $this->user_using_id = Auth::id();
                $this->user_responsible_id = Auth::id();
                break;

            case 4:
                $this->user_using_id = null;
                $this->user_responsible_id = null;
                break;
        }
    }

    public function myUserUsingId($value)
    {
        $this->user_using_id = $value;
    }

    public function myUserResponsibleId($value)
    {
        $this->user_responsible_id = $value;
    }

    public function myPlaceId($value)
    {
        $this->place_id = $value;
    }

    public function myProductId($value)
    {
        $this->unspsc_product_id = $value;
    }

    public function getReceptionConfirmation()
    {
		/** Si es responsable o (usuario y responsable) */
        if($this->type == 2 || $this->type == 3)
			$reception_confirmation = true;
        else
            $reception_confirmation = false;

        return $reception_confirmation;
    }

    public function getPurchaseOrder()
    {
        $this->error = false;
        $this->validate([
            'po_search' => 'required'
        ]);

        try {
            $purchaseOrder = MercadoPublico::getPurchaseOrder($this->po_search);
        } catch (\Throwable $th) {
            $this->error = true;
            $this->msg = $th->getMessage();
        }

        if(!$this->error)
        {
            $this->po_id = $purchaseOrder->id;
            $this->po_code = $purchaseOrder->code;
            $this->po_date = $purchaseOrder->date->format('Y-m-d H:i:s');
            /* Tambien se puede usar como un metodo estático */
            $this->request_form = (new PurchaseOrderService())->getRequestForm($this->po_search);
            $this->request_form_id = $this->request_form ? $this->request_form->id : null;
        }
        else
            $this->clearInputAdvantage(false);
    }

    public function register()
    {
        $dataValidated = $this->validate();
        $dataValidated['number'] = $dataValidated['number_inventory'];
        $dataValidated['po_code'] = $this->po_code;
        $dataValidated['request_user_ou_id'] = $this->request_form ? $this->request_form->request_user_ou_id : null;
        $dataValidated['request_user_id'] = $this->request_form ? $this->request_form->request_user_id : null;
        $dataValidated['establishment_id'] = auth()->user()->organizationalUnit->establishment->id;
        $responsibleUser = User::find($dataValidated['user_responsible_id']);
        $usingUser =  User::find($dataValidated['user_using_id']);
        $inventory = Inventory::create($dataValidated);

        $movement = InventoryMovement::create([
            'observations' => $dataValidated['observations'],
            'inventory_id' => $inventory->id,
            'place_id' => $dataValidated['place_id'],
            'user_responsible_ou_id' => optional($responsibleUser->organizationalUnit)->id,
            'user_responsible_id' => $dataValidated['user_responsible_id'],
            'user_using_ou_id' => ($usingUser != null) ? optional($usingUser->organizationalUnit)->id : null,
            'user_using_id' => $dataValidated['user_using_id'],
            'reception_confirmation' => $this->getReceptionConfirmation(),
            'reception_date' => $this->getReceptionConfirmation() ? now() : null,
        ]);

		/** Enviar notificación al responsable, sólo si necesita confimación */
		if($this->getReceptionConfirmation())
		{
			$movement->responsibleUser->notify(new InventoryNewItem($movement));
		}

        $this->collapse = false;
        $this->emit('clearSearchUser');
        $this->emit('clearSearchPlace');
        $this->emit('onClearSearch');
        $this->emit('productId', null);

        $this->reset(['po_search']);
        $this->clearInputProduct();
        $this->clearInputAdvantage(true);

        session()->flash('success', 'El inventario fue registrado exitosamente.');
        return redirect()->route('inventories.assigned-products');
    }

    public function clearInputProduct()
    {
        $this->status = 1;
        $this->type = 1;
        $this->user_using_id = Auth::id();
        $this->reset([
            'user_responsible_id',
            'search_product',
            'unspsc_product_id',
            'description',
            'number_inventory',
            'brand',
            'model',
            'serial_number',
            'observations',
        ]);
    }

    public function clearInputAdvantage($resetError)
    {
        if($resetError)
            $this->error = false;

        $this->reset([
            'po_id',
            'po_code',
            'po_date',
            'po_price',
            'request_form',
            'request_form_id',
            'useful_life',
            'deliver_date',
        ]);
    }

    public function collapse()
    {
        $this->collapse = !$this->collapse;
    }
}
