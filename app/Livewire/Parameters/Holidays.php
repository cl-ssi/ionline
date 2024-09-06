<?php

namespace App\Livewire\Parameters;

use Livewire\Component;
use App\Models\Parameters\Holiday;
use App\Models\ClRegion;
use Livewire\WithPagination;

class Holidays extends Component
{
    /** Necesario para paginar los resultados */
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /** Mostrar o no el form, tanto para crear como para editar */
    public $formActive = false;
    public $holidayId;
    public $holidayDate;
    public $holidayName;
    public $holidayRegionId;
    /** Listado de regiones */
    public $regions;

    /**
    * mount
    */
    public function mount()
    {
        $this->regions = ClRegion::pluck('name', 'id');
    }

    protected function rules()
    {
        /* // FIXME: si seleccionas una fecha en el navegador y luego la borras,
         * se pasa un string vacío para la fecha y se guarda 0000-00-00 en la BD */
        $startOfYear = now()->startOfYear()->format('Y-m-d');

        return [
            'holidayDate'     => 'required|date_format:Y-m-d|after_or_equal:' . $startOfYear,
            'holidayName'     => 'required|min:4',
            'holidayRegionId' => 'nullable',
        ];
    }

    protected $messages = [
        'holidayDate.required' => 'La fecha desde es requerida.',
        'holidayName.required' => 'El nombre es requerido.',
    ];

    public function showForm()
    {
        $this->formActive = true;
    }

    public function index()
    {
        $this->resetErrorBag();
        $this->formActive = false;
        $this->reset(['holidayId', 'holidayDate', 'holidayName', 'holidayRegionId']);
    }

    public function edit(Holiday $holiday)
    {
        // dd($holiday->date);
        $this->holidayId       = $holiday->id;
        $this->holidayDate     = $holiday->date->format('Y-m-d');
        $this->holidayName     = $holiday->name;
        $this->holidayRegionId = $holiday->region_id;

        $this->formActive = true;
    }

    public function save()
    {
        $this->validate();

        Holiday::updateOrCreate(
            ['id' => $this->holidayId],
            [
                'date'      => $this->holidayDate,
                'name'      => $this->holidayName,
                'region_id' => $this->holidayRegionId,
            ]
        );

        $this->index();
    }

    public function delete(Holiday $holiday)
    {
        $holiday->delete();
    }

    public function render()
    {
        $holidays = Holiday::orderByDesc('date')->paginate(25);
        return view('livewire.parameters.holidays', [
            'holidays' => $holidays,
        ]);
    }
}
