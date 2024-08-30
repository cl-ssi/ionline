<?php

namespace App\Livewire;

use App\Models\Finance\Receptions\Reception;
use Livewire\Attributes\On;
use Livewire\Component;

class TestFileUpdateManager extends Component
{
    /**
     * Model containing the files
     *
     * @var mixed
     */
    public $receptionFinance;

    public function mount(Reception $receptionFinance)
    {
        //
    }

    public function render()
    {
        return view('livewire.test-file-update-manager');
    }

    #[On('refreshFiles')]
    public function refreshFiles()
    {
        $this->receptionFinance->refresh();
    }
}