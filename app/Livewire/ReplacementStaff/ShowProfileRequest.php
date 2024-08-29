<?php

namespace App\Livewire\ReplacementStaff;

use Livewire\Component;
use App\Models\ReplacementStaff\ProfileManage;

class ShowProfileRequest extends Component
{
    public $selectedProfile = null;
    public $selectedDegree = null;

    public $degree = null;

    public $requestReplacementStaff;

    /* Para editar y precargar los select */
    public $profileSelected = null;

    public function mount(){
        if($this->requestReplacementStaff) {
            $this->selectedProfile = $this->requestReplacementStaff->profile_manage_id;
            switch ($this->requestReplacementStaff->profile_manage_id) {
                case 1:
                    $this->degree = '22';
                    break;
                case 2:
                    $this->degree = '24';
                    break;
                case 3:
                    $this->degree = '16';
                    break;
                case 4:
                    $this->degree = '22';
                    break;

                case '':
                    $this->degree = '';
                    break;
            }
        }
    }

    public function render()
    {
        return view('livewire.replacement-staff.show-profile-request', [
            'profiles' => ProfileManage::orderBy('name', 'ASC')->get()
        ]);
    }

    public function updatedselectedProfile($profile_id){
        switch ($profile_id) {
            case 1:
                $this->degree = '22';
                break;
            case 2:
                $this->degree = '24';
                break;
            case 3:
                $this->degree = '16';
                break;
            case 4:
                $this->degree = '22';
                break;

            case '':
                $this->degree = '';
                break;
        }
    }
}
