<?php

namespace App\Livewire\Finance\FixedFund;

use App\Models\Finance\FixedFund;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class FormFixedFund extends Component
{
    public FixedFund $fixedFund;

    protected $rules = [
        'fixedFund.concept' => 'required',
        'fixedFund.user_id' => 'required',
        'fixedFund.organizational_unit_id' => 'required',
        'fixedFund.period' => 'required|date:Y-m',
        'fixedFund.total' => 'required|numeric',
        'fixedFund.delivery_date' => 'nullable',
        'fixedFund.rendition_date' => 'nullable',
        'fixedFund.observations' => 'nullable',
        'fixedFund.res_number' => 'nullable',
    ];

    #[On('userSelected')]
    public function userSelected(User $user)
    {
        $this->fixedFund->user_id = $user->id;
        $this->fixedFund->organizational_unit_id = $user->organizational_unit_id;
    }

    public function mount($fixedFund = null)
    {
        $this->fixedFund = $fixedFund ? $fixedFund : new FixedFund();
    }

    public function store()
    {
        $this->fixedFund->period = Carbon::parse($this->fixedFund->period)->format('Y-m-d');
        $this->validate();

        $this->fixedFund->save();

        session()->flash('success','Fondo fijo creado correctamente.');

        return redirect()->route('finance.fixed-fund.index');
    }

    public function render()
    {
        return view('livewire.finance.fixed-fund.form-fixed-fund');
    }
}
