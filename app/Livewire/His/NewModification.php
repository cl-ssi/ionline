<?php

namespace App\Livewire\His;

use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Parameters\Parameter;
use App\Models\His\ModificationRequest;
use App\Models\His\ModificationRequestFile;

class NewModification extends Component
{
    use WithFileUploads;

    public $modrequest;
    public $types;

    public $storage_path = '/ionline/his/files';
    public $files = [];

    public $modificationRequestType;
    public $modificationRequestSubject;
    public $modificationRequestBody;
    public $modificationRequestStatus = null;

    protected $rules = [
        'modificationRequestType' => 'required',
        'modificationRequestSubject' => 'required|min:4',
        'modificationRequestBody' => 'nullable',
        'modificationRequestStatus' => 'nullable',
    ];

    protected $messages = [
        'modificationRequestType.required' => 'El tipo es obligatorio.',
        'modificationRequestSubject.required' => 'El asunto es obligatorio.',
    ];

    /**
    * mount
    */
    public function mount()
    {
        $this->types = explode(',',Parameter::get('his_modifications','tipos_de_solicitudes'));
    }

    /**
    * Guardar
    */
    public function save()
    {
        $this->validate([
            'files.*' => 'file', // 2MB Max
        ]);
        
        $this->validate();
        $modrequest = ModificationRequest::create([
            'type' => $this->modificationRequestType,
            'subject' => $this->modificationRequestSubject,
            'body' => $this->modificationRequestBody,
            'status' => $this->modificationRequestStatus,
            'creator_id' => auth()->id(),
        ]);

        foreach($this->files as $file){
            $filename = $file->getClientOriginalName();
            $filePath = $file->storeAs($this->storage_path, $filename, ['disk' => 'gcs']);

            ModificationRequestFile::create([
                'file' => $filePath,
                'name' => $filename,
                'request_id' => $modrequest->id,
            ]);
        }

        session()->flash('success', 'Se ha creado la nueva solicitud.');
    }

    public function render()
    {
        return view('livewire.his.new-modification');
    }
}
