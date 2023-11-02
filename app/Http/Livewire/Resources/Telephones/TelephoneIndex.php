<?php

namespace App\Http\Livewire\Resources\Telephones;

use Livewire\Component;
use App\Models\Resources\Telephone;
use App\Models\Parameters\Place;
use App\Models\Parameters\Location;
use App\Models\Establishment;

class TelephoneIndex extends Component
{
    protected $listeners = ['placeSelected'];

    public $filter;
    public $establishments;
    public $establishment_id;

    /**
    * mount
    */
    public function mount()
    {
        $establishments_ids = explode(',',env('APP_SS_ESTABLISHMENTS'));
        $this->establishments = Establishment::whereIn('id',$establishments_ids)
            ->orderBy('official_name')
            ->get();
        $this->establishment_id = auth()->user()->organizationalUnit->establishment_id;
    }

    /**
    * Search
    */
    public function searchTelephones()
    {
        $telephones = Telephone::query();

        $telephones->with([
            'users',
            'place',
            'place.establishment',
        ]);

        $telephones->search('minsal', $this->filter);
        $telephones->search('establishment_id', $this->establishment_id);

        return $telephones->paginate(100);
    }

    /**
    * search
    */
    public function search()
    {
        
    }
    /**
    * placeSelected
    */
    public function placeSelected(Establishment $establishment, Location $location, Place $place)
    {
        $this->establishment = $establishment;
        $this->location = $location;
        $this->place = $place;
    }

    public function render()
    {
        $telephones = $this->searchTelephones();

        return view('livewire.resources.telephones.telephone-index', [
            'telephones' => $telephones,
        ]);
    }
}
