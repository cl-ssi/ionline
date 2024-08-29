<?php

namespace App\Livewire\Welfare\Benefits;

use Livewire\Component;

use App\Models\Welfare\Benefits\Benefit;

class Benefits extends Component
{
    public $benefits;
    public $showCreate = false;
    public $selectedBenefitId;
    public $newBenefitName = '';
    public $newBenefitObservations = '';

    public function showCreateForm()
    {
        $this->showCreate = !$this->showCreate;
        if (!$this->showCreate) {
            $this->reset(['newBenefitName', 'newBenefitObservations']);
        }
    }

    public function editBenefit($benefitId)
    {
        $benefit = Benefit::find($benefitId);
        $this->newBenefitName = $benefit->name;
        $this->newBenefitObservations = $benefit->observation;
        $this->selectedBenefitId = $benefitId;
        $this->showCreate = true;
    }

    public function deleteBenefit($benefitId)
    {
        $benefit = Benefit::find($benefitId);
        $benefit->delete();
    }

    public function saveBenefit()
    {
        $this->validate([
            'newBenefitName' => 'required',
        ]);

        if ($this->selectedBenefitId) {
            $benefit = Benefit::find($this->selectedBenefitId);
            $benefit->update([
                'name' => $this->newBenefitName,
                'observation' => $this->newBenefitObservations,
            ]);
        } else {
            Benefit::create([
                'name' => $this->newBenefitName,
                'observation' => $this->newBenefitObservations,
            ]);
        }

        $this->reset(['newBenefitName', 'newBenefitObservations', 'selectedBenefitId', 'showCreate']);
    }

    public function render()
    {
        $this->benefits = Benefit::all();
        return view('livewire.welfare.benefits.benefits');
    }
}
