<?php

namespace App\Livewire\Suitability;

use App\Models\Suitability\PsiRequest;
use App\Models\Suitability\School;
use Livewire\Component;
use Livewire\Attributes\On; 

class SchoolRequests extends Component
{
    public School $school;
    public $editingRequest;
    public $selectedInhability;
    public $showModal = false;

    protected $listeners = ['prepareModal'];

    public function render()
    {
        return view('livewire.suitability.school-requests');
    }

    // #[On('prepareModal')] 
    public function prepareModal($requestId)
    {
        $this->editingRequest = PsiRequest::findOrFail($requestId);
        $this->selectedInhability = $this->editingRequest->status_inhability;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
    }

    public function saveInhability()
    {
        // $this->validate([
        //     'selectedInhability' => 'required|in:none,in_progress,enabled,disabled'
        // ]);
        $this->editingRequest->update([
            'status_inhability' => $this->selectedInhability
        ]);
        $this->closeModal();
        $this->school= School::findOrFail($this->school->id);
    }
}
