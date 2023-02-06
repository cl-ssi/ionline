<?php

namespace App\Http\Livewire\Signatures;

use Livewire\Component;
use App\Rrhh\OrganizationalUnit;
use App\User;

class Visators extends Component
{
    public $organizationalUnit;
    public $users = [];
    public $inputs = [];
    public $visatorType = [];
    public $i = 0;
    public $user;
    public $signature;
    public $requiredVisator = '';
    public $selectedDocumentType;

    protected $listeners = ['documentTypeChanged' => 'configureDocumentType'];

    public function mount()
    {
        //Agrega inputs según cantidad de flows de visator al editar
        if ($this->signature && $this->signature->signaturesFlowVisator->count() > 0) {
            for ($i = 0; $i < $this->signature->signaturesFlowVisator->count(); $i++) {
                $this->add($this->i);
            }
        }

        // Agrega unidad organizacional al editar
        if ($this->signature && $this->signature->signaturesFlowVisator->count() > 0) {
            foreach ($this->inputs as $key => $value) {
                $this->organizationalUnit[$value] = $this->signature->signaturesFlowVisator->slice($key, 1)->first()->ou_id;
            }
        }

        //Agrega los usuarios según unidad organizacional, si se está editando, selecciona el usuario
        foreach ($this->inputs as $key => $value) {
            if (!empty($this->organizationalUnit[$value])) {
                $this->users[$value] = OrganizationalUnit::find($this->organizationalUnit[$value])->users;
                //Si se está editando
                if ($this->signature) {
                    $this->user[$value] = $this->signature->signaturesFlowVisator->slice($key, 1)->first()->user_id;
                }

            }
        }
    }

    public function configureDocumentType($type_id)
    {
        $this->selectedDocumentType = $type_id;
    }

    public function add($i, $visatorType = 'visador')
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
        array_push($this->visatorType, $visatorType);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        unset($this->visatorType[$i]);
    }

    public function render()
    {
        if($this->inputs){
            $this->requiredVisator = 'required';
        }

        //Agrega los usuarios según unidad organizacional
        foreach ($this->inputs as $key => $value) {
            if (!empty($this->organizationalUnit[$value])) {
                $this->users[$value] = OrganizationalUnit::find($this->organizationalUnit[$value])->users->sortBy('name')->values();
            }
            else{
                $this->users[$value] = [];
                $this->user[$value] = null;
            }
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

        return view('livewire.signatures.visators', compact('ouRoots'));
    }
}
