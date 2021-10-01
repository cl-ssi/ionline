<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Establishment;
use App\Rrhh\organizationalUnit;

use App\User;

class EstablishmentOuSearch extends Component
{
    public $establishments;
    public $establishment_id;
    // public $ous;


    public $query;
    public $ous;
    /** Para cuando viene precargado */
    public $ou;
    public $selectedName;
    public $selected_id = 'organizationalunit';
    public $msg_too_many;

    // public function mount()
    // {
    //     $this->establishments = Establishment::all();
    // }

    public function resetx()
    {
        $this->query = '';
        $this->ous = [];
        $this->ou = null;
        $this->selectedName = null;
    }

    public function mount()
    {
        $this->establishments = Establishment::all();

        if($this->ou) {
            $this->setOu($this->ou);
        }
    }

    public function setOu(organizationalunit $ou)
    {
        $this->resetx();
        $this->ou = $ou;
        $this->selectedName = $ou->name;
    }

    public function change(){
      $this->resetx();
    }

    public function updatedQuery()
    {
        $this->ous = organizationalunit::where('establishment_id',$this->establishment_id)
                                         ->where('name','LIKE','%'.$this->query.'%')
                                         ->orderBy('name','Asc')
                                         ->get();
        $this->msg_too_many = false;
    }

    public function render()
    {
        return view('livewire.establishment-ou-search');
    }
}
