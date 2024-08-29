<?php

namespace App\Livewire\Welfare\Amipass;

use Livewire\Component;

class MiAmipassIndex extends Component
{
    public $currentTab = 'charges_tab';

    public function changeTab($tab_selected)
    {
        $this->currentTab = $tab_selected;
    }

    public function render()
    {
        return view('livewire.welfare.amipass.mi-amipass-index');
    }
}