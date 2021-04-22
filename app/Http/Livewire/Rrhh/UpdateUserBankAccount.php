<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\Models\Rrhh\UserBankAccount;
use App\User;
use App\Models\Parameters\Bank;


class UpdateUserBankAccount extends Component
{

  public $bank_id;
  public $banks;
  public $account_number;
  public $pay_method;
  public $bankaccount;
  public $user;


  protected $rules = [
      'account_number'  => 'required|integer',
      'bank_id'         => 'required',
      'pay_method'      => 'required',
  ];

  protected $messages = [
      'account_number.required'   => 'Debe Ingresar Número de Cuenta',
      'bank_id.required'          => 'Debe Seleccionar un Banco',
      'pay_method.required'       => 'Debe Seleccionar una Forma de Pago',
      'account_number.integer'    => 'Debe Ingresar solo números ej:123456789',
  ];

  public function save()
  {
      $this->validate();
      $userBankAccount  =   UserBankAccount::updateOrCreate(
          ['user_id'    =>  $this->user->id],
          ['bank_id'    =>  $this->bank_id,
           'number'     =>  $this->account_number,
           'type'       =>  $this->pay_method]
      );
      $userBankAccount->save();
      session()->flash('message', 'Información Bancaria Actualizada Exitosamente');
  }

  public function mount()
  {
      if(!is_null($this->bankaccount)){
        $this->bank_id        = $this->bankaccount->bank_id;
        $this->account_number = $this->bankaccount->number;
        $this->pay_method     = $this->bankaccount->type;
        }
  }


    public function render()
    {
        $this->banks = Bank::all();
        return view('livewire.rrhh.update-user-bank-account');
    }
}
