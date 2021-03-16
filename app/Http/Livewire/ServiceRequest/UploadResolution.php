<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ServiceRequests\Fulfillment;
use Illuminate\Support\Facades\Storage;

class UploadResolution extends Component
{
    use WithFileUploads;

    public $resolutionFile;
    public $fulfillment;
    public $storage_path = '/service_request/resolutions/';

    public function save()
    {
        $this->validate([
            'resolutionFile' => 'required|mimes:pdf|max:10240', // 10MB Max
        ]);

        $this->resolutionFile->storeAs(
            $this->storage_path, 
            $this->fulfillment->id.'.pdf'
        );

        $this->fulfillment->update(['has_resolution_file' => true]);
    }

    public function delete() {
        Storage::delete($this->storage_path.$this->fulfillment->id.'.pdf');
        $this->fulfillment->update(['has_resolution_file' => false]);
    }

    public function render()
    {
        return view('livewire.service-request.upload-resolution', 
            ['has_resolution_file' => $this->fulfillment->has_resolution_file]);
    }
}
