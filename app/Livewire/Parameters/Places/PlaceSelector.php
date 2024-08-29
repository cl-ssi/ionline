<?php

namespace App\Livewire\Parameters\Places;

use Livewire\Component;
use App\Models\Parameters\Place;
use App\Models\Parameters\Location;
use App\Models\Establishment;

class PlaceSelector extends Component
{
    public $establishments;
    public $locations;
    public $places;

    public $selectedEstablishment;
    public $selectedLocation;
    public $selectedPlace;

    public $place_id = null;

    /**
    * Mount
    */
    public function mount()
    {
        $establishments_ids = explode(',',env('APP_SS_ESTABLISHMENTS'));
        $this->establishments = Establishment::whereIn('id',$establishments_ids)
            ->orderBy('official_name')
            ->get();

        if($this->place_id) {
            $place = Place::find($this->place_id);
            if($place) {

                $this->selectedEstablishment = $place->location->establishment_id;
                $this->selectedLocation = $place->location_id;
                $this->selectedPlace = $place->id;
            }
        }

    }

    /**
    * Clear Inputs
    */
    public function clearInputs()
    {
        $this->selectedLocation = null;
        $this->places = null;
    }

    public function render()
    {
        $this->locations = Location::where('establishment_id',$this->selectedEstablishment)
            ->orderBy('name')
            ->get();

        $this->places = Place::where('location_id',$this->selectedLocation)
            ->orderBy('name')
            ->get();

        return view('livewire.parameters.places.place-selector');
    }
}
