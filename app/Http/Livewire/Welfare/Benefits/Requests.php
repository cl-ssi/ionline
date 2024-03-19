<?php

namespace App\Http\Livewire\Welfare\Benefits;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use App\Models\Welfare\Benefits\Benefit;
use App\Models\Welfare\Benefits\Subsidy;
use App\Models\Welfare\Benefits\Request;
use App\Models\Welfare\Benefits\File;

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

    protected $rules = [
        // 'subsidy.percentage' => 'required',
        // 'subsidy.type' => 'required',
        // 'subsidy.value' => 'required',
        'subsidy.description' => 'required',
        'subsidy.annual_cap' => 'required',
        'subsidy.recipient' => 'required'
    ];


    public function mount()
    {
        $this->benefits = Benefit::all();
        $this->subsidies = collect();
        $this->subsidy = new Subsidy();
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
        if ($value) {
            $benefit = Benefit::find($value);
            $this->subsidies = $benefit->subsidies;
        } else {
            $this->subsidies = collect();
        }
    }

    public function updatedSubsidyId($value)
    {
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
            // 'benefit_id' => 'required',
            'subsidy_id' => 'required',
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
                'status' => 'En revisión'
            ]);
        }

        // Guardar archivos seleccionados
        foreach ($this->files as $file) {
            $filename = $file->getClientOriginalName();
            $fileModel = New File();
            $fileModel->file = $file->store('ionline/well_bnf',['disk' => 'gcs']);
            $fileModel->name = $filename;
            $fileModel->well_bnf_request_id = $request->id;
            $fileModel->save();
        }

        $this->reset(['benefit_id', 'subsidy_id', 'selectedRequestId', 'showCreate']);
    }

    public function showFile($requestId)
    {
        
        $file = File::find($requestId);
        return Storage::disk('gcs')->response($file->file, mb_convert_encoding($file->name,'ASCII'));
    }
    

    public function render()
    {
        $this->requests = Request::with('subsidy')->where('applicant_id',auth()->user()->id)->get();
        return view('livewire.welfare.benefits.requests');
    }
}
