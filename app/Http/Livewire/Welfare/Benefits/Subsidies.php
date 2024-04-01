<?php

namespace App\Http\Livewire\Welfare\Benefits;

use Livewire\Component;

use App\Models\Welfare\Benefits\Benefit;
use App\Models\Welfare\Benefits\Subsidy;
use App\Models\Welfare\Benefits\Document;

class Subsidies extends Component
{
    public $subsidies;
    public $showCreate = false;
    public $selectedSubsidyId;
    public $newSubsidyName = '';
    public $selectedBenefitId; // Para almacenar el ID del beneficio seleccionado al crear un subsidio
    public $benefits; // Para almacenar todos los beneficios disponibles
    public $description;
    public $annual_cap;
    public $recipient;
    public $status;
    public $payment_in_installments;
    public $documents = [];

    public function showCreateForm()
    {
        $this->showCreate = !$this->showCreate;
        if ($this->showCreate) {
            $this->resetInputFields();
        }
    }

    private function resetInputFields()
    {
        $this->reset([
            'newSubsidyName', 'selectedBenefitId', 'description', 'annual_cap', 'recipient', 'status', 'payment_in_installments','selectedSubsidyId'
        ]);
    }

    public function editSubsidy($subsidyId)
    {
        $subsidy = Subsidy::find($subsidyId);
        $this->newSubsidyName = $subsidy->name;
        $this->selectedBenefitId = $subsidy->benefit_id;
        $this->description = $subsidy->description;
        $this->annual_cap = $subsidy->annual_cap;
        $this->recipient = $subsidy->recipient;
        $this->status = $subsidy->status;
        $this->selectedSubsidyId = $subsidyId;
        $this->payment_in_installments = $subsidy->payment_in_installments;
        $this->showCreate = true;
        $this->documents = $subsidy->documents;
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
            'description' => 'required|string',
            // 'recipient' => 'required|string',
        ]);

        if ($this->selectedSubsidyId) {
            $subsidy = Subsidy::find($this->selectedSubsidyId);
            $subsidy->update([
                'name' => $this->newSubsidyName,
                'benefit_id' => $this->selectedBenefitId,
                'description' => $this->description,
                'annual_cap' => $this->annual_cap,
                'recipient' => $this->recipient,
                'status' => $this->status,
                'payment_in_installments' => $this->payment_in_installments,
            ]);
        } else {
            Subsidy::create([
                'name' => $this->newSubsidyName,
                'benefit_id' => $this->selectedBenefitId,
                'description' => $this->description,
                'annual_cap' => $this->annual_cap,
                'recipient' => $this->recipient,
                'status' => $this->status,
                'payment_in_installments' => $this->payment_in_installments,
            ]);
        }
        

        $this->reset(['newSubsidyName', 'selectedSubsidyId', 'selectedBenefitId','description','annual_cap','recipient','status','payment_in_installments','showCreate']);
    }

    public function deleteDocument($documentId){
        Document::find($documentId)->delete();
        
        $this->reset(['newSubsidyName', 'selectedSubsidyId', 'selectedBenefitId','description','annual_cap','recipient','status','payment_in_installments','showCreate']);
    }

    public function render()
    {
        $this->subsidies = Subsidy::with('benefit')->get();
        $this->benefits = Benefit::all();
        return view('livewire.welfare.benefits.subsidies');
    }
}
