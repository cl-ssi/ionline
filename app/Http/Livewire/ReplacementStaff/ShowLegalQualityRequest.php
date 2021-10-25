<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;

class ShowLegalQualityRequest extends Component
{
    public $selectedLegalQuality = null;
    public $selectedFundament = null;

    public $salaryStateInput = 'readonly';
    public $fundamentOptionState = 'disabled';
    public $fundamentStateSelect = 'disabled';
    public $fundamentOptionStateDisabled = 'disabled';

    public $nameToReplaceInput = 'disabled';
    public $nameOtherFundament = 'disabled';

    public $requestReplacementStaff;

    /* Para editar y precargar los select */
    public $legalQualitySelected = null;
    public $fundamentSelected = null;

    public function mount(){
        if($this->requestReplacementStaff) {
            $this->selectedLegalQuality = $this->requestReplacementStaff->legal_quality;

            switch ($this->requestReplacementStaff->legal_quality) {
                case 'to hire':
                    $this->salaryStateInput = 'readonly';
                    $this->fundamentStateSelect = '';
                    $this->fundamentOptionState = '';
                    $this->fundamentOptionStateDisabled = '';

                    break;
                case 'fee':
                    $this->salaryStateInput = '';
                    $this->fundamentStateSelect = '';
                    $this->fundamentOptionState = 'disabled';
                    $this->fundamentOptionStateDisabled = '';

                    break;
                case '':
                    $this->salaryStateInput = 'readonly';
                    $this->fundamentStateSelect = 'disabled';
                    $this->fundamentOptionState = '';
                    break;
            }

            $this->selectedFundament = $this->requestReplacementStaff->fundament;
            switch ($this->requestReplacementStaff->fundament) {
                case 'replacement':
                    $this->nameToReplaceInput = '';
                    $this->nameOtherFundament = 'disabled';
                    break;

                case 'quit':
                    $this->nameToReplaceInput = '';
                    $this->nameOtherFundament = 'disabled';
                    break;

                case 'allowance without payment':
                    $this->nameToReplaceInput = '';
                    $this->nameOtherFundament = 'disabled';
                    break;

                case 'regularization work position':
                    $this->nameToReplaceInput = 'disabled';
                    $this->nameOtherFundament = 'disabled';
                    break;

                case 'expand work position':
                    $this->nameToReplaceInput = 'disabled';
                    $this->nameOtherFundament = 'disabled';
                    break;

                case 'vacations':
                    $this->nameToReplaceInput = '';
                    $this->nameOtherFundament = 'disabled';
                    break;

                case 'other':
                    $this->nameToReplaceInput = '';
                    $this->nameOtherFundament = '';
                    break;

                    break;
                case '':
                    $this->nameToReplaceInput = 'disabled';
                    $this->nameOtherFundament = 'disabled';
                    break;
            }
        }
    }

    public function render()
    {
        return view('livewire.replacement-staff.show-legal-quality-request');
    }

    public function updatedselectedLegalQuality($selected_legal_quality_id){
        switch ($selected_legal_quality_id) {
            case 'to hire':
                $this->salaryStateInput = 'readonly';
                $this->fundamentStateSelect = '';
                $this->fundamentOptionState = '';
                $this->fundamentOptionStateDisabled = '';

                break;
            case 'fee':
                $this->salaryStateInput = '';
                $this->fundamentStateSelect = '';
                $this->fundamentOptionState = 'disabled';
                $this->fundamentOptionStateDisabled = '';

                break;
            case '':
                $this->salaryStateInput = 'readonly';
                $this->fundamentStateSelect = 'disabled';
                $this->fundamentOptionState = '';
                break;
        }
    }

    public function updatedselectedFundament($selected_fundament_id){
        switch ($selected_fundament_id) {
            case 'replacement':
                $this->nameToReplaceInput = '';
                $this->nameOtherFundament = 'disabled';
                break;

            case 'quit':
                $this->nameToReplaceInput = '';
                $this->nameOtherFundament = 'disabled';
                break;

            case 'allowance without payment':
                $this->nameToReplaceInput = '';
                $this->nameOtherFundament = 'disabled';
                break;

            case 'regularization work position':
                $this->nameToReplaceInput = 'disabled';
                $this->nameOtherFundament = 'disabled';
                break;

            case 'expand work position':
                $this->nameToReplaceInput = 'disabled';
                $this->nameOtherFundament = 'disabled';
                break;

            case 'vacations':
                $this->nameToReplaceInput = '';
                $this->nameOtherFundament = 'disabled';
                break;

            case 'other':
                $this->nameToReplaceInput = '';
                $this->nameOtherFundament = '';
                break;

                break;
            case '':
                $this->nameToReplaceInput = 'disabled';
                $this->nameOtherFundament = 'disabled';
                break;
        }
    }
}
