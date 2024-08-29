<?php

namespace App\Livewire\Welfare;

use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeInformationImport;
use App\Models\User;

class WelfareUsersImport extends Component
{
    use WithFileUploads;
    public $file;

    public function import(){

        $this->validate([
            'file' => 'required|mimes:xls|max:10240', // 10MB Max
        ]);

        $file = $this->file;
        $collection = Excel::toCollection(new EmployeeInformationImport, $this->file->path());
        
        $count_inserts = 0;
        $update_array = [];
        try {
            foreach($collection as $row){
                foreach($row as $key => $column){ 
                    if(array_key_exists('rut', $column->toArray()))
                    {
                        if($column['rut']!=null)
                        {
                            $update_array[] = ['rut' => trim($column['rut'])];
                            $count_inserts += 1;
                        }
                    }
                }
            }

            User::where('welfare', true)->update(['welfare' => false]);
            User::whereIn('id', $update_array)->update(['welfare' => true]);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function render()
    {
        return view('livewire.welfare.welfare-users-import');
    }
}
