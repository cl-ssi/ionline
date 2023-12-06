<?php

namespace App\Http\Livewire;

use App\Models\Finance\Receptions\Reception;
use Livewire\Component;

class TestFileUpdateManager extends Component
{
    /**
     * Model containing the files
     *
     * @var mixed
     */
    public $receptionFinance;

    protected $listeners = [
        'refreshFiles',
    ];

    public function mount(Reception $receptionFinance)
    {
        //
    }

    public function render()
    {
        return view('livewire.test-file-update-manager');
    }

    public function refreshFiles()
    {
        $this->receptionFinance->refresh();
    }
}