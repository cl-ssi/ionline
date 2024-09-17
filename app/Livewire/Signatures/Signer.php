<?php

namespace App\Livewire\Signatures;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Rrhh\OrganizationalUnit;

class Signer extends Component
{
    public $organizationalUnit;
    public $users = [];
    public $user;
    public $signaturesFlowSigner;
    public $userRequired;
    public $selectedDocumentType;

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

    #[On('documentTypeChanged')]
    public function configureDocumentType($type_id)
    {
        $this->selectedDocumentType = $type_id;
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
                'childs.childs.childs.childs.childs',
                'childs.childs.childs.childs.childs.childs',
            ])
            ->where('level', 1)
            ->whereIn('establishment_id', [1,34,35,36,37,38,41])
            ->get();

        return view('livewire.signatures.signer',compact('ouRoots'))
            ->withSignaturesFlowSigner($this->signaturesFlowSigner);
    }
}
