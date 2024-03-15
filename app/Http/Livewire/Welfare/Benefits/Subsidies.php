<?php

namespace App\Http\Livewire\Welfare\Benefits;

use Livewire\Component;

use App\Models\Welfare\Benefits\Benefit;
use App\Models\Welfare\Benefits\Subsidy;

class Subsidies extends Component
{
    public $subsidies;
    public $showCreate = false;
    public $selectedSubsidyId;
    public $newSubsidyName = '';
    public $selectedBenefitId; // Para almacenar el ID del beneficio seleccionado al crear un subsidio
    public $benefits; // Para almacenar todos los beneficios disponibles
    public $percentage;
    public $type;
    public $value;
    public $recipient;

    public function showCreateForm()
    {
        $this->showCreate = !$this->showCreate;
        if (!$this->showCreate) {
            $this->reset(['newSubsidyName', 'selectedBenefitId', 'percentage', 'type', 'value', 'recipient']);
        }
    }

    public function editSubsidy($subsidyId)
    {
        $subsidy = Subsidy::find($subsidyId);
        $this->newSubsidyName = $subsidy->name;
        $this->selectedBenefitId = $subsidy->benefit_id;
        $this->percentage = $subsidy->percentage;
        $this->type = $subsidy->type;
        $this->value = $subsidy->value;
        $this->recipient = $subsidy->recipient;
        $this->selectedSubsidyId = $subsidyId;
        $this->showCreate = true;
    }

    public function deleteSubsidy($subsidyId)
    {
        $subsidy = Subsidy::find($subsidyId);
        $subsidy->delete();
    }

    public function saveSubsidy()
    {
        $this->validate([
            'newSubsidyName' => 'required',
            'selectedBenefitId' => 'required', // Asegurarse de que se haya seleccionado un beneficio
            'percentage' => 'required|string',
            'type' => 'required|string',
            'value' => 'required|string',
            'recipient' => 'required|string',
        ]);

        if ($this->selectedSubsidyId) {
            $subsidy = Subsidy::find($this->selectedSubsidyId);
            $subsidy->update([
                'name' => $this->newSubsidyName,
                'benefit_id' => $this->selectedBenefitId,
                'percentage' => $this->percentage,
                'type' => $this->type,
                'value' => $this->value,
                'recipient' => $this->recipient,
            ]);
        } else {
            Subsidy::create([
                'name' => $this->newSubsidyName,
                'benefit_id' => $this->selectedBenefitId,
                'percentage' => $this->percentage,
                'type' => $this->type,
                'value' => $this->value,
                'recipient' => $this->recipient,
            ]);
        }

        $this->reset(['newSubsidyName', 'selectedSubsidyId', 'selectedBenefitId', 'percentage', 'type', 'value', 'recipient', 'showCreate']);
    }

    public function render()
    {
        $this->subsidies = Subsidy::with('benefit')->get();
        $this->benefits = Benefit::all();
        return view('livewire.welfare.benefits.subsidies');
    }
}
