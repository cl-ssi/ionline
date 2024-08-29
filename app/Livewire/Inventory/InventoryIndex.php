<?php

namespace App\Livewire\Inventory;

use App\Models\Establishment;
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryUser;
use App\Models\Inv\Classification;
use App\Models\Parameters\Location;
use App\Models\Parameters\Place;
use App\Models\Unspsc\Product as UnspscProduct;
use App\Models\User;
use App\Models\Parameters\Parameter;
use App\Models\Rrhh\Authority;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $establishment;

    public $products;
    public $users;
    public $responsibles;
    public $places;
    public $locations;
    public $placeIds;

    public $unspsc_product_id;
    public $user_using_id;
    public $user_responsible_id;
    public $place_id;
    public $location_id;
    public $number;
    public $inv_id;
    public $architectural_design_code;

    public $unspscProduct;
    public $userUsing;
    public $userResponsible;
    public $place;
    public $location;
    public $pending;
    public $oc;

    public $brand;
    public $model;
    public $serial_number;
    public $description;

    public $managerInventory;

    public $classifications;
    public $classification_id;

    public function mount(Establishment $establishment)
    {
        $this->getProducts();
        $this->getUsers();
        $this->getResponsibles();
        $this->getLocations();
        $this->places = collect([]);

        $this->classifications = Classification::orderBy('name')->get();

        $manager_inventory_id = Parameter::get('inventory','Encargado de inventario');
        if($manager_inventory_id)
        {
            $this->managerInventory = User::find($manager_inventory_id);
        }
    }

    public function render()
    {
        return view('livewire.inventory.inventory-index',[
            'inventories' => $this->getInventories(),
        ]);
    }

    public function getInventories()
    {
        $inventories = Inventory::query()
            ->with([
                'product',
                'place',
                'place.location',
                'responsible',
                'using',
                'unspscProduct',
                'lastMovement',
                'lastMovement.responsibleUser',
                'lastMovement.usingUser',
                'inventoryUsers'
            ])
            ->when($this->unspsc_product_id, function($query) {
                $query->whereRelation('unspscProduct', 'id', '=', $this->unspsc_product_id);
            })
            ->when($this->user_using_id, function($query) {
                $query->whereRelation('inventoryUsers', 'user_id', '=', $this->user_using_id);
            })
            ->when($this->user_responsible_id, function($query) {
                $query->whereRelation('responsible', 'id', '=', $this->user_responsible_id);
            })
            ->when($this->place_id, function($query) {
                $query->whereRelation('place', 'id', '=', $this->place_id);
            })
            ->when($this->location_id, function($query) {
                $query->whereHas('place', function($query) {
                    $query->whereRelation('location', 'id', '=', $this->location_id);
                });
            })
            ->when($this->architectural_design_code, function($query) {
                $query->whereHas('place', function($query) {
                    $query->where('architectural_design_code', 'LIKE', '%'.$this->architectural_design_code.'%');
                });
            })
            ->when($this->number, function($query) {
                $query->where(function($query) {
                    $query->where('number', 'LIKE', '%'.$this->number.'%')
                          ->orWhere('old_number', 'LIKE', '%'.$this->number.'%');
                });
            })
            ->when($this->inv_id, function($query) {
                $query->where('id', $this->inv_id);
            })
            ->when($this->classification_id, function($query) {
                $query->where('classification_id', $this->classification_id);
            })
            ->when($this->pending, function($query) {
                $query->whereHas('pendingMovements');
            })
            ->when($this->oc, function($query) {
                $query->where('po_code', 'LIKE', '%'.$this->oc.'%');
            })
            ->when($this->brand, function($query) {
                $query->where('brand', 'LIKE', '%'.$this->brand.'%');
            })
            ->when($this->model, function($query) {
                $query->where('model', 'LIKE', '%'.$this->model.'%');
            })
            ->when($this->serial_number, function($query) {
                $query->where('serial_number', 'LIKE', '%'.$this->serial_number.'%');
            })
            ->when($this->description, function($query) {
                $query->where('description', 'LIKE', '%'.$this->description.'%');
            })

            ->whereEstablishmentId($this->establishment->id)
            ->whereNotNull('number')
            ->orderByDesc('id')
            ->paginate(50);

        return $inventories;
    }

    public function getUsers()
    {
        $userIds = InventoryUser::query()
        ->whereHas('inventory', function ($query) {
            $query->whereEstablishmentId($this->establishment->id);
        })
        ->groupBy('user_id')
        ->pluck('user_id');

        $this->users = User::withTrashed()
            ->whereIn('id', $userIds)
            ->orderBy('name')
            ->get(['id', 'name', 'fathers_family']);
    }

    public function getResponsibles()
    {
        $responsibleIds = Inventory::query()
            ->whereEstablishmentId($this->establishment->id)
            ->whereNotNull('user_responsible_id')
            ->groupBy('user_responsible_id')
            ->pluck('user_responsible_id');

        $this->responsibles = User::withTrashed()
            ->whereIn('id', $responsibleIds)
            ->orderBy('name')
            ->get(['id', 'name', 'fathers_family']);
    }

    public function getProducts()
    {
        $productIds = Inventory::query()
            ->whereEstablishmentId($this->establishment->id)
            ->whereNotNull('unspsc_product_id')
            ->groupBy('unspsc_product_id')
            ->pluck('unspsc_product_id');

        $this->products = UnspscProduct::query()
            ->whereIn('id', $productIds)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function getLocations()
    {
        $this->placeIds = Inventory::query()
            ->whereEstablishmentId($this->establishment->id)
            ->whereNotNull('place_id')
            ->groupBy('place_id')
            ->pluck('place_id');

        $places = Place::query()
            ->whereIn('id', $this->placeIds)
            ->orderBy('name')
            ->get();

        $this->locations = Location::query()
            ->whereIn('id', $places->pluck('location_id'))
            ->get();
    }

    public function updatedUnspscProductId($unspsc_product_id)
    {
        $this->unspscProduct = null;
        if($unspsc_product_id)
            $this->unspscProduct = UnspscProduct::find($unspsc_product_id);
    }

    public function updatedUserUsingId($user_using_id)
    {
        $this->userUsing = null;
        if($user_using_id)
            $this->userUsing = User::find($user_using_id);
    }

    public function updatedUserResponsibleId($user_responsible_id)
    {
        $this->userResponsible = null;
        if($this->user_responsible_id)
            $this->userResponsible = User::find($user_responsible_id);
    }

    public function updatedLocationId($location_id)
    {
        $this->places = Place::query()
            ->whereIn('id', $this->placeIds)
            ->where('location_id', $location_id)
            ->orderBy('name')
            ->get();

        $this->location = null;
        if($location_id)
            $this->location = Location::find($location_id);
    }

    public function updatedPlaceId($place_id)
    {
        $this->place = null;
        if($place_id)
            $this->place = Place::find($place_id);
    }


    public function updateResponsible()
    {
        if ($this->pending === 'pending') {
            $responsibleIdsWithPendingInventory = Inventory::query()
                ->whereEstablishmentId($this->establishment->id)
                ->whereHas('pendingMovements')
                ->whereNotNull('user_responsible_id')
                ->groupBy('user_responsible_id')
                ->pluck('user_responsible_id');    
            
            $this->responsibles = User::query()
                ->whereIn('id', $responsibleIdsWithPendingInventory)
                ->orderBy('name')
                ->get(['id', 'name', 'fathers_family']);
        } else {            
            $this->getResponsibles();
        }
    }

    public function updatedClassificationId($classification_id)
    {        
        $this->getInventories();
    }

    public function removeInventoryUser($inventoryUserId)
    {
        InventoryUser::where('id', $inventoryUserId)->delete();
        session()->flash('message', 'Usuario eliminado exitosamente.');
        $this->getUsers();
    }


    
    



}
