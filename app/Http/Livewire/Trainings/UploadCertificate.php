<?php

namespace App\Http\Livewire\Trainings;

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

        $this->training->status = 'complete';
        $this->training->save();

        /*
        if(auth()->guard('external')->check() == true){
            $this->emit('closeModal', 'bootstrap4');
        }
        else{
            $this->emit('closeModal', 'bootstrap5', $this->training->id);
        }

        if(auth()->guard('external')->check() == true){
            session()->flash('message', 'El Certificado se ha guardado correctamente.');
            return redirect()->route('external_trainings.external_own_index');
        }
        else{

        }
        */

        if (auth()->guard('external')->check() == true) {
            $this->emit('closeModal', 'bootstrap4');
            $this->emit('redirectTo', route('external_trainings.external_own_index'));
        } else {
            $this->emit('closeModal', 'bootstrap5', $this->training->id);
            $this->emit('redirectTo', route('trainings.own_index')); // Asegúrate de reemplazar 'your_route_name_here' con tu ruta real
        }
    
        session()->flash('message', 'El Certificado se ha guardado correctamente.');
    }
}
