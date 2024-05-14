<?php

namespace App\Http\Livewire\Welfare\Benefits;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use App\Models\Welfare\Benefits\Benefit;
use App\Models\Welfare\Benefits\Subsidy;
use App\Models\Welfare\Benefits\Request;
// use App\Models\Welfare\Benefits\File;
use App\Models\File;
use App\Models\Parameters\Bank;
use App\Models\Rrhh\UserBankAccount;
use App\Models\User;

class Requests extends Component
{
    use WithFileUploads;

    public $requests;
    public $benefits;
    public $subsidies;
    public $showCreate = false;
    public $selectedRequestId;
    public $benefit_id = '';
    public $subsidy_id = '';
    public $subsidy;
    public $files = []; // Variable para almacenar archivos seleccionados
    public $showData = false;

    public $requested_amount;
    public $email;
    public $banks;
    public $bankaccount;
    public $bank_id;
    public $account_number;
    public $pay_method;

    // public $files = [];

    public function addFileInput()
    {
        $this->files[] = null; // Agregar un nuevo campo de archivo
    }

    protected $rules = [
        // 'subsidy.percentage' => 'required',
        // 'subsidy.type' => 'required',
        // 'subsidy.value' => 'required',
        'subsidy.description' => 'required',
        'subsidy.annual_cap' => 'required',
        'subsidy.recipient' => 'required',

        'requested_amount' => 'required|numeric',
        'email' => 'required',
        'account_number' => 'required|integer',
        'bank_id' => 'required',
        'pay_method' => 'required',
    ];

    protected $messages = [
        'requested_amount' => 'Debe ingresar un monto a solicitar',
        'email' => 'Debe ingresar un correo electrónico',
        'account_number.required' => 'Debe Ingresar Número de Cuenta',
        'bank_id.required' => 'Debe Seleccionar un Banco',
        'pay_method.required' => 'Debe Seleccionar una Forma de Pago',
        // 'phone_number.required' => 'Debe Ingresar su Número Telefónico',
        // 'email.required' => 'Debe Ingresar un Correo Electrónico',
        // 'email.email' => 'El Formato del Correo Electrónico no es válido',
        'account_number.integer' => 'Debe Ingresar solo números ej:123456789',
    ];


    public function mount()
    {
        $this->benefits = Benefit::all();
        $this->subsidies = collect();
        $this->subsidy = new Subsidy();

        $this->banks = Bank::all();
        $this->bankaccount = auth()->user()->bankAccount;

        $this->email = auth()->user()->email;

        if($this->bankaccount){
            if ($this->bankaccount->bank) {
              $this->bank_id = $this->bankaccount->bank_id;
              $this->account_number = $this->bankaccount->number;
              $this->pay_method = $this->bankaccount->type;
            }
        }
    }

    public function showCreateForm()
    {
        $this->showCreate = !$this->showCreate;
        if (!$this->showCreate) {
            $this->reset(['benefit_id', 'subsidy_id', 'subsidy']);
        }
    }

    public function updatedBenefitId($value)
    {
        $this->showData = false;
        if ($value) {
            $benefit = Benefit::find($value);
            $this->subsidies = $benefit->subsidies->sortBy('name');
        } else {
            $this->subsidies = collect();
        }
    }

    public function updatedSubsidyId($value)
    {
        $this->showData = true;
        if ($value) {
            $this->subsidy = Subsidy::find($value);
        } else {
            $this->subsidy = new Subsidy();
        }
    }

    public function editRequest($requestId)
    {
        $request = Request::find($requestId);
        $this->benefit_id = $request->benefit_id;
        $this->subsidy_id = $request->subsidy_id;
        $this->selectedRequestId = $requestId;
        $this->showCreate = true;
    }

    public function deleteRequest($requestId)
    {
        $request = Request::find($requestId);
        $request->delete();
    }

    public function saveRequest()
    {
        $this->validate([
            'requested_amount' => 'required|numeric',
            'email' => 'required',
            'account_number' => 'required|integer',
            'bank_id' => 'required',
            'pay_method' => 'required',
            'subsidy_id' => 'required',
            'files.*' => 'nullable|file|mimes:pdf|max:2048', // Maximum of 2MB
        ]);

        // se hace asi la validación puesto que hay documentación y requisitos. En este caso solo se consideran documentación.
        $count = 0;
        if($this->subsidy->documents->count() > 0){
            foreach($this->subsidy->documents as $document){
                if($document->type == "Documentación"){
                    $count += 1;
                }
            }

            if($count != count($this->files)){
                session()->flash('message', 'Debe adjuntar toda la documentación solicitada.');
                return;
            }
        }

        if ($this->selectedRequestId) {
            $request = Request::find($this->selectedRequestId);
            $request->update([
                // 'benefit_id' => $this->benefit_id,
                'subsidy_id' => $this->subsidy_id,
            ]);
        } else {
            $request = Request::create([
                // 'benefit_id' => $this->benefit_id,
                'subsidy_id' => $this->subsidy_id,
                'applicant_id' => auth()->user()->id,
                'status' => 'En revisión',
                'requested_amount' => $this->requested_amount,
            ]);
        }

        // Guardar archivos seleccionados
        foreach ($this->files as $key => $file) {
            $request->files()->create([
                'storage_path' => $file->store('ionline/welfare/benefits',['disk' => 'gcs']),
                'stored' => true,
                'name' => $this->subsidy->documents[$key]->name,
                'valid_types' => json_encode(["pdf", "xls"]),
                'max_file_size' => 10,
                'stored_by_id' => auth()->id(),
            ]);
        }

        // guarda email
        $user = User::updateOrCreate(
            ['id' => auth()->user()->id],
            ['email' => $this->email]
        );

        // guarda datos bancarios
        $userBankAccount = UserBankAccount::updateOrCreate(
            ['user_id' => auth()->user()->id],
            ['bank_id' => $this->bank_id,
             'number' => $this->account_number,
             'type' => $this->pay_method]
        );

        $this->reset(['benefit_id', 'subsidy_id', 'selectedRequestId', 'showCreate']);
        session()->flash('message', 'Estimado funcionario hemos recibido su solicitud de beneficio, en este momento se encuentra "En revisión".');
    }

    public function showFile($requestId)
    {
        $file = File::find($requestId);
        return Storage::disk('gcs')->response($file->storage_path, mb_convert_encoding($file->name,'ASCII'));
    }

    public function render()
    {
        $this->requests = Request::with('subsidy')->where('applicant_id',auth()->user()->id)->get();
        return view('livewire.welfare.benefits.requests');
    }
}
