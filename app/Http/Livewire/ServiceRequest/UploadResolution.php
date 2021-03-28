<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ServiceRequests\ServiceRequest;
use Illuminate\Support\Facades\Storage;

class UploadResolution extends Component
{
    use WithFileUploads;

    public $resolutionFile;
    public $serviceRequest;
    public $storage_path = '/ionline/service_request/resolutions/';

    public function save()
    {
        $this->validate([
            'resolutionFile' => 'required|mimes:pdf|max:10240', // 10MB Max
        ]);

        $this->resolutionFile->storeAs(
            $this->storage_path, 
            $this->serviceRequest->id.'.pdf',
            'gcs'
        );
        
        /* Para google storage agregar al final 'gcs'
        
        $this->resolutionFile->storeAs(
            $this->storage_path, 
            $this->serviceRequest->id.'.pdf',
            'gcs'
        );
        
        */
        

        $this->serviceRequest->update(['has_resolution_file' => true]);
    }

    public function delete() {
        Storage::delete($this->storage_path.$this->serviceRequest->id.'.pdf');
        $this->serviceRequest->update(['has_resolution_file' => false]);
    }

    public function render()
    {
        return view('livewire.service-request.upload-resolution', 
            ['has_resolution_file' => $this->serviceRequest->has_resolution_file]);
    }
}
