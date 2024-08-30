<?php

namespace App\Livewire\Rrhh;

use App\Models\ClCommune;
use App\Models\Parameters\Bank;
use App\Models\User;
use Livewire\Attributes\On;
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

    protected function anyBankAccountFieldFilled()
    {
        return !empty($this->bankAccount['bank_id']) || !empty($this->bankAccount['number']) || !empty($this->bankAccount['type']);
    }

    protected function allBankAccountFieldsEmpty()
    {
        return empty($this->bankAccount['bank_id']) && empty($this->bankAccount['number']) && empty($this->bankAccount['type']);
    }

    public function mount()
    {
        /** Si el usuario pasado por parametro no es quien está logeado */
        if($this->user->id != auth()->id()) {
            return redirect()->route('rrhh.users.profile',auth()->id());
        }

        $this->communes = ClCommune::pluck('name','id');
        $this->banks = Bank::where('active_agreement',true)->pluck('name','id');
        $this->bankAccount = $this->user->bankAccount;
    }

    #[On('setOrganizationalUnit')]
    public function setOrganizationalUnit($ou_id)
    {
        $this->user->organizational_unit_id = $ou_id;
    }

    public function save()
    {
        $this->validate();

        // Custom validation for bankAccount fields
        if ($this->anyBankAccountFieldFilled()) {
            $this->validate([
                'bankAccount.bank_id' => 'required|integer',
                'bankAccount.number' => 'required',
                'bankAccount.type' => 'required',
            ]);
        }

        $this->user->save();

        // Check if all bankAccount fields are empty
        if ($this->allBankAccountFieldsEmpty()) {
            // Delete the bankAccount relationship if all fields are empty
            $this->user->bankAccount()->delete();
        } else {
            // Save the bankAccount data
            // Check if is an array or object
            if (!is_array($this->bankAccount)) {
                $this->bankAccount = $this->bankAccount->toArray();
            }
            $this->user->bankAccount()->updateOrCreate([], $this->bankAccount);
        }


        session()->flash('success', 'Información actualizada exitosamente');
    }

    public function render()
    {
        return view('livewire.rrhh.user-profile');
    }
}
