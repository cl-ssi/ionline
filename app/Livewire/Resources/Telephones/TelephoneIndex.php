<?php

namespace App\Livewire\Resources\Telephones;

use App\Models\Establishment;
use App\Models\Parameters\Location;
use App\Models\Parameters\Place;
use App\Models\Resources\Telephone;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TelephoneIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

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
    public function getTelephones()
    {
        $telephones = Telephone::query();
        $telephones->withTrashed();

        $telephones->with([
            'users',
            'place',
            'place.establishment',
        ]);

        $telephones->search('minsal', $this->filter);
        if($this->establishment_id != "todos") {
            $telephones->search('establishment_id', $this->establishment_id);
        }

        return $telephones->paginate(100);
    }

    /**
    * search
    */
    public function search()
    {
        // reset pagination
        $this->resetPage();
    }

    /** Metodo para restaruar un elemento borrado */
    public function restore($id)
    {
        $telephone = Telephone::withTrashed()->findOrFail($id);
        $telephone->restore();
        $this->dispatch('alert', 'success', 'El telefono ' . $telephone->number . ' ha sido restaurado.');
    }

    /**
    * placeSelected
    */
    #[On('placeSelected')]
    public function placeSelected(Establishment $establishment, Location $location, Place $place)
    {
        $this->establishment = $establishment;
        $this->location = $location;
        $this->place = $place;
    }

    public function render()
    {
        $telephones = $this->getTelephones();

        return view('livewire.resources.telephones.telephone-index', [
            'telephones' => $telephones,
        ]);
    }
}
