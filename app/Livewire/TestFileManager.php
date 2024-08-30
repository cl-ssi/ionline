<?php

namespace App\Livewire;

use App\Models\File as ModelsFile;
use App\Models\Finance\Receptions\Reception;
use App\Traits\UploadFilesTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;

class TestFileManager extends Component
{
    use UploadFilesTrait;

    /**
     * Variable to contains all uploaded files
     *
     * @var mixed
     */
    public $filesAll;

    public function mount()
    {
        $this->filesAll = collect();
    }

    public function render()
    {
        return view('livewire.test-file-manager');
    }

    /**
     * Save
     */
    public function save()
    {
        /**
         * Set the reception
         */
        $reception = Reception::find(1);

        /**
         * Iterate all files
         */
        foreach($this->filesAll as $itemFile)
        {
            /**
             * Set the folder, name and extension
             */
            $folder = 'test';

            $name = Str::random();

            $extension = File::extension($itemFile['temporaryFile']);

            Storage::disk('gcs')->put("$folder/$name.$extension" , File::get($itemFile['temporaryFile']));

            /**
             * Create the File model with the data
             */
            $modelFile = ModelsFile::create([
                'storage_path' => $folder,
                'stored' => true,

                'name' => "$name.$extension",
                'type' => 'anexo',

                'input_title' => 'Archivo',
                'input_name' => 'file',
                'required' => true,
                'valid_types' => 'pdf',
                'max_file_size' => 20,
                'stored_by_id' => auth()->id(),

                'fileable_type' => get_class($reception),
                'fileable_id' => $reception->id,
            ]);
        }

        session()->flash('success', 'Los archivos fueron cargados exitosamente');

        $this->restoreComponent();
    }
}
