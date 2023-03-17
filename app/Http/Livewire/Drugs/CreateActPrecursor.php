<?php

namespace App\Http\Livewire\Drugs;

use App\Http\Requests\Drugs\StoreActPrecursorRequest;
use App\Models\Drugs\ActPrecursor;
use App\Models\Drugs\ActPrecursorItem;
use App\Models\Drugs\ReceptionItem;
use Livewire\Component;

class CreateActPrecursor extends Component
{
    public $date;
    public $full_name_receiving;
    public $run_receiving;
    public $note;

    public $selected_precursors;
    public $precursors;

    public function mount()
    {
        $this->selected_precursors = [];
        $this->getPrecursors();
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
        $dataValidated['delivery_id'] = auth()->user()->id;

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
