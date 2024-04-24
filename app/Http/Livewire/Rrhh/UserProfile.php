<?php

namespace App\Http\Livewire\Rrhh;

use App\Models\ClCommune;
use App\Models\Parameters\Bank;
use App\Models\User;
use Livewire\Component;

class UserProfile extends Component
{
    public User $user;
    public $bankAccount;
    public $communes;
    public $banks;

    protected $listeners = ['setOrganizationalUnit'];

    protected $rules = [
        'user.name' => 'required',
        'user.fathers_family' => 'required',
        'user.mothers_family' => 'required',
        'user.gender' => 'nullable',
        'user.birthday' => 'nullable|date',
        'user.position' => 'required',
        // 'user.organizational_unit_id' => 'required',

        'user.email' => 'nullable',

        'user.address' => 'nullable',
        'user.commune_id' => 'nullable',
        'user.phone_number' => 'nullable',
        'user.email_personal' => 'nullable',

        'bankAccount.bank_id' => 'nullable|integer',
        'bankAccount.number' => 'nullable',
        'bankAccount.type' => 'nullable',
    ];

    public function mount()
    {
        /** Si el usuario pasado por parametro no es quien está logeado */
        if($this->user->id != auth()->id()) {
            return redirect()->route('rrhh.users.profile',auth()->id());
        }

        $this->communes = ClCommune::pluck('name','id');
        $this->banks = Bank::pluck('name','id');
        // $this->user->load('bankAccount');
        // $this->user->bankAccount;
        $this->bankAccount = $this->user->bankAccount;
    }

    public function setOrganizationalUnit($ou_id)
    {
        $this->user->organizational_unit_id = $ou_id;
    }

    public function save()
    {
        $this->validate();
        $this->user->save();

        // Si los valores vienen vacios, los guardamos como null
        if($this->bankAccount) {
            $this->bankAccount->bank_id = $this->bankAccount->bank_id ?: null;
            $this->bankAccount->type = $this->bankAccount->type ?: null;
            $this->bankAccount->save();
        }


        session()->flash('success', 'Información actualizada exitosamente');
    }

    public function render()
    {
        return view('livewire.rrhh.user-profile');
    }
}
