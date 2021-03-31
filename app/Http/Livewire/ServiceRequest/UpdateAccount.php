<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use app\Models\ServiceRequests\ServiceRequest;
use App\Models\Rrhh\UserBankAccount;
use App\User;
use App\Models\Parameters\Bank;

class UpdateAccount extends Component
{
    public $bank_id;
    public $banks;
    public $account_number;
    public $pay_method;
    public $serviceRequest;

    public $phone_number;
    public $email;
    //

    protected $rules = [
        'account_number' => 'required',
        'bank_id' => 'required',
        'pay_method' => 'required',
        'phone_number' => 'required',
        'email' => 'required|email',
    ];

    protected $messages = [
        'account_number.required' => 'Debe Ingresar Número de Cuenta',
        'bank_id.required' => 'Debe Seleccionar un Banco',
        'pay_method.required' => 'Debe Seleccionar una Forma de Pago',
        'phone_number.required' => 'Debe Ingresar su Número Telefónico',
        'email.required' => 'Debe Ingresar un Correo Electrónico',
        'email.email' => 'El Formato del Correo Electrónico no es válido',
    ];




    public function save()
    {
      // dd($this->serviceRequest->employee);
        $this->validate();

        // $this->serviceRequest->employee->bankAccount->bank_id = $this->bank_id;
        // $this->serviceRequest->employee->bankAccount->number = $this->account_number;
        // $this->serviceRequest->employee->bankAccount->type = $this->pay_method;
        // $this->serviceRequest->employee->bankAccount->save();

        //devuelve user o lo crea
        $userBankAccount = UserBankAccount::updateOrCreate(
            ['user_id' => $this->serviceRequest->employee->id],
            ['bank_id' => $this->bank_id,
             'number' => $this->account_number,
             'type' => $this->pay_method]
        );

        $user = User::updateOrCreate(
            ['id' => $this->serviceRequest->employee->id],
            ['phone_number' => $this->phone_number,
             'email' => $this->email]
        );

        // $this->serviceRequest->employee->phone_number = $this->phone_number;
        // $this->serviceRequest->employee->email = $this->email;
        $this->serviceRequest->phone_number = $this->phone_number;
        $this->serviceRequest->email = $this->email;

        $this->serviceRequest->save();
        session()->flash('message', 'Información Bancaria Actualizada Exitosamente');
    }

    public function mount()
    {
        if ($this->serviceRequest->employee->bankAccount) {
          $this->bank_id = $this->serviceRequest->employee->bankAccount->bank_id;
          $this->account_number = $this->serviceRequest->employee->bankAccount->number;
          $this->pay_method = $this->serviceRequest->employee->bankAccount->type;
        }

        $this->phone_number = $this->serviceRequest->employee->phone_number;
        $this->email = $this->serviceRequest->employee->email;
    }

    public function render()
    {
        $this->banks = Bank::all();
        return view('livewire.service-request.update-account');
    }

}
