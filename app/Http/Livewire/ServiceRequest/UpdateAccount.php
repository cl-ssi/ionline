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
        $this->validate();
        
        $this->serviceRequest->bank_id = $this->bank_id;
        $this->serviceRequest->account_number = $this->account_number;        
        $this->serviceRequest->pay_method = $this->pay_method;

        $this->serviceRequest->phone_number = $this->phone_number;
        $this->serviceRequest->email = $this->email;
        $this->serviceRequest->save();
        session()->flash('message', 'Información Bancaria Actualizada Exitosamente');
    }

    public function mount()
    {
        $this->bank_id = $this->serviceRequest->bank_id;
        $this->account_number = $this->serviceRequest->account_number;
        $this->account_type = $this->serviceRequest->account_type;
        $this->pay_method = $this->serviceRequest->pay_method;

        $this->phone_number = $this->serviceRequest->phone_number;
        $this->email = $this->serviceRequest->email;
    }

    public function updateAllSr(){
        $rut = $this->serviceRequest->rut;
        $srs = ServiceRequest::where('rut',$rut)->orderByDesc('id')->get();
        $with_account = $srs->whereNotNull('account_number')->first();
        if($with_account) {
            $bank_id        = $with_account->bank_id;
            $account_number = $with_account->account_number;
            $pay_method     = $with_account->pay_method;
            foreach($srs as $sr) {
                $sr->update(['bank_id' => $bank_id, 'account_number'=>$account_number, 'pay_method'=>$pay_method]);
            }
        }
    }

    public function render()
    {
        //obtener el último ServiRequest del Rut Logeado
        //$this->serviceRequest = ServiceRequest::find(1);
        $this->banks = Bank::all();
        return view('livewire.service-request.update-account');
    }

}
