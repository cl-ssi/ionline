<?php

namespace App\Http\Livewire\Rrhh;

use App\Models\ClCommune;
use App\Models\Parameters\Bank;
use App\User;
use Livewire\Component;

class UserProfile extends Component
{
    public User $user;
    public $bankAccount;
    public $communes;
    public $banks;

    protected $rules = [
        'user.name' => 'required',
        'user.fathers_family' => 'required',
        'user.mothers_family' => 'required',
        'user.gender' => 'required',
        'user.birthday' => 'required',
        'user.position' => 'required',
        
        'user.email' => 'required',
        
        'user.address' => 'required',
        'user.commune_id' => 'required',
        'user.phone_number' => 'required',
        'user.email_personal' => 'required',

        'bankAccount.bank_id' => 'required',
        'bankAccount.number' => 'required|integer',
        'bankAccount.type' => 'required',
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

    public function save()
    {
        $this->validate();
        $this->user->save();
        $this->user->bankAccount()->updateOrCreate(
            ['user_id' => $this->user->id],
            ['bank_id' => $this->bankAccount['bank_id'],
            'number' => $this->bankAccount['number'],
            'type' => $this->bankAccount['type']]
        );
        session()->flash('success', 'Información actualizada exitosamente');
    }

    public function render()
    {
        return view('livewire.rrhh.user-profile');
    }
}
