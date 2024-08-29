<?php

namespace App\Livewire\Trainings;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadCertificate extends Component
{
    use WithFileUploads;

    public $external;

    public $certificateFile, $attachedFile, $iterationFileClean = 0;

    public $training;

    protected function messages(){
        return [
            'certificateFile.required' => 'Debe ingresar Certificado de Capacitación.',
        ];
    }

    public function mount($training){
        $this->training = $training;
    }

    public function render()
    {
        return view('livewire.trainings.upload-certificate');
    }

    public function save(){
        $validatedData = $this->validate([
            'certificateFile'  => 'required|mimes:pdf|max:10240',
        ]);

        // CREAR O ACTUALIZAR PERMISO
        if($this->certificateFile){
            $now = now()->format('Y_m_d_H_i_s');
            $this->training->files()->updateOrCreate(
                [
                    'id' => null,
                ],
                [
                    'storage_path'  => '/ionline/trainings/attachments/certificate/'.$now.'_certificate_'.$this->training->id.'.'.$this->certificateFile->extension(),
                    'stored'        => true,
                    'name'          => 'certificate_'.$this->training->id.'.pdf',
                    'type'          => 'certificate_file',
                    'stored_by_id'  => (auth()->guard('web')->check() == true) ? auth()->id() : null,
                ]
            );
            $this->certificateFile->storeAs('/ionline/trainings/attachments/certificate', $now.'_certificate_'.$this->training->id.'.'.$this->certificateFile->extension(), 'gcs');
        }

        if($this->attachedFile){
            $now = now()->format('Y_m_d_H_i_s');
            $this->training->files()->updateOrCreate(
                [
                    'id' => null,
                ],
                [
                    'storage_path'  => '/ionline/trainings/attachments/attached/'.$now.'_attached_'.$this->training->id.'.'.$this->attachedFile->extension(),
                    'stored'        => true,
                    'name'          => 'attached_'.$this->training->id.'.pdf',
                    'type'          => 'attached_file',
                    'stored_by_id'  => (auth()->guard('web')->check() == true) ? auth()->id() : null,
                ]
            );
            $this->attachedFile->storeAs('/ionline/trainings/attachments/attached', $now.'_attached_'.$this->training->id.'.'.$this->attachedFile->extension(), 'gcs');
        }

        $this->training->status = 'complete';
        $this->training->save();

        if (auth()->guard('external')->check() == true) {
            $this->dispatch('closeModal', 'bootstrap4');
            $this->dispatch('redirectTo', route('external_trainings.external_own_index'));
        } else {
            $this->dispatch('closeModal', 'bootstrap5', $this->training->id);
            $this->dispatch('redirectTo', route('trainings.own_index')); // Asegúrate de reemplazar 'your_route_name_here' con tu ruta real
        }
    
        session()->flash('message', 'El Certificado se ha guardado correctamente.');
    }
}
