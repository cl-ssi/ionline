<?php

namespace App\Livewire\Finance\Receptions;

use Livewire\Component;
use App\Models\Finance\Receptions\ReceptionType;

class TypeMgr extends Component
{

    public $formActive = false;

    public $type;


    protected function rules()
    {
        return [

            'type.name' => 'required|min:4',
            'type.title' => 'required|min:4',
        ];
    }

    public function index()
    {
        $this->resetErrorBag();
        $this->formActive = false;
    }


    public function save()
    {
        $this->validate();
        $this->type->establishment_id = auth()->user()->organizationalUnit->establishment_id;
        $this->type->save();
        $this->index();
    }


    public function showForm(ReceptionType $type)
    {
        $this->type = ReceptionType::firstOrNew([ 'id' => $type->id]);
        $this->formActive = true;
    }

    public function render()
    {

        //'classifications' => $classifications

        $types = ReceptionType::where('establishment_id', auth()->user()->organizationalUnit->establishment_id)->latest()->paginate(25);
        return view('livewire.finance.receptions.type-mgr', ['types' => $types]);
    }


    public function delete(ReceptionType $type)
    {
        if ($type->receptions()->count() === 0) {
            $type->delete();
        } else {
            session()->flash('message', 'No se puede eliminar este tipo de acta porque tiene recepciones asociadas.');
        }
    }


}
