<?php

namespace App\Livewire\Finance\Receptions;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Finance\Receptions\Reception;

class EditReception extends Component
{
    public Reception $reception;

    public function deleteNumber()
    {
        if($this->reception->numeration) {
            if(Storage::exists($this->reception->numeration->file_path)) {
                Storage::delete($this->reception->numeration->file_path);
            }
            $this->reception->numeration->delete();
        }
    }

    public function deleteApprovals()
    {
        if($this->reception->approvals) {
            foreach($this->reception->approvals as $approval) {
                if(Storage::exists($approval->filename)) {
                    Storage::delete($approval->filename);
                }
                $approval->delete();
            }
        }
    }

    public function deleteItems()
    {
        if($this->reception->items) {
            foreach($this->reception->items as $item) {
                $item->delete();
            }
        }
    }

    public function deleteFiles()
    {
        if($this->reception->files) {
            foreach($reception->files as $file) {
                $file->delete();
                //Todo: Borrar los archivos GCS
            }
        }
    }

    public function deleteReception()
    {
        $this->reception->delete();
        return redirect()->route('finance.receptions.index');
    }

    public function render()
    {
        $this->reception = Reception::find($this->reception->id);

        return view('livewire.finance.receptions.edit-reception');
    }
}
