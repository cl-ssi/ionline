<?php

namespace App\Http\Livewire\Drugs;

use App\Http\Requests\Drugs\StoreActPrecursorRequest;
use App\Models\Drugs\ActPrecursor;
use App\Models\Drugs\ActPrecursorItem;
use App\Models\Drugs\ReceptionItem;
use Livewire\Component;

class EditActPrecursor extends Component
{
    public $actPrecursor;

    public $date;
    public $full_name_receiving;
    public $run_receiving;
    public $note;

    public $selected_precursors;
    public $old_precursors;
    public $precursors;

    public function mount(ActPrecursor $actPrecursor)
    {
        $this->date = $actPrecursor->date->format('Y-m-d');
        $this->full_name_receiving = $actPrecursor->full_name_receiving;
        $this->run_receiving = $actPrecursor->run_receiving;
        $this->note = $actPrecursor->note;

        $this->old_precursors = $actPrecursor->precursors->pluck('reception_item_id');
        $this->selected_precursors = $actPrecursor->precursors->pluck('reception_item_id');

        $this->getPrecursors();
    }

    public function rules()
    {
        return (new StoreActPrecursorRequest())->rules();
    }

    public function render()
    {
        return view('livewire.drugs.edit-act-precursor');
    }

    public function getPrecursors()
    {
        $this->precursors = ReceptionItem::query()
            ->whereIn('id', $this->selected_precursors)
            ->orWhere('dispose_precursor', true)
            ->get();
    }

    public function updateActPrecursor()
    {
        $dataValidated = $this->validate();

        $this->actPrecursor->update($dataValidated);

        foreach($this->actPrecursor->precursors as $precursor)
        {
            $precursor->update([
                'dispose_precursor'=> true,
            ]);

            $actPrecursorItem = ActPrecursorItem::query()
                ->where('reception_item_id', $precursor->reception_item_id)
                ->where('act_precursor_id', $this->actPrecursor->id)
                ->first();

            if($actPrecursorItem)
                $actPrecursorItem->forceDelete();
        }

        foreach($this->selected_precursors as $item)
        {
            $receptionItem = ReceptionItem::find($item);
            $receptionItem->update([
                'dispose_precursor' => false,
            ]);

            ActPrecursorItem::create([
                'reception_item_id' => $item,
                'act_precursor_id' => $this->actPrecursor->id,
            ]);
        }

        $diff = $this->old_precursors->diff($this->selected_precursors);
        $diff = $diff->values()->all();

        foreach($diff as $itemPrecursor)
        {
            $precursorDiff = ReceptionItem::find($itemPrecursor);
            $precursorDiff->update([
                'dispose_precursor' => true,
            ]);
        }

        $this->actPrecursor->refresh();

        $this->old_precursors = $this->actPrecursor->precursors->pluck('reception_item_id');
        $this->selected_precursors = $this->actPrecursor->precursors->pluck('reception_item_id');

        $this->getPrecursors();

        session()->flash('success', 'El acta de precursores fue actualizada exitosamente.');
    }
}
