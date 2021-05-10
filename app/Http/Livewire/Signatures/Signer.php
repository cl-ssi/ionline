<?php

namespace App\Http\Livewire\Signatures;

use Livewire\Component;
use App\Rrhh\OrganizationalUnit;

class Signer extends Component
{
    public $organizationalUnit;
    public $users = [];
    public $user;
    public $signaturesFlowSigner;
    public $userRequired;

    public function mount()
    {
        if ($this->signaturesFlowSigner) {
            $this->organizationalUnit = $this->signaturesFlowSigner->ou_id;
        }

        if (!empty($this->organizationalUnit)) {
            $this->users = OrganizationalUnit::find($this->organizationalUnit)->users;
            if ($this->signaturesFlowSigner) {
                $this->user = $this->signaturesFlowSigner->user_id;
            }
        }
    }

    public function render()
    {
        ($this->organizationalUnit) ? $this->userRequired = 'required' : $this->userRequired = '';

        if (!empty($this->organizationalUnit)) {
            $this->users = OrganizationalUnit::find($this->organizationalUnit)->users;
        }

        return view('livewire.signatures.signer')
            ->withOuRoots(OrganizationalUnit::where('level', 1)->where('establishment_id', 38)->get())
            ->withSignaturesFlowSigner($this->signaturesFlowSigner);
    }
}
