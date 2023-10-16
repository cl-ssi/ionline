<?php

namespace App\Http\Livewire\His;

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

    protected $rules = [
        'modrequest.type' => 'required',
        'modrequest.subject' => 'required|min:4',
        'modrequest.body' => 'nullable',
        'modrequest.status' => 'nullable',
    ];

    protected $messages = [
        'modrequest.type.required' => 'El tipo es obligatorio.',
        'modrequest.subject.required' => 'El asunto es obligatorio.',
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
        $modrequest = ModificationRequest::make($this->modrequest);
        $modrequest->creator_id = auth()->id();

        $modrequest->save();

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
        return view('livewire.his.new-modification')->extends('layouts.bt4.app');
    }
}
