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
    public $selectedDocumentType;

    protected $listeners = ['documentTypeChanged' => 'configureDocumentType'];

    public function mount()
    {
        if ($this->signaturesFlowSigner) {
            $this->organizationalUnit = $this->signaturesFlowSigner->ou_id;
        }

        if (!empty($this->organizationalUnit)) {
            $this->users = OrganizationalUnit::find($this->organizationalUnit)->users->sortBy('name');
            if ($this->signaturesFlowSigner) {
                $this->user = $this->signaturesFlowSigner->user_id;
            }
        }
    }

    public function configureDocumentType($documentType)
    {
        $this->selectedDocumentType = $documentType;
    }

    public function render()
    {
        if (!empty($this->organizationalUnit)) {
            $this->userRequired = 'required';
            $this->users = OrganizationalUnit::find($this->organizationalUnit)->users->sortBy('name');
        }else{
            $this->userRequired = '';
            $this->user = null;
            $this->users = [];
        }

        $ouRoots = OrganizationalUnit::with([
                'childs',
                'childs.childs',
                'childs.childs.childs',
                'childs.childs.childs.childs',
            ])
            ->where('level', 1)
            ->whereIn('establishment_id', [38, 1])
            ->get();

        return view('livewire.signatures.signer',compact('ouRoots'))
            ->withSignaturesFlowSigner($this->signaturesFlowSigner);
    }
}
