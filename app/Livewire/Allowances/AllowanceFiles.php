<?php

namespace App\Livewire\Allowances;

use Livewire\Component;

class AllowanceFiles extends Component
{
    public function showFile($key)
    {
        return Storage::response($this->files[$key]['file']);
    }

    // public function render()
    // {
    //     /*
    //     if($this->i == 1 && $this->form == 'create'){
    //         $this->add($this->i);
    //     }
    //     */
    //     return view('livewire.allowances.allowance-files');
    // }

    public function destroy(AllowanceFile $file){
        $file->delete();
        Storage::delete($file->file);

        return redirect()
            ->to(route('allowances.edit', $this->allowance))
            ->with('message-danger-file', 'El archivo ha sido eliminado.');
    }
}
