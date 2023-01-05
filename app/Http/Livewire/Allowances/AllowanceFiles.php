<?php

namespace App\Http\Livewire\Allowances;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Allowances\AllowanceFile;

class AllowanceFiles extends Component
{
    public $allowance;
    public $file;

    public $inputs = [];
    public $i = 1;
    public $count = 0;

    public $form;
    
    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
        $this->count++;
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        $this->count--;
        $this->i--;
    }

    public function render()
    {
        if($this->i == 1 && $this->form == 'create'){
            $this->add($this->i);
        }
        return view('livewire.allowances.allowance-files');
    }

    public function destroy(AllowanceFile $file){
        $file->delete();
        Storage::disk('gcs')->delete($file->file);

        return redirect()
            ->to(route('allowances.edit', $this->allowance))
            ->with('message-danger-file', 'El archivo ha sido eliminado.');
    }
}
