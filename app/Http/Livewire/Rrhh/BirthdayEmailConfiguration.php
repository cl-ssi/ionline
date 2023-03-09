<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\models\Rrhh\SirhActiveUser;
use Carbon\Carbon;

use App\Models\Rrhh\BirthdayEmailConfiguration as BirthdayEmailConfigurationModel;

class BirthdayEmailConfiguration extends Component
{
    public $configuration = null;

    public function mount()
    {
        $this->configuration = BirthdayEmailConfigurationModel::all()->last();
    }

    public function render()
    {               
        return view('livewire.rrhh.birthday-email-configuration');
    }
}
