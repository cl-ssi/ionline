<?php

namespace App\Livewire\Allowances;

use Livewire\Component;
use App\Models\Allowances\Allowance;
use Illuminate\Support\Facades\Http;
use App\Traits\ArchiveTrait;

class ArchiveAllowance extends Component
{
    use ArchiveTrait;

    public $allowance;
    public $isArchived;

    public function mount(Allowance $allowance)
    {
        $this->allowance = $allowance;
        $this->isArchived = $allowance->isArchived();
    }

    public function toggleArchive()
    {
        if ($this->isArchived) {
            $this->unArchive(Allowance::class, $this->allowance->id);
        } else {
            $this->archive(Allowance::class, $this->allowance->id);
        }

        // Actualizar la vista sin recargar
        $this->isArchived = !$this->isArchived;
        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        return view('livewire.allowances.archive-allowance');
    }
}
