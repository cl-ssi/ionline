<?php

namespace App\Livewire\Parameters;

use App\Models\Establishment;
use App\Models\Parameters\Location;
use App\Models\Parameters\Place;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlacesExport;

class Places extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $establishment;
    public $view;
    public $place;
    public $name;
    public $description;
    public $location_id;
    public $locations;
    public $architectural_design_code;
    public $filter;

    public function render()
    {
        return view('livewire.parameters.places', [
            //'places' => Place::latest()->paginate(10)
            'places' => $this->getPlaces()
        ]);
    }

    public function rules()
    {
        return [
            'name'          => 'required|string|min:2|max:255',
            'description'   => 'nullable|string|min:0|max:255',
            'location_id'   => 'required|exists:cfg_locations,id',
            'architectural_design_code'   => 'nullable|string|min:0|max:255',
        ];
    }

    public function mount(Establishment $establishment)
    {
        $this->view = 'index';
    }

    public function index()
    {
        $this->view = 'index';
    }

    public function create()
    {
        $this->view = 'create';
        $this->place = null;
        $this->name = null;
        $this->description = null;
        $this->location_id = null;
        $this->architectural_design_code = null;
        $this->locations = Location::whereEstablishmentId($this->establishment->id)->get();
    }

    public function store()
    {
        $dataValidated = $this->validate();
        $dataValidated['establishment_id'] = $this->establishment->id;
        $place = Place::create($dataValidated);
        $this->mount($this->establishment);

        session()->flash('info', 'Se ha creado la oficina con el id <span class="h5">' . $place->id . "</span>. Por favor anote el número en la hoja de inventario que está ubicada en la pared.");

        $this->reset([
            'name',
            'description',
            'location_id',
            'architectural_design_code',
        ]);
        $this->view = 'create';
    }

    public function searchPlace()
    {
        $this->resetPage(); // Reinicia la paginación a la primera página
    }

    public function edit(Place $place)
    {
        $this->view = 'edit';
        $this->place = $place;
        $this->locations = Location::all();

        $this->name = $place->name;
        $this->description = $place->description;
        $this->location_id = $place->location_id;
        $this->architectural_design_code = $place->architectural_design_code;
    }

    public function update(Place $place)
    {
        $place->update($this->validate());
        $this->mount($this->establishment);

        session()->flash('info', 'La oficina fue actualizada exitosamente.');

        $this->view = 'index';
    }

    public function delete(Place $place)
    {
        
        if ($place->inventories->isEmpty() and $place->inventoryMovements->isEmpty()) {
            $place->delete();
            $this->mount($this->establishment);
            session()->flash('info', 'El lugar fue borrado exitosamente');
        } else {
            // Tiene inventarios, mostrar un mensaje de advertencia
            session()->flash('warning', 'No se puede borrar el lugar ya que tiene inventarios asociados.');
        }
    }

    public function getPlaces()
    {
        $query = Place::query()
            ->orderBy('name', 'asc')
            ->with('establishment')
            ->when($this->establishment, function ($query) {
                $query->whereEstablishmentId($this->establishment->id);
            });

        if ($this->filter) {
            $searchTerm = '%' . $this->filter . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                    ->orWhere('description', 'LIKE', $searchTerm)
                    ->orWhereHas('location', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', $searchTerm);
                    })
                    ->orWhere('architectural_design_code', 'LIKE', $searchTerm);
            });
        }

        return $query->paginate(100);
    }


    public function exportToExcel()
    {
        $places = Place::with('establishment')
            ->when($this->establishment, function ($query) {
                $query->whereEstablishmentId($this->establishment->id);
            })
            ->when($this->filter, function ($query, $searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhereHas('location', function ($q) use ($searchTerm) {
                            $q->where('name', 'LIKE', '%' . $searchTerm . '%');
                        })
                        ->orWhere('architectural_design_code', 'LIKE', '%' . $searchTerm . '%');
                });
            })
            ->orderBy('name', 'asc')
            ->get();

        return Excel::download(new PlacesExport($places), 'places.xlsx');
    }


}
