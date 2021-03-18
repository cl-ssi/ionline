<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use app\Models\ServiceRequests\ServiceRequest;
use App\Models\Parameters\Bank;

class UpdateAccount extends Component
{
    public $bank_id;
    public $banks;
    public $account_number;
    public $pay_method;
    public $serviceRequest;
    //

    protected $rules = [
        'account_number' => 'required',
        'bank_id' => 'required',
        'pay_method' => 'required',
    ];

    protected $messages = [
        'account_number.required' => 'Debe Ingresar Número de Cuenta',
        'bank_id.required' => 'Debe Seleccionar un Banco',
        'pay_method.required' => 'Debe Seleccionar una Forma de Pago',
    ];
    



    public function save()
    {        
        $this->validate();
        
        $this->serviceRequest->bank_id = $this->bank_id;
        $this->serviceRequest->account_number = $this->account_number;        
        $this->serviceRequest->pay_method = $this->pay_method;
        $this->serviceRequest->save();
        session()->flash('message', 'Información Bancaria Actualizada Exitosamente');
    }

    public function mount()
    {
        $this->bank_id = $this->serviceRequest->bank_id;
        $this->account_number = $this->serviceRequest->account_number;
        $this->account_type = $this->serviceRequest->account_type;
        $this->pay_method = $this->serviceRequest->pay_method;
    }

    public function render()
    {
        //obtener el último ServiRequest del Rut Logeado
        //$this->serviceRequest = ServiceRequest::find(1);
        $this->banks = Bank::all();
        return view('livewire.service-request.update-account');
    }

}
