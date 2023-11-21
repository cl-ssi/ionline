<?php

namespace App\Http\Livewire\Finance\Receptions;

use Livewire\Component;
use App\Models\Finance\Receptions\ReceptionType;

class TypeMgr extends Component
{
    
    public $form = false;

    public $type;


    protected function rules()
    {
        return [
            
            'type.name' => 'required|min:4',
        ];
    }

    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }


    public function save()
    {
        $this->validate();
        $this->type->establishment_id = auth()->user()->organizationalUnit->establishment_id;
        $this->type->save();
        $this->index();
    }


    public function form(ReceptionType $type)
    {
        $this->type = ReceptionType::firstOrNew([ 'id' => $type->id]);
        $this->form = true;
    }

    public function render()
    {

        //'classifications' => $classifications

        $types = ReceptionType::where('establishment_id', auth()->user()->organizationalUnit->establishment_id)->latest()->paginate(25);
        return view('livewire.finance.receptions.type-mgr', ['types' => $types]);
    }
}
