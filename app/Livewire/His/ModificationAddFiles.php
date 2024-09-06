<?php

namespace App\Livewire\His;

use Livewire\Component;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use App\Models\His\ModificationRequestFile;

class ModificationAddFiles extends Component
{
    use WithFileUploads;
 
    public $storage_path = '/ionline/his/files';
    public $file;
 
    public function save()
    {
        $this->validate([
            'file' => 'file|max:12288', // 1MB Max
        ]);

        $filename = $this->file->getClientOriginalName();
        $filePath = $this->file->storeAs($this->storage_path, $filename, ['disk' => 'gcs']);

        ModificationRequestFile::create([
            'file' => $filePath,
            'name' => $filename,

        ]);
    }

    // public function deleteAttachment(Attachment $attachment){
    //     $attachment->delete();
    //     Storage::delete($attachment->file);
    //     session()->flash("message", "Su Archivo adjunto ha sido eliminado.");
    //     $this->fulfillment->refresh();
    // }

    public function render()
    {
        return view('livewire.his.modification-add-files');
    }
}
