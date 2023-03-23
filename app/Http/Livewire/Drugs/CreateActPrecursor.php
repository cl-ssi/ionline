<?php

namespace App\Http\Livewire\Drugs;

use Livewire\Component;
use App\User;
use App\Models\Parameters\Parameter;
use App\Models\Drugs\ReceptionItem;
use App\Models\Drugs\ActPrecursorItem;
use App\Models\Drugs\ActPrecursor;
use App\Http\Requests\Drugs\StoreActPrecursorRequest;

class CreateActPrecursor extends Component
{
    public $date;
    public $full_name_receiving;
    public $run_receiving;
    public $note;
    public $manager_id;
    public $manager_name;

    public $selected_precursors;
    public $precursors;

    public function mount()
    {
        $this->selected_precursors = [];
        $this->getPrecursors();

        $parameterManager = Parameter::where('module', 'drugs')->where('parameter', 'Jefe')->first();
        if($parameterManager) {
            $this->manager_id = $parameterManager->value;
            $this->manager_name = User::find($parameterManager->value)->shortName;
        }
    }

    public function rules()
    {
        return (new StoreActPrecursorRequest())->rules();
    }

    public function render()
    {
        return view('livewire.drugs.create-act-precursor');
    }

    public function getPrecursors()
    {
        $this->precursors = ReceptionItem::query()
            ->whereDisposePrecursor(true)
            ->get();
    }

    public function saveActPrecursor()
    {
        $dataValidated = $this->validate();
        $dataValidated['delivery_id'] = $this->manager_id;

        $actPrecursor = ActPrecursor::create($dataValidated);

        foreach($this->selected_precursors as $item)
        {
            $receptionItem = ReceptionItem::find($item);
            $receptionItem->update([
                'dispose_precursor' => false,
            ]);

            ActPrecursorItem::create([
                'reception_item_id' => $item,
                'act_precursor_id' => $actPrecursor->id,
            ]);
        }

        $this->selected_precursors = [];

        $this->getPrecursors();

        session()->flash('success', 'El acta de precursores fue creada exitosamente.');

        $this->reset([
            'date',
            'run_receiving',
            'full_name_receiving',
            'note',
        ]);
    }
}
