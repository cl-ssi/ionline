<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Establishment;
use App\Models\Inv\Inventory;
use App\Models\Parameters\Location;
use App\Models\Parameters\Place;
use App\Models\Unspsc\Product as UnspscProduct;
use App\User;
use App\Models\Parameters\Parameter;
use App\Rrhh\Authority;
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

    public $unspscProduct;
    public $userUsing;
    public $userResponsible;
    public $place;
    public $location;

    public $managerInventory;

    public function mount(Establishment $establishment)
    {
        $this->getProducts();
        $this->getUsers();
        $this->getResponsibles();
        $this->getLocations();
        $this->places = collect([]);

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
        ])->extends('layouts.bt4.app');
    }

    public function getInventories()
    {
        $inventories = Inventory::query()
            ->when($this->unspsc_product_id, function($query) {
                $query->whereRelation('unspscProduct', 'id', '=', $this->unspsc_product_id);
            })
            ->when($this->user_using_id, function($query) {
                $query->whereRelation('using', 'id', '=', $this->user_using_id);
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
            ->whereEstablishmentId($this->establishment->id)
            ->whereNotNull('number')
            ->orderByDesc('id')
            ->paginate(25);

        return $inventories;
    }

    public function getUsers()
    {
        $userIds = Inventory::query()
            ->whereEstablishmentId($this->establishment->id)
            ->whereNotNull('user_using_id')
            ->groupBy('user_using_id')
            ->pluck('user_using_id');

        $this->users = User::query()
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

        $this->responsibles = User::query()
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
}
