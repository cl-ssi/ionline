<?php

namespace App\Livewire\Requirements;

use Livewire\Component;

use App\Models\Requirements\Label;
use App\Models\Requirements\Requirement;
use App\Models\Requirements\LabelRequirement;

class SetLabel extends Component
{
    public $req;

    public $reqLabels;
    public $reqLabelsArray;

    public function setLabel($label_id)
    {
        if(in_array($label_id, $this->reqLabelsArray))
        {
            /** este modelo no tiene ID hay que hacer la query para borrar */
            LabelRequirement::where('requirement_id',$this->req->id)
                ->where('label_id',$label_id)->delete();
        }
        else
        {
            LabelRequirement::Create([
                'requirement_id' => $this->req->id,
                'label_id' => $label_id
            ]);
        }
        
        $this->req->refresh();
    }

    public function render()
    {
        $this->reqLabels = $this->req->labels->where('user_id',auth()->id());
        $this->reqLabelsArray = $this->reqLabels->pluck('id')->toArray();

        return view('livewire.requirements.set-label');
    }
}
