<?php

namespace App\Livewire\Welfare\Benefits;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Welfare\Benefits\Benefit;
use App\Models\Welfare\Benefits\Subsidy;
use App\Models\Welfare\Benefits\Request;
use App\Notifications\Welfare\Benefits\RequestCreate;
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
    public $benefit_id = '';
    public $subsidy_id = '';
    public $subsidy;
    public $files = []; // Variable para almacenar archivos seleccionados
    public $showData = false;

    public $requested_amount;
    public $email;
    // public $banks;
    // public $bankaccount;
    // public $bank_id;
    // public $account_number;
    // public $pay_method;
    public $user_id;
    public $newFile;
    public $showFileInput = false;

    protected $rules = [
        'subsidy.description' => 'required',
        'subsidy.annual_cap' => 'required',
        'subsidy.recipient' => 'required',
        'user_id' => 'required|numeric',
        'requested_amount' => 'required|numeric',
        // 'email' => 'required|email',
        // 'account_number' => 'required|regex:/^\d+$/',
        // 'bank_id' => 'required|integer',
        // 'pay_method' => 'required|string',
        'subsidy_id' => 'required|integer',
        'files.*' => 'nullable|file|mimes:pdf|max:5120', // Maximum of 5MB
    ];

    protected $messages = [
        'user_id.required' => 'Debe seleccionar un funcionario',
        'requested_amount.required' => 'Debe ingresar un monto a solicitar',
        'requested_amount.numeric' => 'El monto solicitado debe ser un número.',
        // 'email.required' => 'El correo electrónico es obligatorio.',
        // 'email.email' => 'Debe ingresar un correo electrónico válido.',
        // 'account_number.required' => 'El número de cuenta es obligatorio.',
        // 'account_number.regex' => 'Debe ingresar solo números en el número de cuenta, ej: 01300239397.',
        // 'bank_id.required' => 'El ID del banco es obligatorio.',
        // 'bank_id.integer' => 'El ID del banco debe ser un número entero.',
        // 'pay_method.required' => 'El método de pago es obligatorio.',
        // 'pay_method.string' => 'El método de pago debe ser una cadena de texto.',
        'subsidy_id.required' => 'El ID del subsidio es obligatorio.',
        'subsidy_id.integer' => 'El ID del subsidio debe ser un número entero.',
        'files.*.file' => 'Cada archivo debe ser un archivo válido.',
        'files.*.mimes' => 'Cada archivo debe ser un PDF.',
        'files.*.max' => 'Cada archivo no debe ser mayor a 5MB.',
    ];


    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->benefits = Benefit::all();
        $this->subsidies = collect();
        $this->subsidy = new Subsidy();

        // $this->banks = Bank::all();
        // $this->bankaccount = auth()->user()->bankAccount;
        // $this->email = auth()->user()->email;

        // if($this->bankaccount){
        //     if ($this->bankaccount->bank) {
        //       $this->bank_id = $this->bankaccount->bank_id;
        //       $this->account_number = $this->bankaccount->number;
        //       $this->pay_method = $this->bankaccount->type;
        //     }
        // }else{
        //     $this->bank_id = null;
        //     $this->account_number = null;
        //     $this->pay_method = null;
        // }
    }

    protected $listeners = ['loadUserData' => 'loadUserData'];

    public function loadUserData(User $User){
        $this->user_id = $User->id;

        // $this->banks = Bank::where('active_agreement',true)->get();
        // $this->bankaccount = $User->bankAccount;

        // $this->email = $User->email;

        // if($this->bankaccount){
        //     if ($this->bankaccount->bank) {
        //       $this->bank_id = $this->bankaccount->bank_id;
        //       $this->account_number = $this->bankaccount->number;
        //       $this->pay_method = $this->bankaccount->type;
        //     }
        // }else{
        //     $this->bank_id = null;
        //     $this->account_number = null;
        //     $this->pay_method = null;
        // }
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

    public function saveRequest()
    {
        $this->validate([
            'requested_amount' => 'required|numeric',
            // 'email' => 'required|email', // Asegúrate de validar el formato del correo electrónico
            // 'account_number' => 'required|regex:/^\d+$/', // Verifica que contiene solo dígitos
            // 'bank_id' => 'required|integer',
            // 'pay_method' => 'required|string',
            'subsidy_id' => 'required|integer',
            'files.*' => 'nullable|file|mimes:pdf|max:5120', // Maximum of 5MB
        ], [
            'requested_amount.required' => 'El monto solicitado es obligatorio.',
            'requested_amount.numeric' => 'El monto solicitado debe ser un número.',
            // 'email.required' => 'El correo electrónico es obligatorio.',
            // 'email.email' => 'Debe ingresar un correo electrónico válido.',
            // 'account_number.required' => 'El número de cuenta es obligatorio.',
            // 'account_number.regex' => 'Debe ingresar solo números en el número de cuenta, ej: 01300239397.',
            // 'bank_id.required' => 'El ID del banco es obligatorio.',
            // 'bank_id.integer' => 'El ID del banco debe ser un número entero.',
            // 'pay_method.required' => 'El método de pago es obligatorio.',
            // 'pay_method.string' => 'El método de pago debe ser una cadena de texto.',
            'subsidy_id.required' => 'El ID del subsidio es obligatorio.',
            'subsidy_id.integer' => 'El ID del subsidio debe ser un número entero.',
            'files.*.file' => 'Cada archivo debe ser un archivo válido.',
            'files.*.mimes' => 'Cada archivo debe ser un PDF.',
            'files.*.max' => 'Cada archivo no debe ser mayor a 5MB.',
        ]);

        // se hace asi la validación puesto que hay documentación y requisitos. En este caso solo se consideran documentación.
        $count = 0;
        // if($this->subsidy->documents->count() > 0){
        //     foreach($this->subsidy->documents as $document){
        //         if($document->type == "Documentación"){
        //             $count += 1;
        //         }
        //     }

        //     if($count != count($this->files)){
        //         session()->flash('message', 'Debe adjuntar toda la documentación solicitada.');
        //         return;
        //     }
        // }

        $request = Request::create([
            // 'benefit_id' => $this->benefit_id,
            'subsidy_id' => $this->subsidy_id,
            'applicant_id' => $this->user_id,
            'status' => 'En revisión',
            'requested_amount' => $this->requested_amount,
        ]);

        // Guardar archivos seleccionados
        foreach ($this->files as $key => $file) {
            if($file){
                $request->files()->create([
                    'storage_path' => $file->store('ionline/welfare/benefits',['disk' => 'gcs']),
                    'stored' => true,
                    'name' => $file->getClientOriginalName(),
                    'valid_types' => json_encode(["pdf", "xls"]),
                    'max_file_size' => 10,
                    'stored_by_id' => auth()->id(),
                ]);
            }
        }

        // guarda email
        $user = User::updateOrCreate(
            ['id' => $this->user_id]
            // ['email' => $this->email]
        );

        // // guarda datos bancarios
        // $userBankAccount = UserBankAccount::updateOrCreate(
        //     ['user_id' => $this->user_id],
        //     ['bank_id' => $this->bank_id,
        //     'number' => $this->account_number,
        //     'type' => $this->pay_method]
        // );

        // envia notificación
        if($request->applicant){
            if($request->applicant->email_personal != null){
                // Utilizando Notify 
                $request->applicant->notify(new RequestCreate($request));
            } 
        }

        $this->reset(['benefit_id', 'subsidy_id', 'showCreate', 'files', 'requested_amount', 'newFile', 'showFileInput']);

        session()->flash('message', 'Estimado funcionario hemos recibido su solicitud de beneficio, en este momento se encuentra "En revisión".');
    }


    public function showFile($requestId)
    {
        $file = File::find($requestId);
        return Storage::response($file->storage_path, mb_convert_encoding($file->name,'ASCII'));
    }

    public function enableFileInput()
    {
        $this->showFileInput = true;
    }

    public function addFileInput()
    {
        $this->files[] = null; // Agregar un nuevo campo de archivo
    }

    public function saveFile($request_id)
    {
        $this->validate([
            'newFile' => 'required|file|mimes:pdf|max:2048', // Maximum of 2MB
        ]);

        if ($this->newFile) {
            $request = Request::find($request_id);

            if (!$request) {
                session()->flash('message', 'Solicitud no encontrada.');
                return;
            }

            $file = new File();
            $file->storage_path = $this->newFile->store('ionline/welfare/benefits', ['disk' => 'gcs']);
            $file->stored = true;
            $file->name = $this->newFile->getClientOriginalName();
            $file->valid_types = json_encode(["pdf", "xls"]);
            $file->max_file_size = 10;
            $file->stored_by_id = auth()->id();

            $request->files()->save($file);

            // Reset the newFile input and hide the file input
            $this->newFile = null;
            $this->showFileInput = false;

            // Update the list of requests to reflect the changes
            $this->requests = Request::with('subsidy')->where('applicant_id', auth()->user()->id)->orderByDesc('id')->get();

            session()->flash('message', 'Archivo agregado correctamente.');
        }
    }

    public function deleteFile($fileId)
    {
        $file = File::find($fileId);
        
        if ($file) {
            // Elimina el archivo del almacenamiento
            Storage::delete($file->storage_path);
            
            // Elimina el registro de la base de datos
            $file->delete();

            // Actualiza la lista de solicitudes para reflejar los cambios
            $this->requests = Request::with('subsidy')->where('applicant_id',auth()->user()->id)->orderByDesc('id')->get();

            session()->flash('message', 'Archivo eliminado correctamente.');
        } else {
            session()->flash('message', 'Archivo no encontrado.');
        }
    }

    public function render()
    {
        $this->requests = Request::with('subsidy')->where('applicant_id',auth()->user()->id)->orderByDesc('id')->get();
        return view('livewire.welfare.benefits.requests');
    }
}
